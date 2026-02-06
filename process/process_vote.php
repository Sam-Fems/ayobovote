<?php
session_start();
require_once "../classes/Voter.php";

// 🔐 Must be logged in
if (!isset($_SESSION['voter_logged_in'])) {
    $_SESSION['errormsg'] = "Please log in to vote";
    header("location: ../voter_login.php");
    exit;
}

// 🔒 Must come from form
if (!isset($_POST['btn'])) {
    header("location: ../voter_dashboard.php");
    exit;
}

$voter_id     = $_SESSION['voter_db_id'];
$candidate_id = $_POST['candidate_id'] ?? null;


if (empty($candidate_id)) {
    $_SESSION['errormsg'] = "Please select a candidate";
    header("location: ../voter_dashboard.php");
    exit;
}

$voter = new Voter();
$response = $voter->cast_vote($voter_id, $candidate_id);

if ($response['success']) {
    $_SESSION['msg'] = $response['message'];
    header("location: ../voter_dashboard.php");
} else {
    $_SESSION['errormsg'] = $response['message'];
    header("location: ../voter_dashboard.php");
}
