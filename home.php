<?php
session_start();
require_once "Connect.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="CSS\style.css">
    </head>

<?php require_once 'header.php'; ?>
    
       <body>
       <main>
       <section id="home_image"></section> 
        <hr><br>

    <h2 class="big_h2">Just Arrived</h2>
    <div id="just_arrived_scroll">
 
        <?php
        // Fetch the 4 most recently added products
        $stmt = $pdo->prepare("
            SELECT id, title, price, quantity, product_images
            FROM products
            ORDER BY id DESC
            LIMIT 4
        ");
        $stmt->execute();
        $latest_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
        if ($latest_products): 
            foreach ($latest_products as $row):
        ?>
 
        <div class="product">
            <a href="productdetails.php?id=<?php echo $row['id']; ?>" class="product">
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


    <h2 class="big_h2">What Are You Looking For?</h2>
    <div id="categories_scroll">
 
        <?php
        $stmt = $pdo->prepare("
            SELECT   p.category,
                     p.product_images
            FROM     products p
            INNER JOIN (
                SELECT   category, MIN(id) AS oldest_id
                FROM     products
                WHERE    category IS NOT NULL AND category != ''
                GROUP BY category
            ) sub ON p.id = sub.oldest_id
            ORDER BY p.category ASC
        ");
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
        if ($categories):
            foreach ($categories as $cat):
                $cat_image = explode(',', $cat['product_images'])[0];
        ?>
 
        <a href="category_products.php?category=<?php echo urlencode($cat['category']); ?>"
           class="category"
           style="background-image: url('<?php echo htmlspecialchars("Images/".$cat_image); ?>');">
            <h6 class="category_name"><?php echo htmlspecialchars($cat['category']); ?></h6>
        </a>
 
        <?php
            endforeach;
        else:
        ?>
            <p class="no_items">No categories found.</p>
        <?php endif; ?>
 
    </div>

       </main>

       <div id="space">
        <img id="plant_image" src="Images\plant.png">
       </div>
    </body>
   
    <footer>
        <div>
        <h1>Contact us</h1>
        <ul>
            <li><a href="https://maps.app.goo.gl/dDiha9yqL9nmXssx7"class="contact_link">Location- Khobar</a></li>
            <li><a href="mailto:Baron@gmail.com" class="contact_link">Email: Contact@Baron.com </a></li>
        </ul>
        </div>

        <figure id="footer_figure">
        <img id="footer_logo" src="Images\logo.png" alt ="the store logo"> 
        <figcaption>&copy; 2026 Baron</figcaption>  
        </figure>

    </footer>
</html>