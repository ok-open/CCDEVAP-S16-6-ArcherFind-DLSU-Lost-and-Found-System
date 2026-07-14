<?php

class Dashboard
{
    private $conn;


    public function __construct($database)
    {
        $this->conn = $database;
    }



    // ===============================
    // SUMMARY CARDS
    // ===============================

    public function getReportStatistics($studentId)
    {
        $sql = "
            SELECT
                SUM(type = 'Loss Report') AS loss_reports,
                SUM(type = 'Surrender Form') AS found_reports,
                SUM(status IN ('Accepted','Resolved')) AS approved_reports,
                SUM(status = 'Active') AS pending_reports

            FROM reports

            WHERE student_id = :student_id
            AND deleted = '0'
        ";


        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(
            ":student_id",
            $studentId
        );

        $stmt->execute();


        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        return [
            "loss-reports" =>
                $result["loss_reports"] ?? 0,

            "found-reports" =>
                $result["found_reports"] ?? 0,

            "approved-reports" =>
                $result["approved_reports"] ?? 0,

            "pending-reports" =>
                $result["pending_reports"] ?? 0
        ];
    }



    // ===============================
    // REPORT HISTORY
    // ===============================

    public function getReportHistory($studentId)
    {
        $sql = "
            SELECT
                report_id,
                DATE_FORMAT(created_at,'%M %d, %Y') AS date,
                type,
                status

            FROM reports

            WHERE student_id = :student_id
            AND deleted = '0'

            ORDER BY created_at DESC

            LIMIT 10
        ";


        $stmt = $this->conn->prepare($sql);


        $stmt->bindParam(
            ":student_id",
            $studentId
        );


        $stmt->execute();


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // ===============================
    // LOST ITEM FREQUENCY
    // ===============================

    public function getLostItemFrequency($studentId)
    {

        $sql = "

            SELECT
                COALESCE(
                    b.name,
                    'Unknown Location'
                ) AS location,

                COUNT(*) AS total


            FROM reports r


            LEFT JOIN rooms rm
                ON r.room_id = rm.room_id


            LEFT JOIN areas a
                ON r.area_id = a.area_id


            LEFT JOIN buildings b
                ON b.building_id =
                COALESCE(
                    rm.building_id,
                    a.building_id
                )


            WHERE r.student_id = :student_id

            AND r.deleted='0'

            GROUP BY b.name

            ORDER BY total DESC

        ";


        $stmt = $this->conn->prepare($sql);


        $stmt->bindParam(
            ":student_id",
            $studentId
        );


        $stmt->execute();


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>