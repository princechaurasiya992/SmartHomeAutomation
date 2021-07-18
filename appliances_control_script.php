<?php

require 'includes/common.php';
require 'includes/is_welcomed.php';
require 'includes/remember_login.php';

if (!isset($_SESSION['email'])) {
    header('location: login.php');
}

$btn_id = $_POST['btn_id'];
$state = $_POST['state'];
$status = "OFF";

if ($state == 0) {
    $status = "OFF";
} else if ($state == 1) {
    $status = "ON";
}

$str = "sudo python /var/www/html/SmartHomeAutomation/py/appliances_control.py " . $btn_id . " " . $state;
exec($str);

$select_query = "SELECT * FROM appliances WHERE name='$btn_id'";
$selection_result = mysqli_query($con, $select_query) or die(mysqli_error($con));
if (mysqli_num_rows($selection_result) > 0) {
    $update_query = "UPDATE appliances SET state = '$state' WHERE name = '$btn_id'";
    $result = mysqli_query($con, $update_query) or die(mysqli_error($con));
    echo $status;
} else {
    $insert_query = "insert into appliances(name, state) values ('$btn_id', '$state')";
    $result = mysqli_query($con, $insert_query) or die(mysqli_error($con));
    echo $status;
}
