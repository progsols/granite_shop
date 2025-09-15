<?php
session_start(); if (!$_SESSION['admin']) { header('Location: index.php'); exit; }
include '../config.php'; $pdo = getDB();

// Handle add/edit/delete
if ($_POST['action'] == 'add' || $_POST['action'] == 'edit') {
    $stmt = $pdo->prepare("INSERT INTO products (category, name, description, price, image) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE name=VALUES(name), description=VALUES(description), price=VALUES(price), image=VALUES(image)");
    $stmt->execute([$_POST['category'], $_POST['name'], $_POST['description'], $_POST['price'], $_FILES['image']['name']]); // Handle file upload properly
    // Move uploaded file: move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $_FILES['image']['name']);
}
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
}

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Granite Elegance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/granite/admin/css/admin.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
<h2>Add/Edit Product</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="add">
    Category: <select name="category"><option>slabs</option><option>tiles</option><option>countertops</option><option>custom</option></select><br>
    Name: <input type="text" name="name"><br>
    Description: <textarea name="description"></textarea><br>
    Price: <input type="number" name="price" step="0.01"><br>
    Image: <input type="file" name="image"><br>
    <button type="submit">Save</button>
</form>

<h2>Products List</h2>
<table border="1">
    <tr><th>ID</th><th>Name</th><th>Price</th><th>Actions</th></tr>
    <?php foreach ($products as $p): ?>
    <tr><td><?php echo $p['id']; ?></td><td><?php echo htmlspecialchars($p['name']); ?></td><td>$<?php echo $p['price']; ?></td><td><a href="?delete=<?php echo $p['id']; ?>">Delete</a></td></tr>
    <?php endforeach; ?>
</table>
<a href="gallery.php">Manage Gallery</a> | <a href="logout.php">Logout</a>
</body></html>
