<?php include 'config.php'; $pdo = getDB(); $stmt = $pdo->query("SELECT * FROM products LIMIT 4"); $products = $stmt->fetchAll(); ?>
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Granite Elegance</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="gallery.php">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero d-flex align-items-center justify-content-center text-center">
        <div><h1 class="display-4">Elevate Your Space with Timeless Stone</h1><p class="lead">Explore our granite collection.</p><a href="products.php" class="btn btn-light btn-lg">Shop Now</a></div>
    </section>

    <section class="container py-5">
        <h2 class="text-center mb-5">Featured Products</h2>
        <div class="row">
            <?php foreach ($products as $prod): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="images/<?php echo htmlspecialchars($prod['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($prod['name']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($prod['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars(substr($prod['description'], 0, 100)); ?>...</p>
                        <p class="fw-bold">$<?php echo number_format($prod['price'], 2); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="container-fluid py-5 bg-light">
        <h2 class="text-center mb-5">Client Testimonials</h2>
        <div class="row justify-content-center">
            <?php $stmt = $pdo->query("SELECT * FROM testimonials LIMIT 3"); foreach ($stmt->fetchAll() as $test): ?>
            <div class="col-md-4 mb-4">
                <blockquote class="blockquote text-center">
                    <p><?php echo htmlspecialchars($test['text']); ?></p>
                    <footer class="blockquote-footer"><?php echo htmlspecialchars($test['name']); ?></footer>
                </blockquote>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer class="bg-dark text-white py-4 text-center">
        <p>&copy; 2025 Granite Elegance. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
