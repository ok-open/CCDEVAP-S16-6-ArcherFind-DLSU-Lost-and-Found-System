<?php

session_start();

require_once "../db.php";
require_once "../models/User.php";

/*
|--------------------------------------------------------------------------
| Only allow POST requests
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Ensure user is logged in
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Get submitted passwords
|--------------------------------------------------------------------------
*/

$currentPassword = trim($_POST["current_password"] ?? "");
$newPassword = trim($_POST["new_password"] ?? "");
$confirmPassword = trim($_POST["confirm_password"] ?? "");

/*
|--------------------------------------------------------------------------
| Validate empty fields
|--------------------------------------------------------------------------
*/

if (
    empty($currentPassword) ||
    empty($newPassword) ||
    empty($confirmPassword)
) {
    header("Location: ../pages/student/student_manage-account.php?error=empty_fields");
    exit();
}

/*
|--------------------------------------------------------------------------
| Validate passwords match
|--------------------------------------------------------------------------
*/

if ($newPassword !== $confirmPassword) {
    header("Location: ../pages/student/student_manage-account.php?error=password_mismatch");
    exit();
}

/*
|--------------------------------------------------------------------------
| Get current user
|--------------------------------------------------------------------------
*/

$userModel = new User($conn);
$user = $userModel->findById($_SESSION["user_id"]);

if (!$user) {
    session_destroy();
    header("Location: ../index.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Verify current password
|--------------------------------------------------------------------------
*/

if ($currentPassword !== $user["password_hash"]) {
    header("Location: ../pages/student/student_manage-account.php?error=wrong_password");
    exit();
}

/*
|--------------------------------------------------------------------------
| Prevent using same password
|--------------------------------------------------------------------------
*/

if ($currentPassword === $newPassword) {
    header("Location: ../pages/student/student_manage-account.php?error=same_password");
    exit();
}

/*
|--------------------------------------------------------------------------
| Update password
|--------------------------------------------------------------------------
*/

$userModel->updatePassword($_SESSION["user_id"], $newPassword);

/*
|--------------------------------------------------------------------------
| Success
|--------------------------------------------------------------------------
*/

header("Location: ../pages/student/student_manage-account.php?success=password_updated");
exit();

?>