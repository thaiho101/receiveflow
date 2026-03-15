<?php 
// require_once 'db.php';
if ($order_exist_expectedItems->num_rows > 0) {
    echo "<table border='0' id='order-content-table'>";

    while ($dataRow = $order_exist_expectedItems->fetch_assoc()) {
        $itemType = $dataRow['item_type'];
        $logoEmbQty = $dataRow['logo_emb_qty'];
        $persEmbQty = $dataRow['pers_emb_qty'];
        if (!$dataRow['scanned_qty']) {
            $scanQty = 0;
        } else {
            $scanQty = $dataRow['scanned_qty'];
        }
        if ($itemType == 'top') {
            if ($logoEmbQty > 0 && $persEmbQty == 0) {
                $itemType = 'Embroidery: Right Sleeve (Logo)';
            } else if ($logoEmbQty == 0 && $persEmbQty > 0) {
                $itemType = ' Embroidery: Left Chest (Personalization)';
            } else if ($logoEmbQty > 0 && $persEmbQty > 0) {
                $itemType = 'Embroidery: Right Sleeve (Logo) + Left Chest (Personalization)';
            }
        } else {
            $itemType = '';
        }
        
        if ($dataRow['item_type'] == 'lab' || $dataRow['item_type'] == 'jacket' || $dataRow['item_type'] == 'polo') {
                if ($logoEmbQty > 0 && $persEmbQty == 0) {
                    $itemType = 'Embroidery: Left Chest (Logo)';
                } else if ($logoEmbQty == 0 && $persEmbQty > 0) {
                    $itemType = 'Embroidery: Left Chest (Personalization)';
                }
                 else if ($logoEmbQty > 0 && $persEmbQty > 0) {
                    $itemType = 'Embroidery: Left Chest (Logo + Personalization)';
                }
        }

        if ($dataRow['expected_qty'] == $scanQty) {
            $statusChecked_DB = "<i class='fa fa-circle-check' style='color: rgb(2, 187, 2);'></i>";
        } else if (($dataRow['expected_qty'] > $scanQty) && ($scanQty != 0)) {
            $statusChecked_DB = "<i class='fas fa-box-open' style='color: darkorange;'></i>";
        } else {
            $statusChecked_DB = "";
        }

        $scanQty_color = ($scanQty == 0) ? "black" : "blue";

        if ($dataRow['item_type'] == 'top') {
            $item_type_name = 'Top';
        } else if ($dataRow['item_type'] == 'jacket') {
            $item_type_name = 'Jacket';
        } else if ($dataRow['item_type'] == 'lab') {
            $item_type_name = 'Lab Coat';
        } else if ($dataRow['item_type'] == 'polo') {
            $item_type_name = 'Polo';
        } else {
            $item_type_name = 'Bottom';
        }

        if ($order_session_close) {
            $disable = "disabled";
            $disableClass = "disable-class";
            $blurClass = "blur-nav";
        } else {
            $disable = "";
            $disableClass = "";
        }
        // $disable = $order_session_close ? "disabled" : "";

        $detailRow = ($itemType) ? "non-border-bottom" : "border-bottom";
        echo "<tr class='$detailRow $blurClass'><td class='dataCenter' style='width:200px;'>" . $dataRow['sku'] . 
        "</td><td class='dataCenter blur_data' style='width:100px;'>" . $item_type_name . 
        "</td><td class='dataCenter upc' style='width:220px;'>" . $dataRow['upc'] . 
        "</td><td class='dataCenter expected' style='width:50px;'>" . $dataRow['expected_qty'] . 
        "</td><td class='dataCenter scanned' style='width:25px; padding-left: 10px; text-align: right; color: $scanQty_color;'>" . $scanQty . "</td>
        </td><td class='dataCenter full-checked' style='width:10px;'>$statusChecked_DB</td>
        <td class='dataCenter plus-action plus' style='width:40px; padding-left: 10px;'><button " . $disable . " class='add-button " . $disableClass . "' data-id='" . $dataRow['expected_id'] . "'><i class='fa fa-plus'></i></button></td></tr>";
        if ($itemType) {
            echo "<tr class='border-bottom $blurClass'><td></td>
        <td colspan='2' style='font-style: italic; color: orange;'>" . $itemType . "</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td></tr>";
        }
    }
    echo "</table>";
} else {
    if ($orderNumber === "") {
        echo "<p style='color: rgb(218, 118, 3);'><i class='fa fa-barcode' style='color: black;'></i> Please scan an order number in the field above.</p>";
    } else if ($demoMode) {
        echo "<p style='color: red;'>Public Demo: Editing disabled</p>";
    } else
        echo "<p style='color: red;'>The order number: $orderNumber does not exist.</p>";
}
?>