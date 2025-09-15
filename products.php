<?php include 'config.php'; $pdo = getDB(); 
$category = $_GET['cat'] ?? ''; 
$query = $category ? "SELECT * FROM products WHERE category = ?" : "SELECT * FROM products"; 
$stmt = $pdo->prepare($query); 
if ($category) $stmt->execute([$category]); else $stmt->execute(); 
$products = $stmt->fetchAll(); 
?>
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light"> <!-- Copy nav from index.php --> </nav>

    <section class="container py-5">
        <h1 class="text-center mb-5"><?php echo ucfirst($category ?: 'All Products'); ?></h1>
        <div class="row">
            <?php foreach ($products as $prod): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <img src="images/<?php echo htmlspecialchars($prod['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($prod['name']); ?>" loading="lazy">
                    <div class="card-body">
                        <h5><?php echo htmlspecialchars($prod['name']); ?></h5>
                        <p><?php echo htmlspecialchars($prod['description']); ?></p>
                        <p class="fw-bold text-success">$<?php echo number_format($prod['price'], 2); ?></p>
                        <a href="contact.php?prod=<?php echo $prod['id']; ?>" class="btn btn-primary">Inquire</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="products.php?cat=slabs" class="btn btn-outline-dark me-2">Slabs</a>
            <a href="products.php?cat=tiles" class="btn btn-outline-dark me-2">Tiles</a>
            <a href="products.php?cat=countertops" class="btn btn-outline-dark me-2">Countertops</a>
            <a href="products.php?cat=custom" class="btn btn-outline-dark">Custom</a>
        </div>
    </section>

    <!-- Footer same as index.php -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
