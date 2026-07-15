<?php

require_once "../../db.php";
require_once "../../models/Item.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: student_item-view.php");
    exit();
}

$itemModel = new Item($conn);

$search = trim($_GET["search"] ?? "");
$category = trim($_GET["category"] ?? "");
$sort = $_GET["sort"] ?? "recent";

$categories = $itemModel->getCategories();

$item = $itemModel->getItemById($_GET["id"]);

if (!$item) {
    header("Location: student_item-view.php");
    exit();
}