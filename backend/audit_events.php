<?php
// $scannedBy = $_SESSION['userName'] ?? null;
// echo $scannedBy;

$stmt_audit_events = $conn->prepare("SELECT * FROM receiving_audit_events WHERE order_number = ?");
$stmt_audit_events->bind_param('s', $orderNumber);
$stmt_audit_events->execute();
$audit_events_result = $stmt_audit_events->get_result();

while ($audit_data_row = $audit_events_result->fetch_assoc()) {
    $identity = $audit_data_row['created_by'] ?? 'Unknown';
    $dateTime = date('m/d/Y h:i A', strtotime($audit_data_row['created_at'])) ?? 'Unknown time';
    if ($audit_data_row['event_type'] == 'SESSION_OPEN') {
    echo "[" . $dateTime . "] <span style='color: rgb(1, 162, 1);'>SESSION OPEN</span>:<br><i class='fas fa-lock-open' style='color: green;'></i> Order # " . $audit_data_row['order_number'] . " started." . " (by " . $identity . ")<br><br>";
    } else if ($audit_data_row['event_type'] == 'SESSION_CLOSE') {
        echo "[" . $dateTime . "] <span style='color: red;'>SESSION CLOSE</span>:<br><i class='fas fa-lock' style='color: red;'></i> Order # " . $audit_data_row['order_number'] . " closed.<br><i class='fa fa-check' style='color: green;'></i> All items received. Session closed." . " </br>(by " . $identity . ")<br><br>";
    } else if ($audit_data_row['event_type'] == 'NOTE_UPDATE') {
        echo "[" . $dateTime . "] <span style='color: #ff8c00;'>NOTE</span>:<br><i class='fas fa-pencil-alt' style='color: #ff8c00;'></i> Note updated (by " . $identity . ")<br><br>";
    } else if ($audit_data_row['event_type'] == 'SCAN') {
        echo "[" . $dateTime . "] <span style='color: blue;'>SCAN</span>:<br> <i class='fas fa-sync' style='color: blue;'></i> Scans updated (by " . $identity . ")<br><br>";
    }
}
$stmt_audit_events->close();
?>