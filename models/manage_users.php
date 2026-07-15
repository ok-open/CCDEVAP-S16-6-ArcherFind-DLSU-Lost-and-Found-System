<?php

session_start();

header('Content-Type: application/json');

if (
    !isset($_SESSION["user_id"]) ||
    !isset($_SESSION["role"]) ||
    $_SESSION["role"] !== "Admin"
) {
    http_response_code(403);

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized."
    ]);

    exit;
}

require_once("../db.php");

try {

    $stmt = $conn->query("
        SELECT
            user_id,
            first_name,
            last_name,
            email,
            role
        FROM users
        WHERE deleted = '0'
        ORDER BY last_name ASC
    ");

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "users" => $users
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}
?>