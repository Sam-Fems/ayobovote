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

$admin_id = $_SESSION['admin_id'] ?? 0;

if ($admin_id <= 0) {
    $_SESSION['errormsg'] = "Admin session error - cannot end voting";
    header("location: ../admin_dashboard.php");
    exit();
}

$success = $admin->endVotingSession($admin_id);

if ($success) {
    $_SESSION['msg'] = "Voting session ended successfully.";
} else {
    $_SESSION['errormsg'] = "Failed to end voting session (no rows updated).";
}

header("location: ../admin_dashboard.php");
exit();
