<?php

session_start();

$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$img = $_POST['img'];
$qty = $_POST['quantity'];


require_once('Connection.php');


$stmt = $pdo->prepare(
"SELECT quantity FROM products WHERE id = ?"
);

$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$stock = $row['quantity'];



if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}



if (isset($_SESSION['cart'][$id])) {
    if (
        ($_SESSION['cart'][$id]['qty'] + $qty)
        <= $stock
    ) {
        $_SESSION['cart'][$id]['qty'] += $qty;

    } else {
        echo "<script>
      alert('Quantity exceeds available stock');
        window.location='ProductDetails.php?id=$id';
        </script>";
        exit();

    }

} else {
    if ($qty <= $stock) {
        $_SESSION['cart'][$id] = [
            'name'  => $name,
            'price' => $price,
            'qty'   => $qty,
            'img'   => $img
        ];

    } else {
        echo "<script> alert('Product out of stock');
        window.location='ProductDetails.php?id=$id';
        </script>";
        exit();

    }

}

echo "<script> alert('Item added to cart');
window.location='cart.php';
</script>";

?>
