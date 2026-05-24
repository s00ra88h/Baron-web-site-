<?php
session_start();
require_once 'Connect.php';
 
$q = trim($_GET['q'] ?? '');
if ($q === '') {
    header('Location: home.php');
    exit;
}
 
$stmt = $pdo->prepare("
    SELECT id, title, price, quantity, product_images, category
    FROM   products
    WHERE  title    LIKE :q
       OR  category LIKE :q
    ORDER  BY id DESC
");
$stmt->execute([':q' => '%'.$q.'%']);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search: <?php echo htmlspecialchars($q); ?> — Baron</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
 
<?php require_once 'header.php'; ?>
 
<body>
<main>
 
    <br><hr><br>
 
    <div class="top-bar">
        <h2 class="big_h2">
            <?php if ($results): ?>
                Results for "<?php echo htmlspecialchars($q); ?>"
            <?php else: ?>
                No results for "<?php echo htmlspecialchars($q); ?>"
            <?php endif; ?>
        </h2>
        <a class="back" href="home.php">&lt; Back</a>
    </div>
 
    <div id="products_scroll">
 
        <?php if ($results): ?>
 
            <?php foreach ($results as $row): ?>
 
                <div class="product_card">
                    <a href="productdetails.php?id=<?php echo $row['id']; ?>" class="product">
                        <img class="product_image"
                             src="Images/<?php echo htmlspecialchars($row['product_images']); ?>"
                             alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <h6 class="product_name"><?php echo htmlspecialchars($row['title']); ?></h6>
                        <h6 class="product_price"><?php echo number_format($row['price'], 0); ?> SR</h6>
                    </a>
 
                    <form method="POST" action="cart.php" class="add_to_cart_form">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="id"     value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="name"   value="<?php echo htmlspecialchars($row['title']); ?>">
                        <input type="hidden" name="price"  value="<?php echo $row['price']; ?>">
                        <input type="hidden" name="img"    value="<?php echo htmlspecialchars($row['product_images']); ?>">
                        <div class="cart_controls">
                            <input type="number" name="quantity" value="1" min="1"
                                   max="<?php echo $row['quantity']; ?>"
                                   class="quantity_input">
                            <button type="submit" class="add_to_cart_btn">Add to Cart</button>
                        </div>
                    </form>
                </div>
 
            <?php endforeach; ?>
 
        <?php else: ?>
 
            <div class="no_results_msg">
                <p>We couldn't find anything matching <strong>"<?php echo htmlspecialchars($q); ?>"</strong>.</p>
                <p>Try a different keyword or <a href="home.php">browse all categories</a>.</p>
            </div>
 
        <?php endif; ?>
 
    </div>
 
    <div id="space">
        <img id="plant_image" src="Images/plant.png" alt="">
    </div>
 
</main>
</body>
 
<footer id="short_footer"></footer>
 
</html>