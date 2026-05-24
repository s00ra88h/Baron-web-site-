<?php

session_start();

$pastPurchaseCoockie = $_COOKIE['pastPurchase'];

$values = json_decode($pastPurchaseCoockie, true);

$email = $values[0];
$country = $values[1];
$city = $values[2];
$firstName = $values[3];
$lastName = $values[4];
$address = $values[5];
$phone = $values[6];
$itemIDs = $values[7];
$itemIDs2 = json_decode($itemIDs, true);
$itemQuantity = $values[8];
$itemQuantity2 = json_decode($itemQuantity, true);

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">
<title>Completed</title>
<link rel="stylesheet" href="CSS\style.css">

</head>

<body>

<div class="OrderCompleted-container">
<div class="OrderCompleted-card">

<h1>Order Completed</h1>


<div class="OrderCompleted-info">
<span>Email</span>
<p><?php echo $email; ?></p>
</div>


<div class="OrderCompleted-info">
<span>Country</span>
<p><?php echo $country; ?></p>
</div>


<div class="OrderCompleted-info">
<span>City</span>
<p><?php echo $city; ?></p>
</div>


<div class="OrderCompleted-info">
<span>First Name</span>
<p><?php echo $firstName; ?></p>
</div>


<div class="OrderCompleted-info">
<span>Last Name</span>
<p><?php echo $lastName; ?></p>
</div>


<div class="OrderCompleted-info">
<span>Address</span>
<p><?php echo $address; ?></p>
</div>


<div class="OrderCompleted-info">
<span>Phone</span>
<p><?php echo $phone; ?></p>
</div>

<?php

$total = 0;
foreach( $_SESSION['cart']as $id => $item){
$itemTotal = $item['price'] * $item['qty'];
$total += $itemTotal;

?>

<div class="cart-card">
   <img src="Images/<?php echo $item['product_images']; ?>" class="cart-img">
   <div class="cart-info">
    <h3><?php echo $item['title']; ?></h3>
    <p>Price: <?php echo $item['price']; ?> SAR</p>
    <p> Quantity:<?php echo $item['qty']; ?></p>
    <p>Total:<?php echo $itemTotal; ?> SAR </p>
   </div>
</div>

<?php
}
?>


<h2>Order Total:<?php echo $total; ?> SAR</h2>
<a href="home.php" class="OrderCompleted-button">Back To Home</a>

</div>
</div>

<script>
alert("Order placed successfully");
</script> 

<?php
unset($_SESSION['cart']);
?>

</body>

</html>
