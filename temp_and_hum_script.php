<?php

require 'includes/common.php';
require 'includes/is_welcomed.php';
require 'includes/remember_login.php';

if (!isset($_SESSION['email'])) {
    header('location: login.php');
}

$select_query = "SELECT * FROM temp_and_hum";
$selection_result = mysqli_query($con, $select_query) or die(mysqli_error($con));
if (mysqli_num_rows($selection_result) > 0) {
    $delete_query = "DELETE FROM temp_and_hum";
    $result = mysqli_query($con, $delete_query) or die(mysqli_error($con));

    $str = "sudo python3 /var/www/html/SmartHomeAutomation/py/temp_and_hum.py";
    exec($str);

    $query = "SELECT data FROM temp_and_hum";
    $data = mysqli_query($con, $query) or die(mysqli_error($con));

    if (mysqli_num_rows($data) > 0) {
        $row = mysqli_fetch_array($data);
        echo $row['data'];
    }
} else {
    $str = "sudo python3 /var/www/html/SmartHomeAutomation/py/temp_and_hum.py";
    exec($str);

    $query = "SELECT data FROM temp_and_hum";
    $data = mysqli_query($con, $query) or die(mysqli_error($con));

    if (mysqli_num_rows($data) > 0) {
        $row = mysqli_fetch_array($data);
        echo $row['data'];
    }
}
