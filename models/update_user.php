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

    $data = json_decode(file_get_contents("php://input"), true);

    $userId = $data["user_id"] ?? null;
    $firstName = trim($data["first_name"] ?? "");
    $lastName = trim($data["last_name"] ?? "");
    $email = strtolower(trim($data["email"] ?? ""));
    $role = $data["role"] ?? "";

    if (
        !$userId ||
        empty($firstName) ||
        empty($lastName) ||
        empty($email) ||
        empty($role)
    ) {
        echo json_encode([
            "success" => false,
            "message" => "Missing required fields."
        ]);
        exit;
    }

    $stmt = $conn->prepare("
        UPDATE users
        SET
            first_name = :first_name,
            last_name = :last_name,
            email = :email,
            role = :role
        WHERE user_id = :user_id
        AND deleted = '0'
    ");

    $stmt->execute([
        ":first_name" => $firstName,
        ":last_name" => $lastName,
        ":email" => $email,
        ":role" => $role,
        ":user_id" => $userId
    ]);

    echo json_encode([
        "success" => true
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}
?>