<?php
require_once "Connect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Detail</title>
    <link href="https://fonts.googleapis.com/css2?family=Marcellus:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS\style.css">
</head>

<?php require_once 'header.php'; ?>

<body class="Details-Checkout">
    <img src="images/plant.png" class="corner-right">
<div >
    <?php
    $id=$_GET['id'];
    if (isset($_GET['id'])){
        $sql="SELECT * FROM products WHERE id='$id' ";
        $result = $pdo->query($sql);
        $row = $result->fetch();
    }
    ?>

    <a href="home.php" class="DetailsPage-back-button">BACK</a>
   

    <div class="DetailsPage-ProductInfo">
       <img src="images/<?php echo $row['product_images']; ?>">
        <h1><?php echo $row['title']  ?></h1>
        <h2><?php echo $row['price']?> SAR</h2>

        <div>
            <h3>DESCRIPTION</h3>
            <p>
                <?php echo $row['description'] ?>           
            </p>
        </div>

        <div>
            <p><strong>CONDITION:</strong> <?php echo $row['product_condition'] ?></p>
            <p><strong>QUANTITY:</strong> <?php echo $row['quantity'] ?></p>
        </div>
 
    <form method="POST" action="addcart.php">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <input type="hidden" name="name" value="<?php echo $row['title']; ?>">
        <input type="hidden" name="price" value="<?php echo $row['price']; ?>"> 
        <input type="number" name="quantity" value="1">
        <input type="hidden" name="img" value="<?php echo $row['product_images']; ?>">
        <button type="submit">ADD TO CART </button>
    </form>    

</div>

</div>
<footer id="short_footer"></footer>
</body>
</html>
