<?php 
session_start();
require_once './backend/db.php';
require_once './config/app.php';
// require_once '/backend/user_fetch.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReceiveFlow</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./frontend/receiveflow_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div id="page-lock" aria-hidden="false"></div>
    <div id="header-nav">
        <div style='font-size: 35px; padding-bottom: -20px;' id='header-title'>
            <a href="./" style="text-decoration: none; color: rgb(1, 106, 234); cursor: pointer;  display: flex; justify-content: center; align-items: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">            
                <!-- <img src="" alt="" style='width:70px; height:auto;'>   -->
                ReceiveFlow
            </a>
        </div>
        <div>
            <a href="./dashboard.php" id='dashboard-link'>Dashboard</a>
            <a href="./" id='recevingFlow-link' style='color: #028cba;'><i class='fa-solid fa-barcode'></i> Receiving Flow</a>
            <a href="./aboutthisproject.php" id='about-link'>About This Project</a>
        </div>
    </div>
        <hr>

    <div id='main-nav'>
        <div id='note-side'>

        </div>

        <div id='center-nav'>
            <div id="receiving-nav">
                <p id='receiving-title'>Receiving Workspace</p>
            </div>

            <div id='order-scan-nav'>
                <form action="" method="get" id="order-form">
                    <input type='text' placeholder='scan order number here' name='orderNumber' id='scan-box'>
                    <div class='space-10px'></div>
                </form>
                <button id='btn-new-order' class='new-order-button button_style' onclick="newOrder()"><i class='fa fa-refresh'></i> New Order</button>
                <script src="./backend/new_order.js"></script>
            </div>

            <?php require_once './backend/expected_table_info_retrieve.php';?>
            <?php require_once './backend/receiving_session_table_info_retrieve.php';?>
            <?php $hidden = $orderNumber ? '' : 'display: none;';?>
            <div id='order-header' style='<?php echo $hidden; ?>'>
                <div>
                    <p id='order-number-label'><span style='font-weight: bold;'>Order Number:</span> <?php echo $orderNumber_Fetch ? $orderNumber_Fetch : 'N/A'; ?></p>
                    <p id='session-status-label'> <span style='font-weight: bold;'>Session Status:</span>
                        <?php 
                        if ($order_session_open) {
                            echo "<span style='color: green;'>OPEN</span>";
                        } else if ($order_session_close) {
                            echo "<span style='color: red;'>CLOSED</span>";
                        } else {
                            echo "<span style='color: gray;'>N/A</span>";
                        }
                        ?>
                    </p>
                </div>
                <div>
                    <p id='institution-label'><span style='font-weight: bold;'>Institution:</span> <?php echo $institutionFetch ? $institutionFetch : 'N/A'; ?></p>
                    <input type="hidden" id="session-id" value="<?php echo (int)$sessionID; ?>" style='padding-top: 10px;'>
                    <input type="hidden" id="order-number" value="<?php echo $orderNumber_Fetch; ?>" style='padding-top: 10px;'>
                    <br>
                    <br>
                </div>
            </div>

            <?php require_once './backend/upc_scan_box.php';?>
            <div id='upc-scan-nav' class='<?php echo $upcScan; ?>'>
                <form action="" method='post' id='upc-form'>
                    <input type="text" placeholder='scan upc here' id='upc-scan-box' onclick="" autofocus>
                </form>
            </div>

            <div id='search-content-nav'>
                <div>
                    <?php require_once './backend/headers.php'; ?>
                </div>

                <div id='order-content-block'>
                <?php require_once './backend/order_content.php'; ?>
                </div>
            </div>
            <?php 
                if ($sessionID == 'OPEN') {
                    $submit_note_button = "Submit";
                } else {
                    $submit_note_button = "Add Note";
                }
            ?>
        </div>

        <div id='order-audit'>
            <div id='order-audit-input'> 
                <p style='font-weight: bold; text-decoration: underline;'><i class="fa-solid fa-clock-rotate-left"></i> History: </p>
                <?php require_once './backend/audit_events.php';
                ?>
            </div>
        </div>
    </div>




        <?php require_once './frontend/submit_addnote_button.php';?>
        <div id='order-note'>
            <form action="" method='post' id='order-note-form'>
                <label for="notes" style='font-weight: bold;'><i class="fa-solid fa-pen-to-square"></i> Notes</label>
                <textarea id='order-note-input' name='notes' type="text"><?php require_once './backend/order_notes_display.php';?></textarea>
                <?php 
                    if ($demoMode) {
                        echo "<button class='submit-button $hiddenClass' id='note-submit-button-demo' onclick='alert(\"Public demo: Editing disabled.\"); return false;'>$submit_addnote_button</button>";
                    } else {
                        echo "<button class='submit-button " . $hiddenClass . "' id='note-submit-button'>" . $submit_addnote_button . "</button>";                 
                    }
                ?>
                <script src="./backend/submit_button_location.js"></script>
            </form>
            <?php require_once './backend/order_notes_updates.php';?>
        </div>
    



    <div id="footer">
        <p>© <?= date('Y') ?> ReceiveFlow — Developed by Nam Ho</p>
    </div>
    <script src='./frontend/upc_scan.js'></script>
    <script src="./scripts.js"></script>
    <script src='./frontend/move_order_note.js'></script>
</body>
</html>