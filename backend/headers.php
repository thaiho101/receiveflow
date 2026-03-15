<?php
if ($order_session_close) {
    $blurClass = "blur-nav";
}
if ($order_exist_expectedItems->num_rows > 0) {
    echo "<table border='0'>";
    echo "<tr class='$blurClass'><td id='institution' class='dataCenter'>SKU</td>
            <td id='item-type' class='dataCenter'>Item Type</td>
            <td id='upc' class='dataCenter'>Upc</td>
            <td id='expected-qty' class='dataCenter'>Expected Qty</td>
            <td id='scanned-qty' class='dataCenter'>Scanned Qty</td>
            <td id='action' class='dataCenter'>Action</td> 
            </tr>";
    echo "</table>";
}
?>