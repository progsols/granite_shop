<?php include 'config.php'; $pdo = getDB(); $stmt = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC"); $gallery = $stmt->fetchAll(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Granite Elegance'; ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Premium granite slabs, tiles, and custom designs.'; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/granite/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Nav same as index.php -->

    <section class="container py-5">
        <h1 class="text-center mb-5">Our Projects</h1>
        <div class="masonry">
            <?php foreach ($gallery as $item): ?>
            <div class="bg-white p-3 rounded shadow mb-3">
                <img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                <h5 class="mt-2"><?php echo htmlspecialchars($item['title']); ?></h5>
                <p><?php echo htmlspecialchars($item['description']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
