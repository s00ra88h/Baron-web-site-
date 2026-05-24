<?php

$email = $_POST['email'];
$country = $_POST['country'];
$city = $_POST['city'];
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$cardNumber = $_POST['card_number'];
$expDate = $_POST['exp_date'];
$cvv = $_POST['cvv'];
$cardName = $_POST['card_name'];


session_start();

require_once('Connect.php');

$count = count($_SESSION['cart']);
foreach($_SESSION['cart'] as $id => $item)
{
    $currentItemQuantity = $item['qty'];

}

$itemIDsArray = array();
$itemQuantityArray = array();


foreach ($_SESSION['cart'] as $id => $item)
{
    $itemIDsArray[] = $id;
}


foreach ($_SESSION['cart'] as $id => $item)
{
    $itemQuantityArray[] = $item['qty'];
}

foreach ($_SESSION['cart'] as $id => $item)
{
    $stmt = $pdo->prepare("SELECT quantity FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stock = $row['quantity'];
    $newQuantity = $stock - $item['qty'];
    $update = $pdo->prepare("UPDATE products SET quantity = ? WHERE id = ?"
    );
    $update->execute([$newQuantity, $id]);
}

$itemIDs = json_encode($itemIDsArray);
$itemQuantity = json_encode($itemQuantityArray);


$pastPurchase = array(
    $email,
    $country,
    $city,
    $firstName,
    $lastName,
    $address,
    $phone,
    $cardNumber,
    $expDate,
    $cvv,
    $cardName,
    $itemIDs,
    $itemQuantity

);

$pastPurchaseCookie = json_encode($pastPurchase);
setcookie('pastPurchase',$pastPurchaseCookie,time() + (86400 * 30));
?>

<?php
header('Location: Completed.php');
?> "Resolved merge conflicts &home/category products/header pages"
