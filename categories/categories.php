<?php
include '../model/database.php';
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php'); 
    exit;
}
// Ambil semua kategori
$query = $pdo->query("SELECT * FROM categories");
$categories = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/admin.css">
</head>
<body>
    <div class="container">
        <h1>Categories</h1>
        <div style="display:flex;justify-content:space-between">
        <a href="add_category.php">Add New Category</a>
        <a href="../admin.php" class="button">Back to Admin</a>
        </div>
        <table>
            <tr>
                <th>NO</th>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
            <?php 
            $nomor = 1;
            foreach ($categories as $category): ?>
                <tr>
                    <td><?= $nomor++ ?></td>
                    <td><?= $category['name'] ?></td>
                    <td>
                        <a href="edit_category.php?id=<?= $category['id'] ?>">Edit</a>
                        <a href="delete_category.php?id=<?= $category['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
