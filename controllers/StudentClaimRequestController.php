<?php

session_start();

require_once "../db.php";
require_once "../models/Reports.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../pages/student/student_claim-request.php");
    exit();
}

if (empty($_POST["item_id"])) {
    header("Location: ../pages/student/student_home.php?error=noitem");
    exit();
}

$itemId = $_POST["item_id"];

// ======================================================
// GET ITEM INFORMATION
// ======================================================

$itemQuery = "
    SELECT
        name,
        description,
        category_id,
        brand_id
    FROM items
    WHERE item_id = :item_id
";

$stmt = $conn->prepare($itemQuery);
$stmt->bindParam(":item_id", $itemId);
$stmt->execute();

$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    header("Location: ../pages/student/student_home.php?error=itemnotfound");
    exit();
}

$itemName = $item["name"];
$itemDescription = $item["description"];
$categoryId = $item["category_id"];
$brandId = $item["brand_id"];

// ======================================================
// LOCATION
// ======================================================

$roomId = !empty($_POST["room_id"])
    ? $_POST["room_id"]
    : null;

$areaId = !empty($_POST["area_id"])
    ? $_POST["area_id"]
    : null;

// ======================================================
// LOST DATE + TIME
// ======================================================

$whenLost = null;

if (!empty($_POST["date_lost"]) && !empty($_POST["time_lost"])) {
    $whenLost = $_POST["date_lost"] . " " . $_POST["time_lost"];
}

// ======================================================
// DESCRIPTION
// ======================================================

$details = trim($_POST["description"] ?? "");

// ======================================================
// CREATE REPORT
// ======================================================

$reportModel = new Reports($conn);

$result = $reportModel->createReport(
    $_SESSION["user_id"],
    $itemName,
    $itemDescription,
    $categoryId,
    $brandId,
    $itemId,
    $roomId,
    $areaId,
    $whenLost,
    $details,
    "Claim request"
);

if ($result) {

    // Get the newly created report ID
    $reportId = $conn->lastInsertId();

    // ==================================================
    // OPTIONAL IMAGE UPLOAD (supports up to 4 images)
    // ==================================================

    $allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/webp"];
    $uploadDirectory = dirname(__DIR__) . '/assets/IMG_ClaimRequest/';
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    if (isset($_FILES['images'])) {
        $files = $_FILES['images'];
        $count = is_array($files['name']) ? count($files['name']) : 0;
        for ($i = 0; $i < $count && $i < 4; $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;
            if (!in_array($files['type'][$i], $allowedTypes)) continue;

            $extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $filename = uniqid("claim_", true) . "." . $extension;
            $destination = $uploadDirectory . $filename;

            if (move_uploaded_file($files['tmp_name'][$i], $destination)) {
                $imagePath = "../../assets/IMG_ClaimRequest/" . $filename;
                $imageQuery = "INSERT INTO reports_images (report_id, img_filepath) VALUES (:report_id, :img_filepath)";
                $imageStmt = $conn->prepare($imageQuery);
                $imageStmt->bindParam(":report_id", $reportId);
                $imageStmt->bindParam(":img_filepath", $imagePath);
                $imageStmt->execute();
            }
        }
    } elseif (
        isset($_FILES["proof_image"]) &&
        $_FILES["proof_image"]["error"] === UPLOAD_ERR_OK
    ) {
        // Backwards compatibility for single 'proof_image' input
        if (in_array($_FILES["proof_image"]["type"], $allowedTypes)) {
            $extension = pathinfo($_FILES["proof_image"]["name"], PATHINFO_EXTENSION);
            $filename = uniqid("claim_", true) . "." . $extension;
            $destination = $uploadDirectory . $filename;

            if (move_uploaded_file($_FILES["proof_image"]["tmp_name"], $destination)) {
                $imagePath = "../../assets/IMG_ClaimRequest/" . $filename;
                $imageQuery = "INSERT INTO reports_images (report_id, img_filepath) VALUES (:report_id, :img_filepath)";
                $imageStmt = $conn->prepare($imageQuery);
                $imageStmt->bindParam(":report_id", $reportId);
                $imageStmt->bindParam(":img_filepath", $imagePath);
                $imageStmt->execute();
            }
        }
    }

    header(
        "Location: ../pages/student/student_claim-request.php?id="
        . $itemId .
        "&success=submitted&item=" . urlencode($itemName)
    );

    exit();
}

header(
    "Location: ../pages/student/student_claim-request.php?id="
    . $itemId .
    "&error=failed"
);

exit();

?>