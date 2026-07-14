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
    echo "<script>console.log('--- ArcherFind Debugger Started ---');</script>";
    echo "<script>console.log('Action Received: " . addslashes($action) . " | Report ID: " . addslashes($reportId) . "');</script>";

    // Fetch details of the report before resolving it
    $sql = "SELECT type, student_id FROM reports WHERE report_id = :report_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':report_id', $reportId, PDO::PARAM_INT);
    $stmt->execute();
    $reportData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reportData) {
        echo "<script>console.log('Report Found! Type: " . addslashes($reportData['type']) . " | Student ID: " . addslashes($reportData['student_id']) . "');</script>";
    } else {
        echo "<script>console.log('❌ Error: No report found in database matching ID: " . addslashes($reportId) . "');</script>";
    }

    if ($action === 'resolve' || $action === 'Resolved') {
        echo "<script>console.log('Attempting database resolve via Trigger...');</script>";
        
        // This fires TRIGGER 3, creating the new record in the `items` table
        $resolvedSuccess = $reportModel->resolveReport($reportId, $staffId);
        echo "<script>console.log('resolveReport method executed.');</script>";

        // Handle Surrender Form Image Transfer
        if ($reportData && $reportData['type'] === 'Surrender Form') {
            $studentId = $reportData['student_id'];
            
            // Retrieve the newly created item_id (inserted by Trigger 3)
            $newItemId = $reportModel->getLastInsertedItem($studentId);
            
            if ($newItemId) {
                echo "<script>console.log('✅ Success: Matched item created in ITEMS table with ID: " . $newItemId . "');</script>";

                // Fetch all existing report images for this Surrender Form
                $imgSql = "SELECT img_filepath FROM reports_images WHERE report_id = :report_id";
                $imgStmt = $conn->prepare($imgSql);
                $imgStmt->bindParam(':report_id', $reportId, PDO::PARAM_INT);
                $imgStmt->execute();
                $images = $imgStmt->fetchAll(PDO::FETCH_ASSOC);

                echo "<script>console.log('Found " . count($images) . " image(s) for this surrender report in database.');</script>";

                foreach ($images as $img) {
                    $rawDatabasePath = $img['img_filepath']; // e.g., "../../assets/IMG_SurrenderForm/surrender3.png"
                    $fileName = basename($rawDatabasePath);

                    // 1. Get the absolute path to the project root directory
                    // Since this controller is inside /controllers, going up 1 level gets us to the root
                    $projectRoot = dirname(__DIR__); 

                    // 2. Build explicit paths from the root directory
                    // Stripping any "../../" prefixes to build clean, direct paths
                    $cleanSourceRelative = str_replace('../../', '', $rawDatabasePath); // e.g., "assets/IMG_SurrenderForm/surrender3.png"
                    $absoluteSourcePath = $projectRoot . '/' . $cleanSourceRelative;

                    $cleanTargetRelative = "assets/ITEMS/" . $fileName;
                    $absoluteTargetPath = $projectRoot . '/' . $cleanTargetRelative;
                    $targetDirectory = $projectRoot . '/assets/ITEMS/';

                    // 3. Ensure the target directory physically exists
                    if (!is_dir($targetDirectory)) {
                        mkdir($targetDirectory, 0777, true);
                    }

                    // 4. Copy the file and record the database entry
                    if (file_exists($absoluteSourcePath)) {
                        if (copy($absoluteSourcePath, $absoluteTargetPath)) {
                            // Record relative path in the items_images table
                            $dbRelativePath = "../../assets/ITEMS/" . $fileName;
                            $reportModel->insertItemImage($newItemId, $dbRelativePath);
                        } else {
                            error_log("ArcherFind Error: PHP copy() failed from $absoluteSourcePath to $absoluteTargetPath");
                        }
                    } else {
                        error_log("ArcherFind Error: Source file not found at: $absoluteSourcePath");
                    }
                }
            } else {
                echo "<script>console.log('❌ Error: Trigger 3 failed to insert an item, or getLastInsertedItem returned null.');</script>";
            }
        } else {
            echo "<script>console.log('Info: Report type is not \"Surrender Form\", skipping image replication.');</script>";
        }
    } elseif ($action === 'close' || $action === 'Closed') {
        $reportModel->closeReport($reportId, $staffId);
        echo "<script>console.log('Report Closed successfully.');</script>";
    }

    // -------------------------------------------------------------
    // STOPPING REDIRECT: To let you read the browser console.
    // -------------------------------------------------------------
    $search = $_REQUEST['search'] ?? '';
    $category = $_REQUEST['category'] ?? '';
    $sortBy = $_REQUEST['sort'] ?? 'recent';
    $redirectUrl = $_SERVER['PHP_SELF'] . "?search=" . urlencode($search) . "&category=" . urlencode($category) . "&sort=" . urlencode($sortBy);

    echo "<div style='background: #fff3cd; color: #856404; padding: 20px; border: 1px solid #ffeeba; margin: 20px; font-family: sans-serif; border-radius: 5px;'>";
    echo "<h3>🕵️ ArcherFind Debug Mode Active</h3>";
    echo "<p>Please <strong>Open your Browser Developer Tools Console (F12)</strong> to review the trace messages.</p>";
    echo "<a href='$redirectUrl' style='display: inline-block; background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; margin-top: 10px;'>Click here to return to layout list</a>";
    echo "</div>";
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