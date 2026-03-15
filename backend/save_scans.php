<?php
session_start();
header('Content-Type: application/json');

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

try {
    require_once __DIR__ . '/../config/database.php';

    //php://input is a read-only stream that allows you to read raw data from the request body.
    //For instance, {"session_id": 123, "order_number": "1001", "scans": {"UPC001": 2, "UPC002": 3}, "scanned_by": "user1"}
    $raw = file_get_contents("php://input");
    $data = json_decode($raw, true);

    if (!$data || !isset($data['session_id'], $data['order_number'], $data['scans'])) {
        echo json_encode(["status" => "error", "message" => "Invalid payload", "raw" => $raw]);
        exit;
    }

    $session_id = (int)$data['session_id'];
    $order_number = trim((string)$data['order_number']);
    $scans = $data['scans'];
    $is_scans_valid = false;

    if ($session_id <= 0 || $order_number === '') {
        echo json_encode(["status" => "error", "message" => "Missing session_id/order_number"]);
        exit;
    }

    $scanned_by = $_SESSION['userName'] ?? null;

    $stmt = $conn->prepare(" INSERT INTO receiving_scans (session_id, order_number, upc, scanned_qty, scanned_by)
                            VALUES (?, ?, ?, ?, ?)
                            ON DUPLICATE KEY UPDATE 
                                scanned_qty = VALUES(scanned_qty),
                                scanned_by  = VALUES(scanned_by)
    ");

    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
        exit;
    }

    foreach ($scans as $upc => $qty) {
        $upc = trim((string)$upc);
        $qty = (int)$qty;

        if ($upc === '' || $qty <= 0) continue;

        $stmt->bind_param("issis", $session_id, $order_number, $upc, $qty, $scanned_by);
        if (!$stmt->execute()) {
            echo json_encode(["status" => "error", "message" => "Execute failed: " . $stmt->error, "upc" => $upc]);
            exit;
        }
        $is_scans_valid = true;
    }

    if ($is_scans_valid) {
    $eventType = 'SCAN';
    $stmt_audit_scan = $conn->prepare("INSERT INTO receiving_audit_events (session_id, order_number, event_type, created_by) VALUES (?, ?, ?, ?)");
    $stmt_audit_scan->bind_param('iiss', $session_id, $order_number, $eventType, $scanned_by);
    if (!$stmt_audit_scan->execute()) {
        echo json_encode(["status" => "error", "message" => "Audit log failed: " . $stmt_audit_scan->error]);
        $stmt_audit_scan->close();
        exit;
    }
    $stmt_audit_scan->close();
    }


    $stmt_check = $conn->prepare("SELECT SUM(e.expected_qty) AS total_expected,
                                        SUM(IFNULL(r.scanned_qty, 0)) AS total_scanned
                                FROM expected_items e
                                LEFT JOIN receiving_scans r
                                    ON e.order_number = r.order_number
                                    AND e.upc = r.upc
                                    AND r.session_id = ?
                                WHERE e.order_number = ?");

    $stmt_check->bind_param("is", $session_id, $order_number);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    $row = $result ? $result->fetch_assoc() : null;

    $total_expected = (int)($row['total_expected'] ?? 0);
    $total_scanned = (int)($row['total_scanned'] ?? 0);
    
    $stmt_check->close();

    $stmt_receivingSession_retrieve = $conn->prepare("SELECT *
                        FROM receiving_sessions
                        WHERE order_number = ?");
    $stmt_receivingSession_retrieve->bind_param('s', $order_number);
    $stmt_receivingSession_retrieve->execute();

    $expected_item_info = $stmt_receivingSession_retrieve->get_result();
    $dataFetch = $expected_item_info->fetch_assoc();
    $sessionStatus = $dataFetch['status'];

    $stmt_receivingSession_retrieve->close();

    if ($total_expected > 0 && $total_scanned >= $total_expected) {
        $stmt_update = $conn->prepare("UPDATE receiving_sessions SET status = 'CLOSE', closed_at = NOW() WHERE session_id = ?");
        $stmt_update->bind_param("i", $session_id);
        if (!$stmt_update->execute()) {
            echo json_encode(["status" => "error", "message" => "Session close failed: " . $stmt_update->error]);
            $stmt_update->close();
            exit;
        }
        $stmt_update->close();

        if ($sessionStatus !== 'CLOSE') {
            $eventType = 'SESSION_CLOSE';
            $stmt_audit_close = $conn->prepare("INSERT INTO receiving_audit_events (session_id, order_number, event_type, created_by) VALUES (?, ?, ?, ?)");
            $stmt_audit_close->bind_param('iiss', $session_id, $order_number, $eventType, $scanned_by);
            if (!$stmt_audit_close->execute()) {
                echo json_encode(["status" => "error", "message" => "Audit log failed: " . $stmt_audit_close->error]);
                $stmt_audit_close->close();
                exit;
            }
            $stmt_audit_close->close();
        }
    }


    echo json_encode(["status" => "success"]);
} catch (Throwable $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
