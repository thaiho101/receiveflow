<?php

$stmt_expectedItems_retrieve = $conn->prepare("SELECT *
                        FROM expected_items
                        WHERE order_number = ?");
$stmt_expectedItems_retrieve->bind_param('s', $orderNumber);
$stmt_expectedItems_retrieve->execute();

$expected_item_info = $stmt_expectedItems_retrieve->get_result();
$dataFetch = $expected_item_info->fetch_assoc();
$orderNumber_Fetch = $dataFetch['order_number'];
$institutionFetch = $dataFetch['institution'];
$stmt_expectedItems_retrieve->close();

?>