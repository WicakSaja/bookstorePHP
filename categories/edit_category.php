<?php
include '../model/database.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php'); 
    exit;
}

$id = $_GET['id'];
$category = $pdo->query("SELECT * FROM categories WHERE id = $id")->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
    $stmt->execute([$name, $id]);

    header('Location: categories.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Category</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/admin.css">
</head>
<body>
    <div class="container">
        <h1>Edit Category</h1>
        <form method="POST">
            <label>Category Name:</label>
            <input type="text" name="name" value="<?= $category['name'] ?>" required>
            <button type="submit">Update Category</button>
        </form>
    </div>
</body>
</html>
