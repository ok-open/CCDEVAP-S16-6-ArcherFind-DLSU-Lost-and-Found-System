<?php

session_start();

require_once "../db.php";
require_once "../models/Reports.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../pages/student/student_surrender-form.php");
    exit();
}

if (empty($_POST["name"])) {
    header("Location: ../pages/student/student_surrender-form.php?error=noitem");
    exit();
}

$itemName = trim($_POST["name"]);
$itemDescription = trim($_POST["description"] ?? "");
$categoryId = !empty($_POST["category_id"]) ? $_POST["category_id"] : null;
$brandInput = trim($_POST["brand"] ?? "");
if ($brandInput) {
    $itemDescription = $brandInput . (!empty($itemDescription) ? " - " . $itemDescription : "");
}
$brandId = null;

$roomId = !empty($_POST["room_id"]) ? $_POST["room_id"] : null;
$areaId = !empty($_POST["area_id"]) ? $_POST["area_id"] : null;

$whenFound = null;
if (!empty($_POST["when_found"]) && !empty($_POST["when_found_time"])) {
    $whenFound = $_POST["when_found"] . " " . $_POST["when_found_time"];
}

$reportModel = new Reports($conn);
$reportType = "Surrender Form";

$result = $reportModel->createReport(
    $_SESSION["user_id"],
    $itemName,
    $itemDescription,
    $categoryId,
    $brandId,
    null,
    $roomId,
    $areaId,
    $whenFound,
    "",
    $reportType
);

if ($result) {
    $reportId = $conn->lastInsertId();

    if (
        isset($_FILES["image"]) &&
        $_FILES["image"]["error"] === UPLOAD_ERR_OK
    ) {
        $allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/webp"];

        if (in_array($_FILES["image"]["type"], $allowedTypes)) {
            $uploadDirectory = "../assets/IMG_SurrenderForm/";
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $filename = uniqid("surrender_", true) . "." . $extension;
            $destination = $uploadDirectory . $filename;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $destination)) {
                $imagePath = "assets/IMG_SurrenderForm/" . $filename;
                $imageQuery = "
                    INSERT INTO reports_images
                    (
                        report_id,
                        img_filepath
                    )
                    VALUES
                    (
                        :report_id,
                        :img_filepath
                    )
                ";
                $imageStmt = $conn->prepare($imageQuery);
                $imageStmt->bindParam(":report_id", $reportId);
                $imageStmt->bindParam(":img_filepath", $imagePath);
                $imageStmt->execute();
            }
        }
    }

    header("Location: ../pages/student/student_surrender-form.php?success=submitted&item=" . urlencode($itemName));
    exit();
}

header("Location: ../pages/student/student_surrender-form.php?error=failed");
exit();
?>
