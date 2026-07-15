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

    $firstName = trim($data["first_name"] ?? "");
    $lastName = trim($data["last_name"] ?? "");
    $email = strtolower(trim($data["email"] ?? ""));
    $password = $data["password"] ?? "";
    $role = $data["role"] ?? "";

    if (
        empty($firstName) ||
        empty($lastName) ||
        empty($email) ||
        empty($password) ||
        empty($role)
    ) {
        echo json_encode([
            "success" => false,
            "message" => "Missing required fields."
        ]);
        exit;
    }

    if (!str_ends_with($email, "@dlsu.edu.ph")) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid DLSU email."
        ]);
        exit;
    }

    if (!in_array($role, ["Student", "Staff", "Admin"])) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid role."
        ]);
        exit;
    }

    $checkStmt = $conn->prepare("
        SELECT user_id
        FROM users
        WHERE email = :email
        LIMIT 1
    ");

    $checkStmt->execute([
        ":email" => $email
    ]);

    if ($checkStmt->fetch()) {
        echo json_encode([
            "success" => false,
            "message" => "Email already exists."
        ]);
        exit;
    }

    $passwordHash = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $stmt = $conn->prepare("
        INSERT INTO users
        (
            first_name,
            last_name,
            email,
            password_hash,
            role,
            deleted
        )
        VALUES
        (
            :first_name,
            :last_name,
            :email,
            :password_hash,
            :role,
            '0'
        )
    ");

    $stmt->execute([
        ":first_name" => $firstName,
        ":last_name" => $lastName,
        ":email" => $email,
        ":password_hash" => $passwordHash,
        ":role" => $role
    ]);

    echo json_encode([
        "success" => true,
        "user_id" => (int)$conn->lastInsertId()
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}
?>