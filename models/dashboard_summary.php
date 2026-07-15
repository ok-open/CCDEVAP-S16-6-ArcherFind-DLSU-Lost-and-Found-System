<?php
header('Content-Type: application/json');

require_once("../db.php");



try {

    $totalUsers = $conn->query("
        SELECT COUNT(*)
        FROM users
        WHERE deleted = '0'
    ")->fetchColumn();

    $students = $conn->query("
        SELECT COUNT(*)
        FROM users
        WHERE role = 'Student'
        AND deleted = '0'
    ")->fetchColumn();

    $staff = $conn->query("
        SELECT COUNT(*)
        FROM users
        WHERE role = 'Staff'
        AND deleted = '0'
    ")->fetchColumn();

    $admins = $conn->query("
        SELECT COUNT(*)
        FROM users
        WHERE role = 'Admin'
        AND deleted = '0'
    ")->fetchColumn();

    $totalReports = $conn->query("
        SELECT COUNT(*)
        FROM reports
        WHERE deleted = '0'
    ")->fetchColumn();

    $totalItems = $conn->query("
        SELECT COUNT(*)
        FROM items
        WHERE deleted = '0'
    ")->fetchColumn();

    $reportTypeQuery = $conn->query("
        SELECT type, COUNT(*) AS total
        FROM reports
        WHERE deleted = '0'
        GROUP BY type
    ");

    $itemReports = [
        "Loss Report" => 0,
        "Claim request" => 0,
        "Surrender Form" => 0
    ];

    while ($row = $reportTypeQuery->fetch(PDO::FETCH_ASSOC)) {
        $itemReports[$row["type"]] = (int)$row["total"];
    }

    $inventoryQuery = $conn->query("
    SELECT status, COUNT(*) AS total
    FROM items
    WHERE deleted = '0'
    GROUP BY status
    ");

    $inventoryStatus = [
        "In Storage" => 0,
        "Claimed" => 0,
        "Disposed" => 0
    ];

    while ($row = $inventoryQuery->fetch(PDO::FETCH_ASSOC)) {
        $inventoryStatus[$row["status"]] = (int)$row["total"];
    }

    $monthlyQuery = $conn->query("
        SELECT 
            MONTH(created_at) AS month,
            COUNT(*) AS total
        FROM reports
        WHERE deleted = '0'
        GROUP BY MONTH(created_at)
        ORDER BY MONTH(created_at)
    ");

    $monthlyReports = array_fill(0, 12, 0);

    while ($row = $monthlyQuery->fetch(PDO::FETCH_ASSOC)) {
        $monthIndex = (int)$row["month"] - 1;
        $monthlyReports[$monthIndex] = (int)$row["total"];
    }

    $locationQuery = $conn->query("
        SELECT
            b.name,
            COUNT(i.item_id) AS total
        FROM items i
        LEFT JOIN rooms r
            ON i.room_id = r.room_id
        LEFT JOIN areas a
            ON i.area_id = a.area_id
        JOIN buildings b
            ON b.building_id = COALESCE(r.building_id, a.building_id)
        WHERE i.deleted = '0'
        GROUP BY b.building_id, b.name
        ORDER BY total DESC
        ");

    $locationLabels = [];
    $locationData = [];

    while ($row = $locationQuery->fetch(PDO::FETCH_ASSOC)) {
        $locationLabels[] = $row["name"];
        $locationData[] = (int)$row["total"];
    }

    // ======================================================
    // AVERAGE RESOLUTION TIME
    // ======================================================

    $resolutionQuery = $conn->query("
        SELECT
            r.type,
            AVG(TIMESTAMPDIFF(SECOND, r.created_at, rul.updated_at)) / 86400 AS avg_days
        FROM reports r
        JOIN reports_update_log rul
            ON r.report_id = rul.report_id
        WHERE r.deleted = '0'
        AND (
            (r.type = 'Loss Report' AND rul.new_status = 'Resolved')
            OR
            (r.type = 'Surrender Form' AND rul.new_status = 'Accepted')
            OR
            (r.type = 'Claim request' AND rul.new_status = 'Accepted')
        )
        GROUP BY r.type
    ");

    $resolutionTimes = [
        "Loss Report" => 0,
        "Surrender Form" => 0,
        "Claim request" => 0
    ];

    while ($row = $resolutionQuery->fetch(PDO::FETCH_ASSOC)) {
        $resolutionTimes[$row["type"]] = round((float)$row["avg_days"], 1);
    }

    // ======================================================
    // CLAIM SUCCESS RATE
    // ======================================================

    $claimQuery = $conn->query("
        SELECT
            COUNT(*) AS total_claims,
            SUM(CASE WHEN status = 'Accepted' THEN 1 ELSE 0 END) AS accepted_claims
        FROM reports
        WHERE deleted = '0'
        AND type = 'Claim request'
    ");

    $claimData = $claimQuery->fetch(PDO::FETCH_ASSOC);

    $totalClaims = (int)$claimData["total_claims"];
    $acceptedClaims = (int)$claimData["accepted_claims"];

    $claimSuccessRate = 0;

    if ($totalClaims > 0) {
        $claimSuccessRate = round(
            ($acceptedClaims / $totalClaims) * 100
        );
    }

    // ======================================================
    // ITEM DISPOSAL RATE
    // ======================================================

    $disposalQuery = $conn->query("
        SELECT
            COUNT(*) AS total_items,
            SUM(CASE WHEN status = 'Disposed' THEN 1 ELSE 0 END) AS disposed_items
        FROM items
        WHERE deleted = '0'
    ");

    $disposalData = $disposalQuery->fetch(PDO::FETCH_ASSOC);

    $totalDisposalItems = (int)$disposalData["total_items"];
    $disposedItems = (int)$disposalData["disposed_items"];

    $itemDisposalRate = 0;

    if ($totalDisposalItems > 0) {
        $itemDisposalRate = round(
            ($disposedItems / $totalDisposalItems) * 100
        );
    }
    echo json_encode([
        "success" => true,
        "totalUsers" => (int)$totalUsers,
        "students" => (int)$students,
        "staff" => (int)$staff,
        "admins" => (int)$admins,
        "totalReports" => (int)$totalReports,
        "totalItems" => (int)$totalItems,
        "itemReports" => [
            $itemReports["Loss Report"],
            $itemReports["Claim request"],
            $itemReports["Surrender Form"]
            ],
        "inventoryStatus" => [
            $inventoryStatus["In Storage"],
            $inventoryStatus["Claimed"],
            $inventoryStatus["Disposed"]
            ],
        "monthlyReports" => $monthlyReports,
        "locationLabels" => $locationLabels,
        "locationData" => $locationData,
        "resolutionTimes" => [
            "lossMatch" => $resolutionTimes["Loss Report"],
            "surrenderApproval" => $resolutionTimes["Surrender Form"],
            "claimVerification" => $resolutionTimes["Claim request"]
            ],
        "claimSuccessRate" => $claimSuccessRate,
        "acceptedClaims" => $acceptedClaims,
        "totalClaims" => $totalClaims,
        "itemDisposalRate" => $itemDisposalRate,
        "disposedItems" => $disposedItems,
        "totalDisposalItems" => $totalDisposalItems
        ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

    

}

