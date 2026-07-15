<?php

session_start();

header('Content-Type: application/json');

if (
    !isset($_SESSION["user_id"]) ||
    !isset($_SESSION["role"]) ||
    !in_array($_SESSION["role"], ["Admin", "Staff"])
) {
    http_response_code(403);

    echo json_encode([
        "success" => false,
        "message" => "Unauthorized."
    ]);

    exit;
}

require_once("../db.php");

if (
    !isset($_GET["from"]) ||
    !isset($_GET["to"]) ||
    empty($_GET["from"]) ||
    empty($_GET["to"])
) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "Missing dates."
    ]);

    exit;
}

$from = $_GET['from'] . " 00:00:00";
$to   = $_GET['to'] . " 23:59:59";

// REPORT TYPES

$sql = "
SELECT type, COUNT(*) AS total
FROM reports
WHERE deleted = '0'
AND created_at BETWEEN :fromDate AND :toDate
GROUP BY type
";

$stmt = $conn->prepare($sql);
$stmt->execute([
    ":fromDate" => $from,
    ":toDate" => $to
]);

$itemReports = [
    "Loss Report" => 0,
    "Claim request" => 0,
    "Surrender Form" => 0
];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $itemReports[$row["type"]] = (int)$row["total"];
}

// INVENTORY STATUS

$sql = "
SELECT status, COUNT(*) AS total
FROM items
WHERE deleted = '0'
AND when_found BETWEEN :fromDate AND :toDate
GROUP BY status
";

$stmt = $conn->prepare($sql);
$stmt->execute([
    ":fromDate" => $from,
    ":toDate" => $to
]);

$inventoryStatus = [
    "In Storage" => 0,
    "Claimed" => 0,
    "Disposed" => 0
];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $inventoryStatus[$row["status"]] = (int)$row["total"];
}

// ======================================================
// LOST ITEM FREQUENCY BY LOCATION
// ======================================================

$sql = "
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
AND i.when_found BETWEEN :fromDate AND :toDate
GROUP BY b.building_id, b.name
ORDER BY total DESC
";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ":fromDate" => $from,
    ":toDate" => $to
]);

$locationLabels = [];
$locationData = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $locationLabels[] = $row["name"];
    $locationData[] = (int)$row["total"];
}

// MONTHLY REPORTS


$sql = "
SELECT
    MONTH(created_at) AS month,
    COUNT(*) AS total
FROM reports
WHERE deleted = '0'
AND created_at BETWEEN :fromDate AND :toDate
GROUP BY MONTH(created_at)
ORDER BY MONTH(created_at)
";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ":fromDate" => $from,
    ":toDate" => $to
]);



$monthlyReports = array_fill(0, 12, 0);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $monthIndex = (int)$row["month"] - 1;
    $monthlyReports[$monthIndex] = (int)$row["total"];
}

// CLAIM SUCCESS RATE

$sql = "
SELECT
    COUNT(*) AS total_claims,
    SUM(CASE WHEN status = 'Accepted' THEN 1 ELSE 0 END) AS accepted_claims
FROM reports
WHERE deleted = '0'
AND type = 'Claim request'
AND created_at BETWEEN :fromDate AND :toDate
";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ":fromDate" => $from,
    ":toDate" => $to
]);

$claimData = $stmt->fetch(PDO::FETCH_ASSOC);

$totalClaims = (int)$claimData["total_claims"];
$acceptedClaims = (int)$claimData["accepted_claims"];

$claimSuccessRate = 0;

if ($totalClaims > 0) {
    $claimSuccessRate = round(
        ($acceptedClaims / $totalClaims) * 100
    );
}

// ITEM DISPOSAL RATE

$sql = "
SELECT
    COUNT(*) AS total_items,
    SUM(CASE WHEN status = 'Disposed' THEN 1 ELSE 0 END) AS disposed_items
FROM items
WHERE deleted = '0'
AND when_found BETWEEN :fromDate AND :toDate
";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ":fromDate" => $from,
    ":toDate" => $to
]);

$disposalData = $stmt->fetch(PDO::FETCH_ASSOC);

$totalDisposalItems = (int)$disposalData["total_items"];
$disposedItems = (int)$disposalData["disposed_items"];

$itemDisposalRate = 0;

if ($totalDisposalItems > 0) {
    $itemDisposalRate = round(
        ($disposedItems / $totalDisposalItems) * 100
    );
}

// AVERAGE RESOLUTION TIME

$sql = "
SELECT
    r.type,
    AVG(TIMESTAMPDIFF(SECOND, r.created_at, rul.updated_at)) / 86400 AS avg_days
FROM reports r
JOIN reports_update_log rul
    ON r.report_id = rul.report_id
WHERE r.deleted = '0'
AND r.created_at BETWEEN :fromDate AND :toDate
AND (
    (r.type = 'Loss Report' AND rul.new_status = 'Resolved')
    OR
    (r.type = 'Surrender Form' AND rul.new_status = 'Accepted')
    OR
    (r.type = 'Claim request' AND rul.new_status = 'Accepted')
)
GROUP BY r.type
";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ":fromDate" => $from,
    ":toDate" => $to
]);

$resolutionTimes = [
    "Loss Report" => 0,
    "Surrender Form" => 0,
    "Claim request" => 0
];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $resolutionTimes[$row["type"]] =
        round((float)$row["avg_days"], 1);
}

$totalItems = array_sum($inventoryStatus);

// RESPONSE

$totalReports = array_sum($itemReports);

echo json_encode([
    "success" => true,

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
    "totalItems" => $totalItems,
    "totalReports" => $totalReports,
    "locationLabels" => $locationLabels,
    "locationData" => $locationData,
    "monthlyReports" => $monthlyReports,
    "claimSuccessRate" => $claimSuccessRate,
    "acceptedClaims" => $acceptedClaims,
    "totalClaims" => $totalClaims,
    "itemDisposalRate" => $itemDisposalRate,
    "disposedItems" => $disposedItems,
    "totalDisposalItems" => $totalDisposalItems,
    "resolutionTimes" => [
    "lossMatch" => $resolutionTimes["Loss Report"],
    "surrenderApproval" => $resolutionTimes["Surrender Form"],
    "claimVerification" => $resolutionTimes["Claim request"]
]

]);