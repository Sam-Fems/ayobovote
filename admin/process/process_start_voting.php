<?php
session_start();
require_once '../classes/Admin.php';
require_once "../admin_guard.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['start_voting'])) {
    $_SESSION['errormsg'] = "Invalid request";
    header("location: ../admin_dashboard.php");
    exit();
}

$admin = new Admin();

$success = $admin->startVotingSession($_SESSION['admin_id']);

if ($success) {
    $_SESSION['msg'] = "New voting session started successfully.";
} else {
    $_SESSION['errormsg'] = "Failed to start voting session.";
}

header("location: ../admin_dashboard.php");
exit();
