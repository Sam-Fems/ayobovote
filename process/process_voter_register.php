<?php
session_start();
require_once "../classes/Voter.php";
require_once "../helpers/Mailer.php";

$voter = new Voter();

if (isset($_POST["btn"])) {

    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirmP"];

    if (empty($fullname) || empty($email) || empty($phone) || empty($address) || empty($password)) {
        $_SESSION["errormsg"] = "All fields are required";
        header("location: ../voter_register.php");
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['errormsg'] = 'Passwords do not match';
        header('location: ../voter_register.php');
        exit;
    }

    $rsp = $voter->register_voter($fullname, $email, $phone, $address, $password);

    if ($rsp['success']) {
        sendVoterIDEmail(
            $email,
            $fullname,
            $rsp['voter_id']
        );
        $_SESSION['msg'] = "Account created successfully. Please log in.";
        header("location: ../voter_login.php");
    } else {
        $_SESSION['errormsg'] = "Error in creating account";
        header("location: ../voter_register.php");
    }
    exit;
} else {
    header("location: ../voter_register.php");
    exit;
}
