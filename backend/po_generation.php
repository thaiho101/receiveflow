<?php 
// require_once '../config/database.php';
$stmt_institution_count_for_po = $conn->prepare("
    SELECT i.institution
    FROM receiving_scans s
    JOIN receiving_sessions r ON r.session_id = s.session_id
    JOIN expected_items i ON i.order_number = s.order_number AND i.upc = s.upc
    WHERE r.status = 'CLOSE' AND i.po_number IS NULL
    GROUP BY i.institution
    ORDER BY i.institution
");
$stmt_institution_count_for_po->execute();
$result_for_po = $stmt_institution_count_for_po->get_result();


echo "<table border='1' class='po-table'>";
echo "
<tr><th colspan='3' style='height: 30px; border-top-left-radius: 10px; border-top-right-radius: 10px;'><button class='generate-button' onclick='alert(\"This button is disabled on purpose. It is included only to illustrate how the PO generation process works.\")'><i class='fa-solid fa-file-invoice'></i> Generate PO</button></th></tr>
<tr><th>PO Number</th><th colspan='2'>ABC" . date('Y') . "EMB01</th></tr>
        <tr><th>Institution</th><th colspan='1' style='font-weight: bold;'>Embroidery Location</th>
                        <th>Total Boxes</th></tr>";
while ($data_sum = $result_for_po->fetch_assoc()) {
    echo "<tr><td>{$data_sum['institution']}</td>
            <td><select>
                <option value='Location selection'>Location</option>
                <option value='Location A'>Dallas Store</option>
                <option value='Location B'>FWD Store</option>
                <option value='Location C'>Plano</option>
            </select></td>
            <td> <select>
                    <option value='0'>0</option>
                    <option value='1'>1</option>
                    <option value='2'>2</option>
                    <option value='3'>3</option>
                    <option value='4'>4</option>
                    <option value='5'>5</option>
                    <option value='6'>6</option>
                    <option value='7'>7</option>
                    <option value='8'>8</option>
                    <option value='9'>9</option>
                    <option value='10'>10</option>
            </select> Box(es)</td></tr>";
}               
echo "</table>";
$stmt_institution_count_for_po->close();
?>