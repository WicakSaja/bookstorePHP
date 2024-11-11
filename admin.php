<?php
session_start(); // Memulai session
include 'model/database.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php'); 
    exit;
}

$query = $pdo->query("SELECT books.id, books.title, books.author, categories.name AS category 
                      FROM books 
                      LEFT JOIN categories ON books.category_id = categories.id");
$books = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-book Management</title>
    <link rel="stylesheet" href="assets/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>E-book List</h1>
        <div style="display:flex;justify-content:space-between">
            <div>
                <a href="manage/add_book.php">Add New Book</a>
                <a href="categories/categories.php">Manage Categories</a>
            </div>
            <div>
                <a href="index.php">View</a>
                <a href="logout.php" onclick="return confirm('Are you sure?')">Logout</a>
            </div>
        </div>
            <table border="1">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= $book['title'] ?></td>
                    <td><?= $book['author'] ?></td>
                    <td><?= $book['category'] ?></td>
                    <td>
                        <a href="manage/edit_book.php?id=<?= $book['id'] ?>">Edit</a> 
                        <a href="manage/delete_book.php?id=<?= $book['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
