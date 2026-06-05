<?php

error_reporting(E_ALL); ini_set('display_errors', 1); 
session_start();
include('db.php');

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

// Fetch bestsellers (highest stock = most popular for demo)
$bestsellers_query = mysqli_query($conn, "SELECT products.*, categories.name AS category_name 
    FROM products 
    LEFT JOIN categories ON products.category_id = categories.id
    ORDER BY stock DESC LIMIT 3");
$bestsellers = mysqli_fetch_all($bestsellers_query, MYSQLI_ASSOC);

// Fetch new arrivals (latest added)
$new_arrivals_query = mysqli_query($conn, "SELECT products.*, categories.name AS category_name 
    FROM products 
    LEFT JOIN categories ON products.category_id = categories.id
    ORDER BY id DESC LIMIT 4");
$new_arrivals = mysqli_fetch_all($new_arrivals_query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taja Beauty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css?v=3>v=3">
</head>
<body>
    <?php include('includes/navbar.php'); ?>
    
    <!-- Hero -->
   <section class="hero">
    <div class="hero-bg"></div>
    <img src="uploads/hero.jpg" alt="Taja Beauty" class="hero-image">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <span class="hero-eyebrow">New Collection 2026</span>
        <h1>Your Beauty,<br><em>Elevated.</em></h1>
        <p>Premium beauty essentials curated just for you.</p>
        <a href="products.php" class="btn-primary-custom">Shop Now</a>
    </div>
</section>

    <!-- Bestsellers -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-baseline mb-4">
                <div>
                    <span class="section-eyebrow">Our top picks</span>
                    <h2 class="section-title">Bestsellers</h2>
                </div>
                <a href="products.php" class="view-all-link">View All</a>
            </div>

            <div class="row g-3">
                <?php foreach($bestsellers as $product): ?>
                <div class="col-md-4 col-6">
                    <div class="product-card">
                        <div style="position:relative;">
                            <?php if($product['image']): ?>
                                <img src="uploads/<?php echo $product['image']; ?>" 
                                     alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                            <?php else: ?>
                                <div class="no-image-placeholder">No Image</div>
                            <?php endif; ?>
                            <span class="bestseller-badge">Bestseller</span>
                        </div>
                        <div class="product-card-body">
                            <div class="product-card-title"><?php echo htmlspecialchars($product['product_name']); ?></div>
                            <div class="product-card-price">₺<?php echo number_format($product['price'], 2); ?></div>
                            <form action="add_to_cart.php" method="POST" class="mt-2">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="btn-add-cart">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- New Arrivals -->
    <section class="py-5" style="background: var(--blush);">
        <div class="container">
            <div class="d-flex justify-content-between align-items-baseline mb-4">
                <div>
                    <span class="section-eyebrow">Just arrived</span>
                    <h2 class="section-title">New Arrivals</h2>
                </div>
                <a href="products.php" class="view-all-link">View All</a>
            </div>

            <div class="row g-3">
                <?php foreach($new_arrivals as $product): ?>
                <div class="col-md-4 col-6">
                    <div class="product-card">
                        <?php if($product['image']): ?>
                            <img src="uploads/<?php echo $product['image']; ?>" 
                                 alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                        <?php else: ?>
                            <div class="no-image-placeholder">No Image</div>
                        <?php endif; ?>
                        <div class="product-card-body">
                            <div class="product-card-title"><?php echo htmlspecialchars($product['product_name']); ?></div>
                            <div class="product-card-price">₺<?php echo number_format($product['price'], 2); ?></div>
                            <form action="add_to_cart.php" method="POST" class="mt-2">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="btn-add-cart">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4 justify-content-between align-items-start">
                <div class="col-md-4">
                    <div class="footer-brand">Taja Beauty</div>
                    <p class="footer-tagline">Your beauty, elevated.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="footer-label">Follow Us</div>
                    <div class="footer-social">
                        <a href="https://instagram.com/tajabeauty" target="_blank" class="social-link">
                            Instagram
                        </a>
                        <a href="https://tiktok.com/@tajabeauty" target="_blank" class="social-link">
                            TikTok
                        </a>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="footer-label">Contact Us</div>
                    <a href="mailto:hello@tajabeauty.com" class="social-link">hello@tajabeauty.com</a>
                </div>
            </div>
            <div class="footer-bottom">
                © 2026 Taja Beauty. All rights reserved.
            </div>
        </div>
    </footer>

    <?php include('includes/sidebar_script.php'); ?>
</body>
</html>