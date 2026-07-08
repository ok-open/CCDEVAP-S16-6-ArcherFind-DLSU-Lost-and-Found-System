
<?php
// TESTING PURPOSES ONLYY
// Force PHP to display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Include your database connection
require_once '../../db.php';

// For testing purposes, we are looking for item_id = 1 (the iPhone 15 Pro)
$item_id = 1;

try {
    // 1. Fetch the item details
    $item_stmt = $conn->prepare("SELECT name, description FROM items WHERE item_id = :item_id");
    $item_stmt->execute(['item_id' => $item_id]);
    $item = $item_stmt->fetch(PDO::FETCH_ASSOC);

    // 2. Fetch all images associated with this item
    $img_stmt = $conn->prepare("SELECT img_filepath FROM items_images WHERE item_id = :item_id");
    $img_stmt->execute(['item_id' => $item_id]);
    $images = $img_stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image Retrieval Test</title>
</head>
<body>

    <?php if ($item): ?>
        <h1>Item: <?php echo htmlspecialchars($item['name']); ?></h1>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($item['description']); ?></p>
        
        <hr>

        <h3>Retrieved Images:</h3>
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $img): ?>
                <div style="margin-bottom: 20px;">
                    <p>Filepath: <code><?php echo htmlspecialchars($img['img_filepath']); ?></code></p>
                    
                    <img src="<?php echo htmlspecialchars($img['img_filepath']); ?>" alt="Item Image" style="max-width: 300px; height: auto; border: 1px solid #ccc;">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No images found in the database for this item.</p>
        <?php endif; ?>

    <?php else: ?>
        <p>Item with ID <?php echo $item_id; ?> not found. Ensure you inserted the item row before inserting its images!</p>
    <?php endif; ?>

</body>
</html>