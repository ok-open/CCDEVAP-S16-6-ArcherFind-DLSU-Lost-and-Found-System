<?php

class Location
{
    private $conn;

    public function __construct($database)
    {
        $this->conn = $database;
    }

    // Retrieve all active buildings
    public function getBuildings()
    {
        $sql = "
            SELECT
                building_id,
                name,
                abbreviation,
                max_level
            FROM buildings
            WHERE deleted = '0'
            ORDER BY name
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retrieve all active rooms
    public function getRooms()
    {
        $sql = "
            SELECT
                room_id,
                name,
                building_id,
                level
            FROM rooms
            WHERE deleted = '0'
            ORDER BY building_id, level, name
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retrieve all active areas
    public function getAreas()
    {
        $sql = "
            SELECT
                area_id,
                name,
                building_id,
                level
            FROM areas
            WHERE deleted = '0'
            ORDER BY building_id, level, name
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>