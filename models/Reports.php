<?php
class Reports{
    private $conn;

    public function __construct($database)
    {
        $this->conn = $database;
    }

    // Retrieving Active Loss Reports
    public function getReports($type)
    {
        $sql = "SELECT *
                FROM reports
                WHERE type = :type
                AND status = 'Active'
                ;";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':type', $type);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}



?>