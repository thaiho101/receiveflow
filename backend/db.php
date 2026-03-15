<?php 
require_once __DIR__ . '/../config/database.php';

$orderNumber = $_GET['orderNumber'] ?? '';
$upcScan = "upc-scan-nav-hidden";
$blur_data = "";
$order_session_open = false;
$order_session_close = false;
$order_exist_expectedItems = null;
$session_not_exist_rows = 0;
$data_session_row = null;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['orderNumber'])) {
    $orderNumber = $_GET['orderNumber'];


    $stmt_expectedItems = $conn->prepare("SELECT e.expected_id, e.institution, e.item_type, e.upc, e.expected_qty, r.scanned_qty, e.sku, e.logo_emb_qty, e.pers_emb_qty
                            FROM expected_items e
                            LEFT JOIN receiving_scans r ON e.order_number = r.order_number AND e.upc = r.upc
                            WHERE e.order_number = ?");
    $stmt_expectedItems->bind_param('s', $orderNumber);
    $stmt_expectedItems->execute();

    $order_exist_expectedItems = $stmt_expectedItems->get_result();

    $stmt_session_open = $conn->prepare("SELECT * FROM receiving_sessions WHERE order_number = ? ORDER BY started_at DESC LIMIT 1");
    $stmt_session_open->bind_param('s', $orderNumber);
    $stmt_session_open->execute();
    $stmt_session_open_result = $stmt_session_open->get_result();
    $data_session_row = $stmt_session_open_result->fetch_assoc();
    if ($data_session_row['status'] == 'OPEN') {
        $order_session_open = true;
        $order_session_close = false;
    } else if ($data_session_row['status'] == 'CLOSE') {
        $order_session_open = false;
        $order_session_close = true;
    }
    $session_not_exist = $stmt_session_open_result;

}
require_once __DIR__ . '/receiving_session_insert.php';
require_once __DIR__ . '/order_notes_updates.php';
require_once __DIR__ . '/receiving_audit_insert.php';

?>