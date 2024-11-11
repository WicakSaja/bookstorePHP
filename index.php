<?php

include 'model/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $pdo->query("SELECT books.id, books.title, books.author, books.image, books.description, categories.name AS category 
                          FROM books 
                          LEFT JOIN categories ON books.category_id = categories.id 
                          WHERE books.id = $id");
} else {
    $query = $pdo->query("SELECT books.id, books.title, books.author, books.image, books.description, categories.name AS category 
                          FROM books 
                          LEFT JOIN categories ON books.category_id = categories.id");
}

$books = $query->fetchAll();
$message = "";
if (!isset($books[0])) {
    $message = "<p style='margin-top: 15px;;color:crimson;font-size:14pt;'>tidak ada Buku untuk ditampilkan</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page Buku</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div style="width: 100%; display: flex; justify-content: end;">
        <a class="button" href="login.php" style="padding:10px 30px 10px 30px;">Admin</a>
    </div>
    <h1>Daftar Buku</h1>
    <div class="book-container">
        <?= $message?>
        <?php foreach ($books as $book): ?>
            <div class="book-card">
                <img src="upload/image/<?= $book['image'] ?>" alt="Gambar Buku">
                <div class="book-info">
                    <h3><?= $book['title'] ?></h3>
                    <b>Kategori: <?= $book['category']?></b><br><br>
                    <p>Penulis: <?= $book['author'] ?></p>
                    <p><?= $book['description'] ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
