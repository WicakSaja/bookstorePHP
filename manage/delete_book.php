<?php
include '../model/database.php';

$id = $_GET['id'];

$book = $pdo->query("SELECT * FROM books WHERE id = $id")->fetch();
$pathDir = '../upload/image/';
if (file_exists($pathDir.$book['image'])) {
    unlink($pathDir.$book['image']);
}

$pdo->query("DELETE FROM books WHERE id = $id");
header('Location: ../admin.php');

