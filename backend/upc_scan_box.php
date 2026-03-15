<?php 
if ($order_exist_expectedItems->num_rows > 0 && 
($order_session_open == true || $session_not_exist->num_rows == 0)) {
    $upcScan = "upc-scan-nav";
} else {
    $upcScan = "upc-scan-nav-hidden";
    $blur_data = "blur_data";
}
?>