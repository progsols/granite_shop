<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}
include '../config.php';
$pdo = getDB();
$message = '';

// Handle add/edit
if ($_POST && ($_POST['action'] == 'add' || $_POST['action'] == 'edit')) {
    try {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $image = $_FILES['image']['name'] ? $_FILES['image']['name'] : ($_POST['existing_image'] ?? '');
        
        if ($_FILES['image']['name']) {
            $target = '../images/' . basename($_FILES['image']['name']);
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                throw new Exception('Failed to upload image.');
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO gallery (id, title, description, image) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE title=VALUES(title), description=VALUES(description), image=VALUES(image)");
        $id = $_POST['id'] ?: null;
        $stmt->execute([$id, $title, $description, $image]);
        $message = '<div class="alert alert-success">Gallery item saved successfully.</div>';
    } catch (Exception $e) {
        $message = '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        $message = '<div class="alert alert-success">Gallery item deleted successfully.</div>';
    } catch (Exception $e) {
        $message = '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}

// Fetch gallery items
$stmt = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC");
$gallery = $stmt->fetchAll();

// Fetch item for editing
$edit_item = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM gallery WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_item = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery - Granite Elegance Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/granite/admin/css/admin.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="nav-links">
            <a href="products.php">Manage Products</a> |
            <a href="gallery.php">Manage Gallery</a> |
            <a href="logout.php">Logout</a>
        </div>
        <h2><?php echo $edit_item ? 'Edit Gallery Item' : 'Add Gallery Item'; ?></h2>
        <?php echo $message; ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?php echo $edit_item ? 'edit' : 'add'; ?>">
            <input type="hidden" name="id" value="<?php echo $edit_item['id'] ?? ''; ?>">
            <input type="hidden" name="existing_image" value="<?php echo $edit_item['image'] ?? ''; ?>">
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo $edit_item ? htmlspecialchars($edit_item['title']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4"><?php echo $edit_item ? htmlspecialchars($edit_item['description']) : ''; ?></textarea>
            </div>
            <div class="mb-3">
                <label>Image (JPG/PNG, <2MB)</label>
                <input type="file" name="image" class="form-control" <?php echo !$edit_item ? 'required' : ''; ?>>
                <?php if ($edit_item && $edit_item['image']): ?>
                    <small>Current: <img src="../images/<?php echo htmlspecialchars($edit_item['image']); ?>" alt="Current Image" style="max-width: 100px; margin-top: 10px;"></small>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <?php if ($edit_item): ?>
                <a href="gallery.php" class="btn btn-secondary">Cancel</a>
            <?php endif; ?>
        </form>

        <h2>Gallery Items</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gallery as $item): ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                    <td><img src="../images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" style="max-width: 50px;"></td>
                    <td>
                        <a href="?edit=<?php echo $item['id']; ?>">Edit</a> |
                        <a href="?delete=<?php echo $item['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
