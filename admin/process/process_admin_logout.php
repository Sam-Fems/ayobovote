<?php

session_start();
require_once '../classes/Admin.php';

$admin = new Admin;

$response = $admin->logout();

if ($response['success']) {
    $_SESSION['msg'] = 'You have logged out successfully';
}
header('location: ../admin_login.php');
exit;
