<?php

class Reports
{
    private $conn;

    public function __construct($database)
    {
        $this->conn = $database;
    }


    // Submit Claim Request / Loss Report / Surrender Form
    public function createReport(
        $studentId,
        $itemName,
        $itemDescription,
        $categoryId,
        $brandId,
        $itemId,
        $roomId,
        $areaId,
        $whenLost,
        $extraDetails,
        $type
    )
    {
        $sql = "
            INSERT INTO reports
            (
                student_id,
                item_name,
                item_description,
                category_id,
                brand_id,
                item_id,
                room_id,
                area_id,
                when_lost,
                extra_details,
                type,
                status,
                deleted
            )

            VALUES
            (
                :student_id,
                :item_name,
                :item_description,
                :category_id,
                :brand_id,
                :item_id,
                :room_id,
                :area_id,
                :when_lost,
                :extra_details,
                :type,
                'Active',
                '0'
            )
        ";


        $stmt = $this->conn->prepare($sql);


        $stmt->bindParam(":student_id", $studentId);
        $stmt->bindParam(":item_name", $itemName);
        $stmt->bindParam(":item_description", $itemDescription);
        $stmt->bindParam(":category_id", $categoryId);
        $stmt->bindParam(":brand_id", $brandId);
        $stmt->bindParam(":item_id", $itemId);
        $stmt->bindParam(":room_id", $roomId);
        $stmt->bindParam(":area_id", $areaId);
        $stmt->bindParam(":when_lost", $whenLost);
        $stmt->bindParam(":extra_details", $extraDetails);
        $stmt->bindParam(":type", $type);


        return $stmt->execute();
    }



    // Retrieve Active Reports by Type
    public function getReports($type)
    {
        $sql = "
            SELECT *
            FROM reports
            WHERE type = :type
            AND status = 'Active'
            AND deleted = '0'
        ";


        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":type", $type);

        $stmt->execute();


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>