<?php 
// require_once './backend/db.php';
if ($orderNumber) {
$stmt_note_retrieve = $conn->prepare("SELECT * FROM order_notes WHERE order_number = ?");
$stmt_note_retrieve->bind_param('s', $orderNumber);
$stmt_note_retrieve->execute();
$audit_events_result = $stmt_note_retrieve->get_result();

while ($audit_data_row = $audit_events_result->fetch_assoc()) {
    echo $audit_data_row['note_text'];
}
$stmt_note_retrieve->close();
} else {
    echo "===== ReceiveFlow – Portfolio Demo =====
Inspired by real-world warehouse receiving workflows.

To try the system:

1. Scan or type an order number in the field above
2. Demo orders available: 1001 – 1099
3. Suggested order: 1001

After scanning an order you can view:
• Expected items list
• Receiving scan progress
• Order notes
• Audit history

Note:
This public demo is read-only to protect the dataset.

Data Notice:
All data shown in this demo is fictional and used only for demonstration purposes.";
}

?>