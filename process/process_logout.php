<?php

session_start();
require_once '../classes/Voter.php';

$voter = new Voter;

$response = $voter->logout();

if ($response['success']) {
    $_SESSION['msg'] = 'You have logged out successfully';
}
header('location: ../voter_login.php');
exit;
