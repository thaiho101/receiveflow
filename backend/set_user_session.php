<?php
session_start();
$userName = $_POST['name'] ?? '';
if ($userName == 'NH') {
    $userName = "Nam Ho";
} else if ($userName == 'JM') {
    $userName = "Jacob Miller";
} else if ($userName == 'AN') {
    $userName = "Andy Nguyen";
}
if ($userName !== '') $_SESSION['userName'] = $userName;
?>