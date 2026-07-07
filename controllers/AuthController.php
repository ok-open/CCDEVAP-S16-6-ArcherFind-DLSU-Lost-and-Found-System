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
| Get form inputs
|--------------------------------------------------------------------------
*/

$email = trim($_POST["email"] ?? "");
$password = trim($_POST["password"] ?? "");

/*
|--------------------------------------------------------------------------
| Validate empty fields
|--------------------------------------------------------------------------
*/

if (empty($email) || empty($password)) {
    header("Location: ../index.php?error=empty_fields");
    exit();
}

/*
|--------------------------------------------------------------------------
| Validate DLSU email
|--------------------------------------------------------------------------
*/

$email = strtolower($email);

if (!str_ends_with($email, "@dlsu.edu.ph")) {
    header("Location: ../index.php?error=invalid_email");
    exit();
}

/*
|--------------------------------------------------------------------------
| Find user
|--------------------------------------------------------------------------
*/

$userModel = new User($conn);
$user = $userModel->findByEmail($email);

if (!$user) {
    header("Location: ../index.php?error=account_not_found");
    exit();
}

/*
|--------------------------------------------------------------------------
| Password Check
| Password hashing is NOT required for MP2
|--------------------------------------------------------------------------
*/

if ($password !== $user["password_hash"]) {
    header("Location: ../index.php?error=wrong_password");
    exit();
}

/*
|--------------------------------------------------------------------------
| Store Session
|--------------------------------------------------------------------------
*/

$_SESSION["user_id"] = $user["user_id"];
$_SESSION["first_name"] = $user["first_name"];
$_SESSION["last_name"] = $user["last_name"];
$_SESSION["email"] = $user["email"];
$_SESSION["role"] = $user["role"];

/*
|--------------------------------------------------------------------------
| Redirect based on role
|--------------------------------------------------------------------------
*/

switch ($user["role"]) {

    case "Student":
        header("Location: ../pages/student/student_home.php");
        break;

    case "Staff":
        header("Location: ../pages/staff/staff_home.php");
        break;

    case "Admin":
        header("Location: ../pages/admin/admin_home.php");
        break;

    default:
        session_destroy();
        header("Location: ../index.php?error=unauthorized");
        break;
}

exit();

?>