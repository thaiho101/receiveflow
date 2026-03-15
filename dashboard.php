<?php 
session_start();
// require_once './backend/db.php';
// require_once '/backend/user_fetch.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./frontend/dashboard_style.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
    <div id="header-nav" style='position: sticky; top: 0;'>
        <div style='font-size: 35px; padding-bottom: -20px;' id='header-title'>
            <a href="./" style="text-decoration: none; color: rgb(1, 106, 234); cursor: pointer;  display: flex; justify-content: center; align-items: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">            
                <!-- <img src="" alt="" style='width:70px; height:auto;'>   -->
                ReceiveFlow
            </a>
        </div>        
        <div>
            <a href="./dashboard.php" id='dashboard-link' style='color: #028cba;'><i class="fa-solid fa-chart-column"></i> Dashboard</a>
            <a href="./" id='recevingFlow-link'>Receiving Flow</a>
            <a href="./aboutthisproject.php" id='about-link'>About This Project</a>
        </div>
    </div>



<script>
function openPrintPage()
{
    window.open(
        './backend/print_labels.php',
        '_blank'
    );
}
</script>


    <div style='position: sticky; top: 30px; z-index: 1000; margin-top: 0; background-color: white; height: 1px;'>
        <hr>
    </div>
       
    <div id="dashboard-title" style='position: sticky; top: 35px; z-index: 1000; margin-top: 0; background-color: transparent;'>
        <p id='receiving-title'><i class="fa-solid fa-chart-column"></i> Dashboard</p>
    </div>

    <div style='display: flex; justify-content: end; z-index: 999; position: fixed; right: 135px; top: 13px;'>
        <a href="./backend/downloadCSV.php?download=true">
            <button class='download-button'>
                <i class="fa-solid fa-download"></i> Download Report
            </button>
        </a>
    </div>
    <div style='display: flex; justify-content: end; z-index: 999; position: fixed; right: 20px; top: 13px;'>
        <button class='printButton' onclick="openPrintPage()">
            <i class="fa fa-print"></i> Print Labels
        </button>
    </div>

    <div id='dashboard-nav'>
        <div class='institution-summary'>
            <?php require_once './backend/overview.php'; ?>
        </div>

        <div id='right-side-status'>
            <div style='width: 100%; display: flex; justify-content: center;'>
                <?php require_once './backend/po_generation.php';?>
            </div>

            <div id='donutChart_totalItems_between_all_Institutions' style='width: 100%; display: flex; justify-content: center;'></div>
            <div id='columnChart_totalOrderItem_between_all_Institutions' style="width: 100%; display: flex; justify-content: center;"></div>
        </div>
    </div>







    <div id="footer">
        © <?= date('Y') ?> ReceiveFlow — Developed by Nam Ho
    </div>

<script src='./frontend/dashboard_barCharts.js'></script>
<script src='./frontend/dashboard_donutCharts.js'></script>
<script src='./frontend/dashboard_totalInstitutionPie.js'></script>
<script src='./frontend/dashboard_totalOrderItemInstitution.js'></script>


    <!-- <script src="./scripts.js"></script> -->
</body>
</html>