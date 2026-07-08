<?php

session_start();

/*
|--------------------------------------------------------------------------
| Logout Controller
|--------------------------------------------------------------------------
| Destroy the current session and return the user
| to the login page.
*/

$_SESSION = [];

session_destroy();

header("Location: ../index.php");
exit();

?>