<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About This Project - ReceiveFlow</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./frontend/receiveflow_style.css">
<style>

body{
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    /* margin:0; */
    background:#f7fbfd;
    color:#222;
    /* line-height:1.65; */
}


.about-wrapper{
    max-width:950px;
    margin:40px auto 80px;
    background:white;
    padding:40px;
    border-radius:14px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

.hero-title{
    font-size:34px;
    color:#0b4f8a;
}

.hero-subtitle{
    font-size:18px;
    color:#555;
    margin-bottom:30px;
}

.overview{
    background:#eef7fc;
    border-left:5px solid #00BFFF;
    padding:18px;
    border-radius:8px;
    margin-bottom:35px;
}

h2{
    margin-top:40px;
    border-bottom:2px solid #e8f4fb;
    padding-bottom:6px;
    color:#114b7a;
}

.feature-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
    margin-top:20px;
}

.feature-card{
    border:1px solid #e3eef6;
    border-radius:10px;
    padding:16px;
    background:#fbfdff;
}

.feature-card h3{
    margin-top:0;
    font-size:18px;
}

.diagram{
    background:#111820;
    color:#e6fbff;
    padding:20px;
    border-radius:10px;
    margin-top:18px;
    overflow-x:auto;
}

.diagram pre{
    margin:0;
    font-family:Consolas,monospace;
}

.footer{
    margin-top:50px;
    text-align:center;
    color:#666;
    font-size:14px;
}

@media(max-width:800px){
.feature-grid{
grid-template-columns:1fr;
}

.about-wrapper{
margin:20px;
padding:25px;
}

.hero-title{
font-size:28px;
}
}

</style>
</head>

<body>

    <div id="header-nav" style='position: sticky; top: 0; z-index: 1000; background-color: white;'>
        <div style='font-size: 35px; padding-bottom: -20px;' id='header-title'>
            <a href="./" style="text-decoration: none; color: rgb(1, 106, 234); cursor: pointer;  display: flex; justify-content: center; align-items: center; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">            
                <!-- <img src="" alt="" style='width:70px; height:auto;'>   -->
                ReceiveFlow
            </a>
        </div>        
        <div>
            <a href="./dashboard.php" id='dashboard-link'></i> Dashboard</a>
            <a href="./" id='recevingFlow-link'>Receiving Flow</a>
            <a href="./aboutthisproject.php" id='about-link' style='color: #028cba;'><i class="fa-solid fa-circle-info"></i> About This Project</a>
        </div>
    </div>
<hr>

<div class="about-wrapper">

<div class="hero-title">About This Project</div>
<div class="hero-subtitle">ReceiveFlow — Order Receiving and Embroidery Preparation System</div>

<div class="overview">
<strong>ReceiveFlow</strong> is a workflow system I designed to improve order receiving and embroidery preparation for large uniform orders. 
Instead of relying on manual sorting and spreadsheet-based tracking, the system allows staff to load an order, scan items, validate quantities, and keep a traceable receiving history.
</div>

<h2><i class="fa-solid fa-circle-info"></i> Background</h2>

<p>
This project was inspired by workflow challenges I observed in warehouse receiving operations in the uniform supply industry.
Large orders often included many employees under the same organization, with each order containing different garment types and embroidery requirements.
</p>

<p>
Some garments required only a standard logo, while others also required personalized embroidery such as employee names or titles.
Embroidery placement also varied by garment type, including scrub tops, jackets, lab coats, and polos.
</p>

<p>
Because of these variations, staff had to manually sort items, identify embroidery requirements, count quantities, and prepare garments for embroidery.
Preparing orders accurately could take up to <strong>one week</strong>, and mistakes were difficult to trace once items were mixed together.
</p>

<p>
I first created a structured spreadsheet to improve the process, but spreadsheets still lacked audit logging, validation rules, and workflow accountability.
That limitation led me to design and build a dedicated system instead.
</p>

<h2><i class="fa-solid fa-lightbulb"></i> The Solution</h2>

<p>
ReceiveFlow replaces the manual process with an order-based receiving workflow.
</p>

<p>
Staff begin by scanning or entering an <strong>order number</strong>. Once the order is loaded, the system displays expected items, item types, and expected quantities.
Staff can then scan UPC codes for each item, and the system validates scans against expected order data in real time.
</p>

<p>
Important actions such as scan submissions, note updates, and session changes are recorded as audit events.
This provides much better visibility into receiving progress and makes troubleshooting easier when discrepancies occur.
</p>

<h2><i class="fa-solid fa-gears"></i> Key Features</h2>

<div class="feature-grid">

<div class="feature-card">
<h3><i class="fa-solid fa-boxes-stacked"></i> Order-Based Workflow</h3>
<ul>
<li>Load expected items by order number</li>
<li>Track receiving progress per order</li>
<li>Organize embroidery preparation around the order workflow</li>
</ul>
</div>

<div class="feature-card">
<h3><i class="fa-solid fa-barcode"></i> UPC Validation</h3>
<ul>
<li>Scan UPC items after loading an order</li>
<li>Compare scanned quantities against expected quantities</li>
<li>Prevent over-scanning and reduce manual counting errors</li>
</ul>
</div>

<div class="feature-card">
<h3><i class="fa-solid fa-clock-rotate-left"></i> Audit History</h3>
<ul>
<li>Record operational events and updates</li>
<li>Track warehouse activity by order</li>
<li>Improve traceability when mistakes occur</li>
</ul>
</div>

<div class="feature-card">
<h3><i class="fa-solid fa-chart-column"></i> Reporting and Visibility</h3>
<ul>
<li>Summarize receiving activity by organization</li>
<li>Support embroidery preparation visibility</li>
<li>Provide simple operational reporting for review</li>
</ul>
</div>

</div>

<h2><i class="fa-solid fa-diagram-project"></i> System Flow</h2>

<p>
The system follows a simple receiving workflow that starts with order lookup and then moves into validation and tracking.
</p>

<div class="diagram">
<pre>
Warehouse Staff
      │
      │  Scan / Enter Order Number
      ▼
Load Order Information
(PHP + MySQL)
      │
      ▼
Receiving Session
      │
      │  Scan UPC Items
      ▼
Validation Engine
(Expected vs Scanned)
      │
      ├── Update Receiving Progress
      ├── Record Audit Event
      └── Support Reporting / Dashboard
</pre>
</div>

<h2><i class="fa-solid fa-chart-line"></i> Results</h2>

<ul>
<li>Reduced order preparation time from <strong>1 week to 1 day</strong></li>
<li>Reduced manual sorting and classification errors</li>
<li>Improved visibility into receiving progress</li>
<li>Added traceability to warehouse operations</li>
</ul>

<h2><i class="fa-solid fa-laptop-code"></i> Engineering Highlights</h2>

<ul>
<li>Relational database design for orders, scans, sessions, and notes</li>
<li>Order-centered workflow for receiving operations</li>
<li>Audit logging for operational traceability</li>
<li>Real-time validation against expected order data</li>
<li>Operational dashboard and reporting features</li>
</ul>

<h2><i class="fa-solid fa-shield-halved"></i> Data Notice</h2>

<p>
All data shown in this portfolio demo is fictional or anonymized and is used for demonstration purposes only.
No private company or customer data is included in this public version.
</p>

<h2><i class="fa-solid fa-user"></i> Personal Note</h2>

<p>
This project started from a real operational problem.
Rather than building a generic demo application, I wanted to design a system around a workflow that had clear operational pain points and measurable impact.
</p>

<p>
My goal was to make receiving faster, reduce avoidable mistakes, and provide a clearer record of what happened during order processing.
</p>

<div class="footer">
© <?php echo date('Y'); ?> ReceiveFlow — Developed by Nam Ho
</div>

</div>

</body>
</html>