<?php

class User
{
    private $conn;

    public function __construct($database)
    {
        $this->conn = $database;
    }

    /**
     * Find a user by email.
     */
    public function findByEmail($email)
    {
        $sql = "SELECT *
                FROM users
                WHERE email = :email
                AND deleted = '0'
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Find a user by ID.
     */
    public function findById($userId)
    {
        $sql = "SELECT *
                FROM users
                WHERE user_id = :user_id
                AND deleted = '0'
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update a user's password.
     */
    public function updatePassword($userId, $newPassword)
    {
        $sql = "UPDATE users
                SET password_hash = :password
                WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":password", $newPassword);
        $stmt->bindParam(":user_id", $userId);

        return $stmt->execute();
    }
}

?>