
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Marcellus:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="CSS\style.css">

</head>

<body>

<h1 id="Checkout-title">Checkout</h1>

<hr>

<div class="cart-items">
    <h2>Your Cart</h2>

<?php

$total = 0;

if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $id => $item){
        $total += $item['price'] * $item['qty'];

?>

<div class="cart-card">
    <img src="Images/<?php echo $item['product_images']; ?>" class="cart-img">
    <div class="cart-info">
        <h3><?php echo $item['title']; ?></h3>
    <p>Price: Aq                                <?php echo $item['price']; ?> SAR</p>

        <p>Quantity: <?php echo $item['qty']; ?> </p>

        <p>Total: <?php echo $item['price'] * $item['qty']; ?> SAR</p>
    </div>
</div>

<?php
    }
?>

<h2 id="h2-total">
    Total: <?php echo $total; ?> SAR
</h2>

<?php
}else{
    echo "<p>Your cart is empty.</p>";
}
?>


<form action="process.php" method="POST" class="checkout-form" id="checkoutForm">

<h3>Contact</h3>
<label>Email </label> <input type="email" name="email" id="email" placeholder="Enter your email">
<span id="errorEmail"></span>

<br>

<label>
<input type="checkbox">
Email me with news and offers
</label>

<h3>Delivery</h3>

<label>Country </label>
<select name="country" id="country">
    <option value="">Select Country</option>
    <option value="Saudi Arabia">Saudi Arabia</option>
</select>
<span id="errorCountry"></span>

<label>City </label>
<select name="city" id="city">
    <option value="">Select City</option>
    <option value="Riyadh">Riyadh</option>
    <option value="Jeddah">Jeddah</option>
    <option value="Dammam">Dammam</option>
    <option value="Khobar">Khobar</option>
</select>
<span id="errorCity"></span>

<br>

<label>First name </label><input type="text" name="first_name" id="first_name" placeholder="First name">
<span id="errorFirstName"></span>

<label>Last name </label><input type="text" name="last_name" id="last_name" placeholder="Last name">
<span id="errorLastName"></span>

<br>

<label>Address </label><input type="text" name="address" id="address" placeholder="Address">
<span id="errorAddress"></span>

<br>

<label>Phone </label><input type="text" name="phone" id="phone" placeholder="Phone">
<span id="errorPhone"></span>

<h3>Shipping method</h3>

<div class="Checkout-shippimgBG">
<p>
Global Expedited: 1-6 Days Processing: 2-3 Weeks Estimated Shipping
</p>
</div>

<hr>

<h3>Payment</h3>

<br>

<div class="Checkout-paymentBG">

<h4>Visa Credit card</h4>

<label>Card number</label><input type="text" name="card_number" id="card_number" placeholder="Card number">
<span id="errorCardNumber"></span>

<br>

<label>Expiration </label><input type="text" name="exp_date" id="exp_date" placeholder="Expiration date mm/yy">
<span id="errorExpDate"></span>

<label>CVV </label><input type="text" name="cvv" id="cvv" placeholder="Security code cvv">
<span id="errorCVV"></span>

<br>

<label>Name</label><input type="text" name="card_name" id="card_name" placeholder="Name on card">
<span id="errorCardName"></span>

</div>

<br>
<br>

<button type="submit" name="checkout">Checkout</button>

</form>

<script src="checkout.js"></script>

</body>
</html>
