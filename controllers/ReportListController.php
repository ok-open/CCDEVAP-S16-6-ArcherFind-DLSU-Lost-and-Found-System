<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// This is the controller, ReportListController.php
require_once "../../db.php";
require_once "../../models/Report.php";

// Start session if not already started to get the current staff user ID
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Assuming your login flow stores the logged-in user's ID in $_SESSION['user_id']
$staffId = $_SESSION['user_id'] ?? 1; // Fallback to 1 for testing if session is not active yet

$reportModel = new Reports($conn);

// ------------------- NEW: HANDLE STATUS UPDATES (POST) -------------------
// 1. Accept both POST and GET requests dynamically
$reportId = $_REQUEST['report_id'] ?? null;
$action = $_REQUEST['action'] ?? null;

if ($reportId && $action) {
    // Fetch details of the report before resolving it
    $sql = "SELECT type, student_id FROM reports WHERE report_id = :report_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':report_id', $reportId, PDO::PARAM_INT);
    $stmt->execute();
    $reportData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($action === 'resolve' || $action === 'Resolved') {
        // This fires TRIGGER 3, creating the new record in the `items` table
        $reportModel->resolveReport($reportId, $staffId);

        // Handle Surrender Form Image Transfer
        if ($reportData && $reportData['type'] === 'Surrender Form') {
            $studentId = $reportData['student_id'];
            
            // Retrieve the newly created item_id (inserted by Trigger 3)
            $newItemId = $reportModel->getLastInsertedItem($studentId);
            
            if ($newItemId) {
                // Fetch all existing report images for this Surrender Form
                $imgSql = "SELECT img_filepath FROM reports_images WHERE report_id = :report_id";
                $imgStmt = $conn->prepare($imgSql);
                $imgStmt->bindParam(':report_id', $reportId, PDO::PARAM_INT);
                $imgStmt->execute();
                $images = $imgStmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($images as $img) {
                    $rawDatabasePath = $img['img_filepath']; // e.g., "../../assets/IMG_SurrenderForm/surrender7.png"
                    $fileName = basename($rawDatabasePath); // e.g., "surrender7.png"

                    // Absolute Project Root Directory on disk
                    $projectRoot = dirname(__DIR__); 

                    // Absolute paths (no relative backtracking) for filesystem operations
                    $cleanSourceRelative = str_replace('../../', '', $rawDatabasePath); 
                    $absoluteSourcePath = $projectRoot . '/' . $cleanSourceRelative;
                    $absoluteTargetPath = $projectRoot . '/assets/ITEMS/' . $fileName;
                    $targetDirectory = $projectRoot . '/assets/ITEMS/';

                    // Ensure target directory exists on disk
                    if (!is_dir($targetDirectory)) {
                        mkdir($targetDirectory, 0777, true);
                    }

                    // Perform the physical copy on disk
                    if (file_exists($absoluteSourcePath)) {
                        if (copy($absoluteSourcePath, $absoluteTargetPath)) {
                            // Save with relative "../../" format for frontend template display
                            $dbRelativePath = "../../assets/ITEMS/" . $fileName;
                            $reportModel->insertItemImage($newItemId, $dbRelativePath);
                        } else {
                            error_log("ArcherFind Error: PHP copy() failed from $absoluteSourcePath to $absoluteTargetPath");
                        }
                    } else {
                        error_log("ArcherFind Error: Source file not found at: $absoluteSourcePath");
                    }
                }
            }
        }
    } elseif ($action === 'close' || $action === 'Closed') {
        $reportModel->closeReport($reportId, $staffId);
    }

    // 2. Seamless Automatic Redirection (Preserving view filter query strings)
    $search = $_REQUEST['search'] ?? '';
    $category = $_REQUEST['category'] ?? '';
    $sortBy = $_REQUEST['sort'] ?? 'recent';
    header("Location: " . $_SERVER['PHP_SELF'] . "?search=" . urlencode($search) . "&category=" . urlencode($category) . "&sort=" . urlencode($sortBy));
    exit();
}

// 1. Gather filter inputs from GET query parameters
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$sortBy = $_GET['sort'] ?? 'recent'; // default to 'recent'

$reportModel = new Reports($conn);

// 2. Fetch the filtered results
$lossReports = $reportModel->getLossReports($search, $category, $sortBy);
$claimRequests = $reportModel->getClaimRequests($search, $category, $sortBy);
$surrenderForms = $reportModel->getSurrenderForms($search, $category, $sortBy);


// 3. NEW: Check if the user clicked "Possible Matches" on a specific report
$selectedReportId = $_GET['selected_report'] ?? null;
$possibleMatches = [];
$selectedReportName = "";

if ($selectedReportId) {
    // Locate the selected report in our current array to get its item_name
    foreach ($lossReports as $report) {
        if ($report['report_id'] == $selectedReportId) {
            $selectedReportName = $report['item_name'];
            // Fetch matches directly from the model using the function we made
            $possibleMatches = $reportModel->getPossibleMatches($selectedReportName);
            break;
        }
    }
}

$categories = $reportModel->getCategories();

?>