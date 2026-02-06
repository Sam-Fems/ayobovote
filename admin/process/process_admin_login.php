<?php
session_start();
require_once "../classes/Admin.php";
$admin = new Admin;

if (isset($_POST["btn"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $_SESSION["errormsg"] = "All fields are required";
        header("location:../admin_login.php");
        exit;
    }

    // admin_login_process.php (or wherever the POST handler is)
    $response = $admin->login($username, $password);

    if ($response === true) {           // ← compare with true
        $_SESSION["msg"] = "You have logged in successfully";
        header("location:../admin_dashboard.php");
        exit;
    } else {
        $_SESSION["errormsg"] = "Invalid username or password";   // ← better message
        header("location:../admin_login.php");
        exit;
    }
} else {
    header("location:../admin_login.php");
    exit;
}
