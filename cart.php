<?php
session_start();

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}
include("Connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id     = (int)$_POST['id'];
  $action = $_POST['action'] ?? '';

  switch ($action) {
    case 'add':
      $stmt = $pdo->prepare("SELECT title, price, product_images, quantity FROM products WHERE id = ?");
      $stmt->execute([$id]);
      $product = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($product) {
        $stock = (int)$product['quantity'];
        if (isset($_SESSION['cart'][$id])) {
          if ($_SESSION['cart'][$id]['qty'] < $stock) {
            $_SESSION['cart'][$id]['qty']++;
          } else {
            $_SESSION['stock_msg'][$id] = "Item is out of stock";
          }
        } else {
          if ($stock > 0) {
            $_SESSION['cart'][$id] = [
              'title'          => $product['title'],
              'price'          => $product['price'],
              'qty'            => 1,
              'product_images' => $product['product_images']
            ];
          } else {
            $_SESSION['stock_msg'][$id] = "Item is out of stock";
          }
        }
      }
      break;

    case 'increase':
      if (isset($_SESSION['cart'][$id])) {
        $stmt = $pdo->prepare("SELECT quantity FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $row   = $stmt->fetch(PDO::FETCH_ASSOC);
        $stock = $row ? (int)$row['quantity'] : 0;

        if ($_SESSION['cart'][$id]['qty'] < $stock) {
          $_SESSION['cart'][$id]['qty']++;
        } else {
          $_SESSION['stock_msg'][$id] = "Item is out of stock";
        }
      }
      break;

    case 'decrease':
      if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty']--;
        if ($_SESSION['cart'][$id]['qty'] <= 0) {
          unset($_SESSION['cart'][$id]);
          unset($_SESSION['stock_msg'][$id]);
        }
      }
      break;

    case 'delete':
      unset($_SESSION['cart'][$id]);
      unset($_SESSION['stock_msg'][$id]);
      break;

    case 'clear':
      $_SESSION['cart']      = [];
      $_SESSION['stock_msg'] = [];
      break;
  }
  header("Location: cart.php");
  exit();
}
$subtotal   = 0;
$totalItems = 0;
foreach ($_SESSION['cart'] as $item) {
  $subtotal   += $item['price'] * $item['qty'];
  $totalItems += $item['qty'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shopping Cart</title>
  <link rel="stylesheet" href="CSS/style.css">
</head>

<body>

<?php require_once 'header.php'; ?>

<img src="Images/plant.png" class="corner-right">
<div class="sh_container">

  <h1 class="title">Shopping Cart</h1>
  <br><br>

  <?php if (!empty($_SESSION['cart'])): ?>

  <div class="top-actions">
    <form method="POST" action="cart.php">
      <input type="hidden" name="action" value="clear">
      <input type="hidden" name="id" value="0">
      <button onclick="return confirmClearCart()" class="btn-clear-all">Delete All Items</button>
    </form>
  </div>

  <div class="cart-header">
    <span>Product</span>
    <span>Price</span>
    <span>Quantity</span>
    <span>Total</span>
    <span>Delete</span>
  </div>

  <?php foreach ($_SESSION['cart'] as $id => $item): ?>
  <div class="cart-item">

    <div class="product-info">
      <img src="Images/<?php echo htmlspecialchars($item['product_images']); ?>">
      <span><?php echo htmlspecialchars($item['title']); ?></span>
    </div>
<div><?php echo number_format($item['price'], 2); ?> SAR</div>

    <div>
      <form method="POST" action="cart.php" class="inline-form">
        <input type="hidden" name="action" value="decrease">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button type="submit" class="quantity-button">-</button>
      </form>

      <span class="quantity"><?php echo $item['qty']; ?></span>

      <form method="POST" action="cart.php" class="inline-form">
        <input type="hidden" name="action" value="increase">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button type="submit" class="quantity-button">+</button>
      </form>

      <?php if (isset($_SESSION['stock_msg'][$id])): ?>
      <span class="outstock-msg">
        <?php echo $_SESSION['stock_msg'][$id]; ?>
      </span>
      <?php unset($_SESSION['stock_msg'][$id]); ?>
      <?php endif; ?>
    </div>

    <div><?php echo number_format($item['price'] * $item['qty'], 2); ?> SAR</div>

    <div>
      <form method="POST" action="cart.php" class="inline-form">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button onclick="return confirmDeleteItem()" class="btn-delete-item">X</button>
      </form>
    </div>

  </div>
  <?php endforeach; ?>

  <div class="subtotal">
    <span>Subtotal (Duties, Tax &amp; Customs Included)</span>
    <span><?php echo number_format($subtotal, 2); ?> SAR</span>
  </div>

  <div class="center">
    <a href="checkout.php">
    <button type="button" class="button">Go to Checkout</button>
    </a>
  </div>

  <?php else: ?>
  <p class="empty-cart-msg">Your cart is empty.</p>
  <?php endif; ?>

<a href="home.php" class="back">&lt; Back</a>
</div>
</body>

<footer id="short_footer"></footer>
<script src="JS/scripts.js"></script>
</html>