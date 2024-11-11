<?php
include '../model/database.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php'); 
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $file = $_FILES['image'];
    
    $uploadDir = '../upload/image/';
    $imageName = time() . "_" . basename($file['name']);
    $imagePath = $uploadDir . $imageName;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($file['tmp_name'], $imagePath)) {
        $stmt = $pdo->prepare("INSERT INTO books (title, author, category_id, image, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $author, $category_id, $imageName, $description]);

        header('Location: ../admin.php');
        exit;
    } else {
        echo "Gagal mengunggah gambar.";
    }
}

// Mengambil semua data kategori dari tabel categories
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container" style="display: flex;justify-content:center">
        <form method="POST" enctype="multipart/form-data">
            <div style="display:flex; justify-content:end;">
                <a href="../admin.php" class="btn" style="margin:0px 0px 30px 0px">Back to Admin</a>
            </div>
            <h1>Add New Book</h1>
            <label>Title:</label>
            <input type="text" name="title" required><br>

            <label>Author:</label>
            <input type="text" name="author" required><br>

            <label>Category:</label>
            <select name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option> 
                <?php endforeach; ?>
            </select><br><br>

            <label for="image">Book Image:</label>
            <input type="file" name="image" required><br><br>

            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>
            <button type="submit">Add Book</button>
        </form>
    </div>
</body>
</html>
