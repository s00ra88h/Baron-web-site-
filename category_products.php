
<?php 
session_start();
require_once 'Connect.php'; 

$category = trim($_GET['category'] ?? '');
 
if ($category === '') {
    header('Location: home.php');
    exit;
    }

$img_stmt = $pdo->prepare("
    SELECT product_images
    FROM   products
    WHERE  category = :category
    ORDER  BY id ASC
    LIMIT  1
");
$img_stmt->execute([':category' => $category]);
$img_row      = $img_stmt->fetch(PDO::FETCH_ASSOC);
$category_img = $img_row ? $img_row['product_images'] : '';
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="CSS\style.css">
    </head>
    
    
<?php require_once 'header.php'; ?>
    
    <body>
        <main>
        <section id="category_image"
            style="<?php if ($category_img): ?>
            background-image: url('<?php echo htmlspecialchars("Images/". $category_img); ?>');<?php endif; ?>">
        </section> 
        <br><hr><br>
        
          <div class="top-bar">
          <h2 class="big_h2"><?php echo htmlspecialchars($category); ?></h2>
          <a class="back" href="home.php">&lt; Back</a>
   </div>
        <div id="products_scroll">
        
        <?php
        $cat_stmt = $pdo->prepare("
            SELECT id, title, price, quantity, product_images
            FROM products 
            WHERE category = :category
            ORDER BY id DESC
        ");

        $cat_stmt->execute([':category' => $category]);
        $cat_products = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);
 
        if ($cat_products): 
            foreach ($cat_products as $row):
        ?>
        
        <div class="product">
        <a href="productdetails.php?id=<?php echo $row['id']; ?>"  class="product">
            <img class="product_image"
            src="<?php echo htmlspecialchars("Images/". $row['product_images']); ?>"
            alt="<?php echo htmlspecialchars($row['title']); ?>">

            <h6 class="product_name"><?php echo htmlspecialchars($row['title']); ?></h6>
            <h6 class="product_price"><?php echo number_format($row['price'], 0); ?> SR</h6>
        </a>
            <form method="POST" action="cart.php" class="add_to_cart_form">
               <input type="hidden" name="action"    value="add">
                <input type="hidden" name="id"        value="<?php echo $row['id']; ?>">
                <input type="hidden" name="name"      value="<?php echo htmlspecialchars($row['title']); ?>">
                <input type="hidden" name="price"     value="<?php echo $row['price']; ?>">
                <input type="hidden" name="img"       value="<?php echo htmlspecialchars($row['product_images']); ?>">
                <div class="cart_controls">
                    <input type="number" name="quantity" value="1" min="1"
                           max="<?php echo $row['quantity']; ?>"
                           class="quantity_input">
                    <button type="submit" class="add_to_cart_btn">Add to Cart</button>
                </div>
            </form>
        </div>

        <?php
            endforeach;
        else:
        ?>
            <p class="no_items">No products available yet.</p>
        <?php endif; ?>
   
        </div>

        <div id="space">
        <img id="plant_image" src="Images\plant.png">
       </div>

        </main>
    </body>

    <footer id="short_footer"></footer>
</html>