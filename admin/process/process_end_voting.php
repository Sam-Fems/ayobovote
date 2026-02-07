<?php
session_start();
require_once '../classes/Admin.php';
require_once "../admin_guard.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['end_voting'])) {
    $_SESSION['errormsg'] = "Invalid request";
    header("location: ../admin_dashboard.php");
    exit();
}

$admin = new Admin();

$success = $admin->endVotingSession($_SESSION['admin_id']);

if ($success) {
    $_SESSION['msg'] = "Voting session has been successfully ended.";
} else {
    $_SESSION['errormsg'] = "Failed to end voting session. Please try again.";
}

header("location: ../admin_dashboard.php");
exit();
