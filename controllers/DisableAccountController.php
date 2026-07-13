<?php

session_start();

require_once "../db.php";
require_once "../models/User.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit();
}

$userModel = new User($conn);

$userId = $_SESSION["user_id"];

if ($userModel->disableAccount($userId)) {

    session_unset();
    session_destroy();

    header("Location: ../index.php?success=account_disabled");
    exit();
}

header("Location: ../pages/student/student_manage-account.php?error=disable_failed");
exit();