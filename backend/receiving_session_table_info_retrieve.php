<?php 
$stmt_receivingSession_retrieve = $conn->prepare("SELECT *
                        FROM receiving_sessions
                        WHERE order_number = ?");
$stmt_receivingSession_retrieve->bind_param('s', $orderNumber);
$stmt_receivingSession_retrieve->execute();

$expected_item_info = $stmt_receivingSession_retrieve->get_result();
$dataFetch = $expected_item_info->fetch_assoc();
$sessionStatus = $dataFetch['status'];

$stmt_receivingSession_retrieve->close();
?>