<?php
    require_once "../../controllers/StudentAuth.php";
    require_once "../../controllers/LocationController.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArcherFind - Claim Request</title>

    <link rel="stylesheet" href="../../styles/global/global.css">
    <link rel="stylesheet" href="../../styles/global/navbar.css">
    <link rel="stylesheet" href="../../styles/student/student_claim-request.css">
    <script src="../../javascript/global/navbar.js" defer></script>
    <script src="../../javascript/global/image.js" defer></script>
    <script src="../../javascript/student/student_claim-request.js" defer></script>
</head>

<body>
    <!------------------------ NAVIGATION BAR / HEADER ------------------------>
    <header>
        <button class="archerfind-logo" onclick="window.location.href='student_home.php'">
            <h1>ArcherFind</h1>
            <img class="logo" src="../../assets/LOGOS/AF-ORIGINAL.png" alt="ArcherFind logo">
        </button>

        <!-- NAVBAR OPTIONS -->
        <nav class="navbar">
            <ul class="nav-links">
                <li><a href="../../pages/student/student_home.php">Home</a></li>
                <li><a href="../../pages/student/student_about.php">About</a></li>
                <!-- DROPDOWN MENU -->
                <li class="dropdown">
                    <a class="active current-page">Lost and Found<i class="arrow down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="../../pages/student/student_item-view.php" class="current-page">Report Lost</a></li>
                        <li><a href="../../pages/student/student_surrender-form.php">Report Found</a></li>
                    </ul>
                </li>
                <li><a href="../../pages/student/student_contact.php">Contact Us</a></li>
                <li>
                    <!-- user profile -->
                    <div class="user-button"><button type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                                <path
                                    d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm146.5-204.5Q340-521 340-580t40.5-99.5Q421-720 480-720t99.5 40.5Q620-639 620-580t-40.5 99.5Q539-440 480-440t-99.5-40.5ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z" />
                            </svg>
                        </button>
                        <div class="user-profile">
                            <p class="user-greeting">Welcome back,<br>
                                <span class="name_of_user">
                                    <?= htmlspecialchars($_SESSION["first_name"]) ?>
                                </span>
                            </p>
                            <button type="button" class="manage-account" onclick="location.href='../../pages/student/student_manage-account'">Manage Account</button>
                            <div class="user-profile-container">
                                <div class="day-night"><button type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"> <path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Z" /> </svg> <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"> <path d="M338.5-338.5Q280-397 280-480t58.5-141.5Q397-680 480-680t141.5 58.5Q680-563 680-480t-58.5 141.5Q563-280 480-280t-141.5-58.5ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Z" /> </svg> <span></span>
                                    </button></div>
                                <div class="log-out"><button type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"> <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z" /> </svg>Log Out</button></div>
                                <div class="view-dashboard"><button type="button">View Dashboard</button></div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- SIDEBAR OPTIONS -->
        <nav class="sidebar">
            <ul class="nav-links">
                <li><a href="../../pages/student/student_home.php">Home</a></li>
                <li><a href="../../pages/student/student_about.php" class="current-page">About</a></li>
                <!-- DROPDOWN MENU -->
                <li class="dropdown">
                    <a class="active">Lost and Found<i class="arrow down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="../../pages/student/student_item-view.php">> Report Lost</a></li>
                        <li><a href="../../pages/student/student_surrender-form.php">> Report Found</a></li>
                    </ul>
                </li>
                <li><a href="../../pages/student/student_contact.php">Contact Us</a></li>
            </ul>

            <!-- user profile -->
            <div class="user-button"><button type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"> <path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm146.5-204.5Q340-521 340-580t40.5-99.5Q421-720 480-720t99.5 40.5Q620-639 620-580t-40.5 99.5Q539-440 480-440t-99.5-40.5ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z" /> </svg>
                </button>
                <div class="user-profile">
                    <p class="user-greeting">Welcome back,<br>
                        <span class="name_of_user">
                            <?= htmlspecialchars($_SESSION["first_name"]) ?>
                        </span>
                    </p>
                    <button type="button" class="manage-account" onclick="location.href='../../pages/student/student_manage-account'">Manage Account</button>
                    <div class="user-profile-container">
                        <div class="day-night"><button type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"> <path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Z" /> </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"> <path d="M338.5-338.5Q280-397 280-480t58.5-141.5Q397-680 480-680t141.5 58.5Q680-563 680-480t-58.5 141.5Q563-280 480-280t-141.5-58.5ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Z" /> </svg>
                            </button></div>
                        <div class="log-out"><button type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"> <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z" /> </svg>Log Out</button></div>
                        <div class="view-dashboard"><button type="button">View Dashboard</button></div>
                    </div>
                </div>
            </div>

            <div class="sidebar-open-close"><button type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                        <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                        <path
                            d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                    </svg>
                </button></div>
        </nav>
    </header>
    <!-------------------- END OF NAVIGATION BAR / HEADER --------------------->

    <div class="claim-wrapper">
        <h2 class="claim-title">Request to Claim an Item</h2>

        <form class="claim-form" method="POST" enctype="multipart/form-data" action="../../controllers/StudentClaimRequestController.php">            
            <input type="hidden" name="item_id" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>">
            <div class="claim-left">
                <h3 class="claim-section-title">Student Information</h3>

                <div class="form-group">
                    <label>Student Name</label>
                    <input type="text"  class="claim-input"  value="<?= htmlspecialchars($_SESSION['first_name'] . " " . $_SESSION['last_name']) ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Student Email</label>
                    <input type="email" class="claim-input"  value="<?= htmlspecialchars($_SESSION['email']) ?>"  readonly>
                </div>

                <h3 class="claim-section-title">Where was this lost?</h3>
                <div class="claim-location-row">
                    <div class="form-group">
                        <label>Building <span class="required">required field</span></label>
                            <select class="claim-input" id="building_id" name="building_id" required>
                                <option value="">Select Building</option>
                                <?php foreach ($buildings as $building): ?>
                                    <option
                                        value="<?= $building["building_id"] ?>"
                                        data-max-level="<?= $building["max_level"] ?>">
                                        <?= htmlspecialchars($building["name"]) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                    </div>

                    <div class="form-group">
                        <label>Floor number <span class="required">required field</span></label>
                        <input type="number" class="claim-input" id="floor_number" name="floor_number" min="1" required>                        <!-- FOR BACKEND: the max="", based on the building selected you will retrieve the max floor field -->
                        <!-- This floorNum input is not submitted with the form/report, it is just to filter the selection dropdown for area and room -->
                    </div>
                </div>

                <div class="claim-location-row">
                    <div class="form-group">
                        <label>Area <span class="required">at least one required</span></label>
                        <select class="claim-input" id="area_id" name="area_id">
                            <option value="">Select Area</option>
                            <?php foreach ($areas as $area): ?>
                                <option
                                    value="<?= $area["area_id"] ?>"
                                    data-building="<?= $area["building_id"] ?>"
                                    data-level="<?= $area["level"] ?>">
                                    <?= htmlspecialchars($area["name"]) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Room <span class="required">at least one required</span></label>
                        <select class="claim-input" id="room_id" name="room_id">
                            <option value="">Select Room</option>
                            <?php foreach ($rooms as $room): ?>
                                <option
                                    value="<?= $room["room_id"] ?>"
                                    data-building="<?= $room["building_id"] ?>"
                                    data-level="<?= $room["level"] ?>">
                                    <?= htmlspecialchars($room["name"]) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <h3 class="claim-section-title">When was this lost?</h3>
                <div class="claim-date-row">
                    <div class="form-group">
                        <label>Date Lost <span class="required">required field</span></label>
                        <input type="date" class="claim-input" name="date_lost" required>
                    </div>

                    <div class="form-group">
                        <label>Time Lost <span class="required">required field</span></label>
                        <input type="time" class="claim-input" name="time_lost" required>
                    </div>
                </div>
            </div>

            <div class="claim-right">
                <h3 class="claim-section-title">Item Verification</h3>
                <div class="form-group">
                    <label>
                        Upload Proof of Ownership <span class="optional">optional</span>
                    </label>

                <label class="upload-box">
                    <input type="file"  name="proof_image" accept="image/*">

                    <span class="upload-text">Click to Upload Image</span>

                    <img class="preview-image" alt="">
                </label>
                </div>

                <div class="form-group">
                    <label>
                        Describe Features <span class="required">required</span>
                    </label>

                    <textarea class="claim-input claim-textarea" name="description" placeholder="Include details like scratches, stickers..."required></textarea>
                </div>

                <button type="submit" class="claim-submit-btn">
                    Submit Claim Request
                </button>
            </div>
        </form>
    </div>
    <div id="toast"></div>
</body>
</html>