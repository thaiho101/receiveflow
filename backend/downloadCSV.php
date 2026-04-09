<?php
require_once __DIR__ . '/../config/database.php';

// Check if the request came from the form/button click (adjust as needed for GET/POST)
if (isset($_POST['download']) || isset($_GET['download'])) {
    $date = date('Y-m-d');

        // Set headers to force download
    header('Content-Type: text/csv; charset=utf-8');
    // Suggests a filename
    header('Content-Disposition: attachment; filename="receiving_report_' . $date . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Receiving Embroidery Summary Report']);
    fputcsv($output, ['Date:', $date]);
    fputcsv($output, ['']);
    // fputcsv($output, ['Institution', 'Total Order', 'Right Sleeves', 'Left Chest']);
    fputcsv($output, ['Institution', 'Total Order', 'Total Item', 'Total Scrub Top', 'Total Jacket', 'Total Labcoat', 'Total Polo', 'Total Personalized',  'Total Right Sleeves', 'Total Left Chest']);

    $stmt_sum = $conn->prepare("SELECT i.institution,
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
                                ORDER BY i.institution");
    $stmt_sum->execute();
    $result_sum = $stmt_sum->get_result();

    $rows = [];
    $idx = 1;
    $donutIdx = 1;
    $letter = 'D';
    $num = 5;

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
        fputcsv($output, [$data_sum['institution'], $data_sum['total_orders'], $row['total_items'], $data_sum['total_top'], $data_sum['total_jacket'], $data_sum['total_labcoat'], $data_sum['total_polo'], $data_sum['total_personalized'], 
                        '=' . 'C' . $num, '=sum(D' . $num . ':G' . $num . ')']);
        // $letter++;
        $num++;
    }
    $stmt_sum->close();
    // Close the file pointer
    fclose($output);
    
    // Stop the script to prevent any other output
    exit();
}
?>
