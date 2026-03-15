<?php
require_once __DIR__ . '/../config/database.php';

$stmt_sum = $conn->prepare("
    SELECT i.institution,
           COUNT(DISTINCT s.order_number) AS total_orders,
           SUM(CASE WHEN i.item_type = 'top'    THEN s.scanned_qty ELSE 0 END) AS total_top,
           SUM(CASE WHEN i.item_type = 'jacket' THEN s.scanned_qty ELSE 0 END) AS total_jacket,
           SUM(CASE WHEN i.item_type = 'lab'    THEN s.scanned_qty ELSE 0 END) AS total_labcoat,
           SUM(CASE WHEN i.item_type = 'polo'   THEN s.scanned_qty ELSE 0 END) AS total_polo,
           SUM(CASE WHEN i.pers_emb_qty > 0     THEN s.scanned_qty ELSE 0 END) AS total_personalized
    FROM receiving_scans s
    JOIN receiving_sessions r ON r.session_id = s.session_id
    JOIN expected_items i ON i.order_number = s.order_number AND i.upc = s.upc
    WHERE r.status = 'CLOSE' AND i.po_number IS NULL
    GROUP BY i.institution
    ORDER BY i.institution
");
$stmt_sum->execute();
$result_sum = $stmt_sum->get_result();

$rows = [];
$idx = 1;
$donutIdx = 1;

while ($data_sum = $result_sum->fetch_assoc()) {
    $institution = $data_sum['institution'] ?? 'Unknown Institution';

    $row = [
        'institution' => $institution,
        'total_orders' => (int)$data_sum['total_orders'],
        'total_top' => (int)$data_sum['total_top'],
        'total_jacket' => (int)$data_sum['total_jacket'],
        'total_labcoat' => (int)$data_sum['total_labcoat'],
        'total_polo' => (int)$data_sum['total_polo'],
        'total_personalized' => (int)$data_sum['total_personalized'],
    ];
    $row['total_items'] = $row['total_top'] + $row['total_jacket'] + $row['total_labcoat'] + $row['total_polo'];
    $rows[] = $row;

    echo "<label style='font-weight: bold;'>{$idx}. {$institution}</label>";
        echo "<div id='institution_nav'>";
    echo "<div class='institution-block' style='width: 60%;'>";
    echo "<table border='1' class='summary-tables' style='border-collapse: collapse; width: 95%; height: 120px; background-color: #ffffff; text-align: center;'>";
    echo "
        <tr><th colspan='7' style='text-align:center;font-weight:bold; height:10px;'>{$institution}</th></tr>
        <tr style='text-align:center;'>
            <th rowspan='3'></th>
            <th rowspan='3' style='font-weight:bold; width:50px;'>Order</th>
            <th colspan='5' style='font-weight:bold; height:10px;'>Embroidery Position</th>
        </tr>
        <tr style='text-align:center; height:10px;'>
            <th style='; width:80px;'>Right Sleeves</th>
            <th colspan='4'>Left Chest</th>
        </tr>
        <tr style='text-align:center; height:10px;'>
            <th>Scrub Top</th>
            <th style='; width:60px;'>Jacket</th>
            <th style='; width:80px;'>Labcoat</th>
            <th style='; width:60px;'>Polo</th>
            <th style='; width:90px;'>Personalized</th>
        </tr>
        <tr style='text-align:center;font-weight:bold;height:30px;'>
            <td style='width:50px;'>Total</td>
            <td style='font-size:20px;'>{$row['total_orders']}</td>
            <td style='font-size:20px;'>{$row['total_top']}</td>
            <td style='font-size:20px;'>{$row['total_jacket']}</td>
            <td style='font-size:20px;'>{$row['total_labcoat']}</td>
            <td style='font-size:20px;'>{$row['total_polo']}</td>
            <td style='font-size:20px;'>{$row['total_personalized']}</td>
        </tr>
    ";


    echo "</table>";
    echo "<div style='display: flex; justify-content: space-evenly; padding-top: 10px;'>
                <div id ='barChart_$idx' style='width:100%;height:100%;'>
                </div>
            </div>
        </div>";
    // echo "<hr style='width: 70%; margin-left: 0;'>";
    echo "<div style='display: flex;  flex-direction: column; justify-content: space-evenly; width: 40%; height: 300px;'>
            <div id='donutChart_$idx' style='width: 100%; height: 100%; padding-top: 30px;'>
            </div>
        </div>";
    echo "</div>";
    $idx++;
    $donutIdx++;
}
// style='display: flex; justify-content: space-evenly; padding-top: 10px;'
$stmt_sum->close();
?>
<script>
  // PHP -> JS (JSON)
  window.dashboardData = <?= json_encode($rows, JSON_UNESCAPED_UNICODE) ?>;
</script>
