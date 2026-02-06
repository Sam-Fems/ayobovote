<?php
session_start();
require_once "../classes/Voter.php";

if (!isset($_POST['btn'])) {
    header("location: ../voter_login.php");
    exit;
}

$voter_id = trim($_POST['voter_id']);
$password = $_POST['password'];

if (empty($voter_id) || empty($password)) {
    $_SESSION['errormsg'] = "Voter ID and Password are required";
    header("location: ../voter_login.php");
    exit;
}

$voter = new Voter();
$response = $voter->login_voter($voter_id, $password);

if ($response['success']) {

    // ✅ Store login session
    $_SESSION['voter_db_id'] = $response['voter']['id'];
    $_SESSION['voter_id']   = $response['voter']['voter_id'];
    $_SESSION['voter_name'] = $response['voter']['fullname'];
    $_SESSION['voter_email'] = $response['voter']['email'];
    $_SESSION['voter_logged_in'] = true;

    $_SESSION['msg'] = "Login successful. Welcome back, " . $response['voter']['fullname'] . "!";
    header("location: ../voter_dashboard.php");
    exit;
} else {
    $_SESSION['errormsg'] = $response['message'];
    header("location: ../voter_login.php");
    exit;
}
