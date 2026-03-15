<?php
require_once __DIR__ . '/../config/database.php';

$stmt = $conn->prepare("
    SELECT 
        i.institution,
        i.po_number,
        SUM(CASE WHEN i.item_type = 'top' THEN s.scanned_qty ELSE 0 END) AS scrub_top,
        SUM(CASE WHEN i.item_type = 'jacket' THEN s.scanned_qty ELSE 0 END) AS fleece_jacket,
        SUM(CASE WHEN i.item_type = 'lab' THEN s.scanned_qty ELSE 0 END) AS labcoat,
        SUM(CASE WHEN i.item_type = 'polo' THEN s.scanned_qty ELSE 0 END) AS polo
    FROM receiving_scans s
    JOIN receiving_sessions r ON r.session_id = s.session_id
    JOIN expected_items i ON i.order_number = s.order_number AND i.upc = s.upc
    WHERE r.status = 'CLOSE'
    GROUP BY i.institution, i.po_number
    ORDER BY i.institution
");

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Print Labels</title>

<style>

body{
    font-family: Arial;
}

.print-block{
    width: 700px;
    border: 3px solid black;
    margin: 20px auto;
    page-break-after: always;
}

.header{
    padding:10px;
}

.institution{
    font-size:36px;
    font-weight:bold;
    text-align:center;
}

.po{
    font-size:24px;
    padding:5px;
}

table{
    width:100%;
    border-collapse:collapse;
}

td{
    border:3px solid black;
    text-align:center;
    padding:10px;
    font-size:22px;
}

th{
    border:3px solid black;
    font-size:20px;
}

.printButton {
    font-size: 12px;
    padding: 7px;
    background:linear-gradient(#c8e2fc,#7abafa);
    border:none;
    padding:6px 10px;
    border-radius:10px;
    font-weight: 500;
    box-shadow:0 3px 6px rgba(0,0,0,0.15);
    cursor:pointer;
    transition: box-shadow 0.2s ease-in-out;

    box-shadow: inset 1px 1px 2px #87CEFA, 
            inset -1px 2px 2px rgb(255, 255, 255),
            inset 0 0 15px white,
            inset 5px 0px 2px #ffffffd9,
            1px 1.5px 5px rgba(128, 128, 128, 0.46);
}

.printButton:hover {
    box-shadow: 1px 1px 5px rgb(234, 234, 234);
    box-shadow: inset 0px 0px 2px #87CEFA, 
        inset -1px 2px 10px rgb(255, 255, 255),
        inset 0 0 15px white,
        inset 5px 0px 2px #ffffffd9,
        1px 1.5px 2px rgba(128, 128, 128, 0.46);
}

.printButton:active {
    border: .5px inset rgba(226, 224, 224, 0.654);
}

@media print{
    button{
        display:none;
    }
}

</style>

</head>

<body>

<div style='display: flex; width: 100%; justify-content: right;'>
    <button onclick="window.print()" class='printButton'>Print</button>
</div>




<?php
while($row = $result->fetch_assoc())
{
    $total = 
        $row['scrub_top'] +
        $row['fleece_jacket'] +
        $row['labcoat'] +
        $row['polo'];
?>
<p style='width: 100%; display: flex; justify-content: right;'>Total: box(es)</p>
<div class="print-block">

<div class="header">
    <div style='display: flex; justify-content: space-between; width: 92%;'>
        <b>From: Metro Uniforms</b>
        <b>To: Embroidery Company</b>
    </div>

    <div style='display: flex; justify-content: space-between;'>
        <b>Address: <span style='font-style:italic'>123 Main St, City, State</span></b>
        <b>Address: <span style='font-style:italic'>456 Main St, City, State</span></b>
    </div>
</div>

<div class="po">
    PO#: ABC<?php echo date('Y');?>EMB01<?= htmlspecialchars($row['po_number']) ?>
</div>

<div class="institution">
<?= htmlspecialchars($row['institution']) ?>
</div>



<table>

<tr>
<th>Scrub Top</th>
<th>Fleece Jacket</th>
<th>Lab Coat</th>
<th>Polo</th>
<th>Total Item(s)</th>
</tr>

<tr>
<td><?= $row['scrub_top'] ?></td>
<td><?= $row['fleece_jacket'] ?></td>
<td><?= $row['labcoat'] ?></td>
<td><?= $row['polo'] ?></td>
<td><?= $total ?></td>
</tr>

</table>

</div>

<?php
}
?>

</body>
</html>
