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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $reportId = $_POST['report_id'] ?? null;
    $action = $_POST['action'];

    if ($reportId) {
        if ($action === 'resolve') {
            $reportModel->resolveReport($reportId, $staffId);
        } elseif ($action === 'close') {
            $reportModel->closeReport($reportId, $staffId);
        }
        
        // Rebuild query parameters so user doesn't lose current filters upon refresh
        $search = $_POST['search'] ?? '';
        $category = $_POST['category'] ?? '';
        $sortBy = $_POST['sort'] ?? 'recent';
        
        header("Location: " . $_SERVER['PHP_SELF'] . "?search=" . urlencode($search) . "&category=" . urlencode($category) . "&sort=" . urlencode($sortBy));
        exit();
    }
}

// 1. Gather filter inputs from GET query parameters
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$sortBy = $_GET['sort'] ?? 'recent'; // default to 'recent'

$reportModel = new Reports($conn);

// 2. Fetch the filtered results
$lossReports = $reportModel->getLossReports($search, $category, $sortBy);
$claimRequests = $reportModel->getClaimRequests($search, $category, $sortBy);

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