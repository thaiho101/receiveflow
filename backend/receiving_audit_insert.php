<?php 
require_once './backend/db.php';

$scannedBy = $_SESSION['userName'] ?? 'Unknown';
// echo $scannedBy;
// echo $orderNumber;

$stmt_session_ID = $conn->prepare("SELECT session_id FROM receiving_sessions WHERE order_number = ? ORDER BY started_at DESC LIMIT 1");
$stmt_session_ID->bind_param('s', $orderNumber);
$stmt_session_ID->execute();
$result = $stmt_session_ID->get_result();
$data_session_row = $result->fetch_assoc();
$sessionID = $data_session_row['session_id'] ?? null;

if ($order_exist_expectedItems->num_rows > 0 && $session_not_exist->num_rows == 0) {
    $eventType = 'SESSION_OPEN';
    $stmt_session_add = $conn->prepare("INSERT INTO receiving_audit_events (session_id, order_number, event_type, created_by) VALUES (?, ?, ?, ?)");
    $stmt_session_add->bind_param('iiss', $sessionID, $orderNumber, $eventType, $scannedBy);
    $stmt_session_add->execute();
    // echo "Name - SESSION OPENED";

    $stmt_session_add->close();
    $stmt_session_ID->close();
}
?>