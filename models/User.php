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
}

?>