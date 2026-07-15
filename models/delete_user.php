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

    if (!$userId) {
        echo json_encode([
            "success" => false,
            "message" => "Missing user ID."
        ]);
        exit;
    }

    $stmt = $conn->prepare("
        UPDATE users
        SET deleted = '1'
        WHERE user_id = :user_id
    ");

    $stmt->execute([
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