<?php

require 'includes/common.php';
require 'includes/is_welcomed.php';
require 'includes/remember_login.php';

if (!isset($_SESSION['email'])) {
    header('location: login.php');
}

$str = "sudo python3 /var/www/html/SmartHomeAutomation/py/manual_cam.py";
exec($str);

echo "Picture captured!";
