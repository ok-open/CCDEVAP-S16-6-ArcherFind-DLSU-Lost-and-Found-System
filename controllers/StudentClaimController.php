<?php

require_once "../../db.php";
require_once "../../models/Item.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: student_item-view.php");
    exit();
}

$itemModel = new Item($conn);

$item = $itemModel->getItemById($_GET["id"]);

if (!$item) {
    header("Location: student_item-view.php");
    exit();
}