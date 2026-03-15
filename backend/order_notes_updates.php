<?php 
require_once './config/database.php';
require_once './config/app.php';

if ($demoMode) {
 
} else {
   // $userName = $_COOKIE['receiveflow_user'] ?? '';
    $scannedBy = $_SESSION['userName'] ?? 'Unknown';

    $stmt_session_ID = $conn->prepare("SELECT session_id FROM receiving_sessions WHERE order_number = ? ORDER BY started_at DESC LIMIT 1");
    $stmt_session_ID->bind_param('s', $orderNumber);
    $stmt_session_ID->execute();
    $result = $stmt_session_ID->get_result();
    $data_session_row = $result->fetch_assoc();
    $sessionID = $data_session_row['session_id'] ?? null;


    $stmt_audit_events = $conn->prepare("SELECT * FROM order_notes WHERE order_number = ?");
    $stmt_audit_events->bind_param('s', $orderNumber);
    $stmt_audit_events->execute();
    $audit_events_result = $stmt_audit_events->get_result();
    $is_note_old = $audit_events_result->fetch_assoc();


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notes'])) {
        if($is_note_old && $is_note_old['note_text'] === $_POST['notes']) {
            // If the note is the same, do nothing
            $stmt_audit_events->close();
            header("Location: /?orderNumber=" . urlencode($orderNumber));
            exit;
        }

        $stmt_notes_updates = $conn->prepare("INSERT INTO order_notes (order_number, note_text) VALUES (?, ?) ON DUPLICATE KEY UPDATE note_text = VALUES(note_text)");
        $stmt_notes_updates->bind_param('ss', $orderNumber, $_POST['notes']);
        $stmt_notes_updates->execute();
        $stmt_notes_updates->close();

        $eventType = 'NOTE_UPDATE';
        $stmt_session_add = $conn->prepare("INSERT INTO receiving_audit_events (session_id, order_number, event_type, created_by) VALUES (?, ?, ?, ?)");
        $stmt_session_add->bind_param('iiss', $sessionID, $orderNumber, $eventType, $scannedBy);
        $stmt_session_add->execute();
        // echo "Name - SESSION OPENED";

        $stmt_session_add->close();
        $stmt_session_ID->close();
        // header("Location: ../receiveflow/?orderNumber=" . urlencode($orderNumber));
        header("Location: /?orderNumber=" . urlencode($orderNumber));
        exit;
    }
}

?>