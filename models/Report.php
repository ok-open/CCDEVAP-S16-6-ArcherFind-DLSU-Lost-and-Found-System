<?php
//this is the Model, Report.php
class Reports{
    private $conn;

    public function __construct($database)
    {
        $this->conn = $database;
    }
    
    /**
     * Retrieves Active Claim Requests along with matching found item inventory details,
     * proof of ownership texts, and claimant uploads.
     */
    public function getClaimRequests($search = '', $category = '', $sortBy = 'recent')
    {
        $sql = "SELECT 
                    -- 1. CLAIM REQUEST REPORT DETAILS
                    r.report_id,
                    r.item_name AS claim_item_name,
                    r.item_description AS claim_description,
                    DATE(r.when_lost) AS date_lost,
                    TIME(r.when_lost) AS time_lost,
                    DATE(r.created_at) AS filed_on,
                    r.extra_details AS proof_of_ownership_text,
                    r.student_id,
                    
                    -- 2. CLAIMANT USER DETAILS
                    CONCAT(u.first_name, ' ', u.last_name) AS student_name,
                    u.email AS student_email,
                    
                    -- 3. FOUND ITEM INVENTORY DETAILS (From Items Table)
                    i.item_id,
                    i.name AS found_item_name,
                    DATE(i.when_found) AS date_found,
                    TIME(i.when_found) AS time_found,
                    COALESCE(irms.name, iars.name, 'Unknown Location') AS location_found,
                    
                    -- 4. ALL IMAGES OF THE FOUND ITEM (Aggregated safely via isolated Subquery)
                    (SELECT GROUP_CONCAT(ii.img_filepath ORDER BY ii.image_id ASC SEPARATOR ',') 
                    FROM items_images ii 
                    WHERE ii.item_id = i.item_id) AS found_item_image,
                    
                    -- 5. CLAIMANT'S UPLOADED PROOF IMAGES (Aggregated safely via isolated Subquery)
                    (SELECT GROUP_CONCAT(ri.img_filepath ORDER BY ri.image_id ASC SEPARATOR ',') 
                    FROM reports_images ri 
                    WHERE ri.report_id = r.report_id) AS proof_images,
                    
                    -- Report Location
                    COALESCE(rrms.name, rars.name, 'Unknown Location') AS location_lost

                FROM reports r
                INNER JOIN users u 
                    ON r.student_id = u.user_id
                -- Link Claim Request back to the matching Found Item in storage
                LEFT JOIN items i 
                    ON r.item_id = i.item_id
                -- Location resolved for Found Item
                LEFT JOIN rooms irms 
                    ON i.room_id = irms.room_id
                LEFT JOIN areas iars 
                    ON i.area_id = iars.area_id
                -- Location resolved for Claim Request
                LEFT JOIN rooms rrms 
                    ON r.room_id = rrms.room_id
                LEFT JOIN areas rars 
                    ON r.area_id = rars.area_id
                -- Categories helper
                LEFT JOIN categories cat 
                    ON r.category_id = cat.category_id

                WHERE r.type = 'Claim request' 
                AND r.status = 'Active'
                AND r.deleted = '0'";

        // Apply Dynamic Filters
        if (!empty($search)) {
            $sql .= " AND r.item_name LIKE :search";
        }

        if (!empty($category)) {
            $sql .= " AND cat.name = :category";
        }

        // Sorting Setup
        if ($sortBy === 'name') {
            $sql .= " ORDER BY r.item_name ASC";
        } else {
            $sql .= " ORDER BY r.created_at DESC";
        }

        $stmt = $this->conn->prepare($sql);

        if (!empty($search)) {
            $searchParam = "%" . $search . "%";
            $stmt->bindParam(':search', $searchParam);
        }

        if (!empty($category)) {
            $stmt->bindParam(':category', $category);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Retrieving Active Loss Reports
    // Retrieving Active Loss Reports with Dynamic Filters
    public function getLossReports($search = '', $category = '', $sortBy = 'recent')
    {
        // 1. Base SQL Query (We left join the categories table to match by category name)
        $sql = "SELECT 
                r.report_id,
                r.item_name,
                DATE(r.when_lost) AS date_lost,
                TIME(r.when_lost) AS time_lost,
                DATE(r.created_at) AS filed_on,
                CONCAT(u.first_name, ' ', u.last_name) AS student_name,
                u.email AS student_email,               
                COALESCE(rms.name, ars.name, 'Unknown Location') AS location_lost,
                GROUP_CONCAT(ri.img_filepath ORDER BY ri.image_id ASC) AS image_paths
                FROM reports r
                INNER JOIN users u 
                    ON r.student_id = u.user_id
                LEFT JOIN rooms rms 
                    ON r.room_id = rms.room_id
                LEFT JOIN areas ars 
                    ON r.area_id = ars.area_id
                LEFT JOIN reports_images ri 
                    ON r.report_id = ri.report_id
                LEFT JOIN categories cat 
                    ON r.category_id = cat.category_id
                WHERE r.type = 'Loss Report' 
                AND r.status = 'Active'
                AND r.deleted = '0'";

        // 2. Append Dynamic WHERE Conditions
        if (!empty($search)) {
            $sql .= " AND r.item_name LIKE :search";
        }

        if (!empty($category)) {
            $sql .= " AND cat.name = :category";
        }

        // Group by report_id because of GROUP_CONCAT
        $sql .= " GROUP BY r.report_id";

        // 3. Dynamic ORDER BY (SQL variables cannot be parameterized, so we hardcode the safe choices)
        if ($sortBy === 'name') {
            $sql .= " ORDER BY r.item_name ASC";
        } else {
            // Default to 'recent'
            $sql .= " ORDER BY r.created_at DESC";
        }

        // 4. Prepare & Bind parameters
        $stmt = $this->conn->prepare($sql);

        if (!empty($search)) {
            $searchParam = "%" . $search . "%";
            $stmt->bindParam(':search', $searchParam);
        }

        if (!empty($category)) {
            $stmt->bindParam(':category', $category);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPossibleMatches($itemName) {
    // 1. Clean and split the item name into individual search terms (words)
    // Example: "Black Oversize Hoodie" -> ['Black', 'Oversize', 'Hoodie']
    $words = preg_split('/\s+/', trim($itemName));
    $words = array_filter($words, function($word) {
        // Filter out short/common stop words like "a", "an", "the", "with", "of" 
        return strlen($word) > 3; 
    });

    // If no valid search words remain, default back to the entire string
    if (empty($words)) {
        $words = [$itemName];
    }

    // 2. Build dynamic SQL with OR conditions for each keyword
    $sql = "SELECT 
                i.item_id,
                i.name AS item_name,
                i.description,
                COALESCE(rms.name, ars.name, 'Unknown Location') AS location_found,
                i.when_found,
                -- Get the first image associated with this item as its thumbnail
                (SELECT img_filepath 
                 FROM items_images 
                 WHERE item_id = i.item_id 
                 LIMIT 1) AS primary_image
            FROM items i
            LEFT JOIN rooms rms ON i.room_id = rms.room_id
            LEFT JOIN areas ars ON i.area_id = ars.area_id
            WHERE i.status = 'In Storage' ";

    // Append keyword matching constraints
    $conditions = [];
    foreach ($words as $index => $word) {
        $conditions[] = "i.name LIKE :word_" . $index;
    }

    if (!empty($conditions)) {
        $sql .= " AND (" . implode(" OR ", $conditions) . ")";
    }

    // Order matches by relevance (approximate: sorting newer items first)
    $sql .= " ORDER BY i.when_found DESC LIMIT 10;";

    $stmt = $this->conn->prepare($sql);

    // 3. Bind each keyword parameter safely
    foreach ($words as $index => $word) {
        $paramValue = "%" . $word . "%";
        $stmt->bindValue(":word_" . $index, $paramValue);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getCategories()
    {
        $sql = "
            SELECT
                category_id,
                name
            FROM categories
            WHERE deleted = '0'
            ORDER BY name ASC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function resolveReport($reportId, $staffId) {
        $sql = "UPDATE reports 
                SET status = 'Resolved', 
                    reviewed_by = :staff_id,
                    last_updated = NOW()
                WHERE report_id = :report_id ";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':report_id', $reportId, PDO::PARAM_INT);
        $stmt->bindParam(':staff_id', $staffId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function closeReport($reportId, $staffId) {
        $sql = "UPDATE reports 
                SET status = 'Closed', 
                    reviewed_by = :staff_id,
                    last_updated = NOW()
                WHERE report_id = :report_id ";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':report_id', $reportId, PDO::PARAM_INT);
        $stmt->bindParam(':staff_id', $staffId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}



?>