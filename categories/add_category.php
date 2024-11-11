<?php
include '../model/database.php';
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php'); 
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];

    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->execute([$name]);

    header('Location: categories.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Category</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/admin.css">
</head>
<body>
    <div class="container">
        <h1>Add New Category</h1>
        <form method="POST">
            <label>Category Name:</label>
            <input type="text" name="name" required>
            <button type="submit">Add Category</button>
        </form>
    </div>
</body>
</html>
