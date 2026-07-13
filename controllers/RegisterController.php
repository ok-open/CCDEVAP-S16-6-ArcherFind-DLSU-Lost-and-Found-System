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
    header("Location: ../pages/auth/register.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Get form inputs
|--------------------------------------------------------------------------
*/

$firstName = trim($_POST["first_name"] ?? "");
$lastName = trim($_POST["last_name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");
$confirmPassword = trim($_POST["confirm_password"] ?? "");

/*
|--------------------------------------------------------------------------
| Validate empty fields
|--------------------------------------------------------------------------
*/

if (
    empty($firstName) ||
    empty($lastName) ||
    empty($email) ||
    empty($password) ||
    empty($confirmPassword)
) {
    header("Location: ../pages/auth/register.php?error=empty_fields");
    exit();
}

/*
|--------------------------------------------------------------------------
| Validate DLSU email
|--------------------------------------------------------------------------
*/

$email = strtolower($email);

if (!str_ends_with($email, "@dlsu.edu.ph")) {
    header("Location: ../pages/auth/register.php?error=invalid_email");
    exit();
}

/*
|--------------------------------------------------------------------------
| Validate passwords match
|--------------------------------------------------------------------------
*/

if ($password !== $confirmPassword) {
    header("Location: ../pages/auth/register.php?error=password_mismatch");
    exit();
}

/*
|--------------------------------------------------------------------------
| Check if email already exists
|--------------------------------------------------------------------------
*/

$userModel = new User($conn);

if ($userModel->emailExists($email)) {
    header("Location: ../pages/auth/register.php?error=email_exists");
    exit();
}

/*
|--------------------------------------------------------------------------
| Hash password
|--------------------------------------------------------------------------
*/

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

/*
|--------------------------------------------------------------------------
| Create account
|--------------------------------------------------------------------------
*/

$created = $userModel->createUser(
    $firstName,
    $lastName,
    $email,
    $hashedPassword
);

if (!$created) {
    header("Location: ../pages/auth/register.php?error=registration_failed");
    exit();
}

/*
|--------------------------------------------------------------------------
| Success
|--------------------------------------------------------------------------
*/

header("Location: ../index.php?success=registered");
exit();

?>