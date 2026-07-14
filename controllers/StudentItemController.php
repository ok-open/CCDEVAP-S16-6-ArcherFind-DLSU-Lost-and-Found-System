<?php

require_once "../../db.php";
require_once "../../models/Item.php";

$itemModel = new Item($conn);

$search = trim($_GET["search"] ?? "");
$category = trim($_GET["category"] ?? "");
$sort = $_GET["sort"] ?? "recent";

$items = $itemModel->getAvailableItems(
    $search,
    $category,
    $sort
);

$categories = $itemModel->getCategories();