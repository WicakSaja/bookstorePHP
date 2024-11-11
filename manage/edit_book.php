<?php
include '../model/database.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit;
}

$id = $_GET['id'];
$book = $pdo->query("SELECT * FROM books WHERE id = $id")->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category_id = $_POST['category_id'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploadDir = '../upload/image/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (file_exists($uploadDir . $book['image'])) {
            unlink($uploadDir . $book['image']);
        }

        $file = $_FILES['image'];
        $imageName = time() . "_" . basename($file['name']);
        $imagePath = $uploadDir . $imageName;

        if (move_uploaded_file($file['tmp_name'], $imagePath)) {
            $stmt = $pdo->prepare("UPDATE books SET title = ?, author = ?, category_id = ?, image = ? WHERE id = ?");
            $stmt->execute([$title, $author, $category_id, $imageName, $id]);
        } else {
            echo "Gagal mengunggah gambar.";
            exit;
        }
    } else {
        $stmt = $pdo->prepare("UPDATE books SET title = ?, author = ?, category_id = ? WHERE id = ?");
        $stmt->execute([$title, $author, $category_id, $id]);
    }

    header('Location: ../admin.php');
    exit;
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container" style="display:flex; justify-content:center">
        <form method="POST" enctype="multipart/form-data">
            <div style="display:flex; justify-content:end;">
                <a href="../admin.php" class="btn" style="margin:0px 0px 30px 0px">Back to Admin</a>
            </div>
            <h1>Edit Book</h1>
            <label>Title:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required><br>

            <label>Author:</label>
            <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required><br>

            <label>Category:</label>
            <select name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $book['category_id'] == $category['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br><br>
            <label>Current Image:</label><br>
            <img src="<?= "../upload/image/" . $book['image'] ?>" alt="Book Image" style="max-width: 200px;"><br><br>
            <label>Change Image:</label><br>
            <input type="file" name="image"><br><br>
            <button type="submit">Update Book</button>
        </form>
    </div>
</body>
</html>
