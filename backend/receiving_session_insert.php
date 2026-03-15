<?php 
if ($order_exist_expectedItems->num_rows > 0 && $session_not_exist->num_rows == 0) {
    $status = 'OPEN';
    $stmt_session_add = $conn->prepare("INSERT INTO receiving_sessions (order_number, started_at, status) VALUES (?, NOW(), ?)");
    $stmt_session_add->bind_param('ss', $orderNumber, $status);
    $stmt_session_add->execute();
    // echo "Session just added./SESSION OPENED";

    $stmt_session_add->close();
}
?>