<?php
include '../model/database.php';

$id = $_GET['id'];
$pdo->query("DELETE FROM categories WHERE id = $id");

header('Location: categories.php');
?>
