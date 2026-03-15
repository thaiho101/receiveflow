<?php
// session_start();
// require_once __DIR__ . '/db.php';

// if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//   header('Location: ../index.php');
//   exit;
// }

// $orderNumber = $_POST['orderNumber'] ?? '';
// $sessionId    = $_POST['sessionId'] ?? '';
// $upc          = trim($_POST['upc'] ?? '');

// if ($orderNumber === '' || $sessionId === '' || $upc === '') {
//   header('Location: ../index.php?orderNumber=' . urlencode($orderNumber));
//   exit;
// }

// // (tuỳ bạn) user quét
// $scannedBy = $_SESSION['username'] ?? null;

// // Upsert: nếu đã có (session_id, upc) thì cộng scanned_qty
// $stmt = $conn->prepare("
//   INSERT INTO receiving_scans (session_id, order_number, upc, scanned_qty, scanned_by)
//   VALUES (?, ?, ?, 1, ?)
//   ON DUPLICATE KEY UPDATE
//     scanned_qty = scanned_qty + 1,
//     scanned_at = CURRENT_TIMESTAMP,
//     scanned_by = VALUES(scanned_by)
// ");

// $stmt->bind_param('isss', $sessionId, $orderNumber, $upc, $scannedBy);
// $stmt->execute();

// // quay lại trang để tiếp tục scan, focus vẫn ở input (autofocus)
// header('Location: ../index.php?orderNumber=' . urlencode($orderNumber));
// exit;
?>