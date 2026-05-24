<?php
session_start();

$hasPastPurchase = isset($_COOKIE['pastPurchase']);

if ($hasPastPurchase) {
    $values    = json_decode($_COOKIE['pastPurchase'], true);
    $email     = $values[0] ?? '';
    $country   = $values[1] ?? '';
    $city      = $values[2] ?? '';
    $firstName = $values[3] ?? '';
    $lastName  = $values[4] ?? '';
    $address   = $values[5] ?? '';
    $phone     = $values[6] ?? '';
    $itemIDs   = json_decode($values[7] ?? '[]', true);
    $itemQtys  = json_decode($values[8] ?? '[]', true);

    include("Connect.php");
}

if (isset($_POST['logout'])) {
    setcookie('pastPurchase', '', time() - 3600, '/');
    setcookie('pastPurchase', '', time() - 3600, '/', '');
    unset($_COOKIE['pastPurchase']);
    session_unset();
    session_destroy();
    header('Location: home.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Customer Profile</title>
  <link rel="stylesheet" href="CSS/style.css"/>
</head>

<header>
  <a href="profile.php" class="header_button" id="profile_btn">
    <img src="Images/profile.png" alt="Profile">
  </a>
  <div id="search_wrapper">
    <input id="header_search_bar" type="text" name="search" placeholder="Search an item...">
    <button class="header_button" id="search_btn">
      <img src="Images/search.png" alt="Search">
    </button>
  </div>
  <a href="cart.php" class="header_button" id="cart_btn">
    <span id="items_number">0</span>
    <img src="Images/cart.png" alt="Cart">
    <span id="cart_total">0 SR</span>
  </a>
</header>

<body>
<img src="Images/plant.png" class="corner-right">
<div class="page">

  <!-- Back button moved here, above everything, makes more sense -->
  <div class="top-bar">
    <a class="back-btn" href="home.php">&lt; Back to Shop</a>
  </div>

  <div class="profile-header">
    <div class="avatar" id="avatar">
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4
                 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6
                 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
      </svg>
    </div>
    <div class="profile-info">
      <h2><?php echo $hasPastPurchase ? htmlspecialchars($firstName . ' ' . $lastName) : 'Guest'; ?></h2>
      <p>Customer</p>
    </div>
  </div>

  <?php if ($hasPastPurchase): ?>

  <div class="field-group">
    <label>Email</label>
    <input type="email" value="<?php echo htmlspecialchars($email); ?>" readonly/>
  </div>

  <div class="field-group">
    <label>Phone</label>
    <input type="tel" value="<?php echo htmlspecialchars($phone); ?>" readonly/>
  </div>

  <div class="field-group">
    <label>Address</label>
    <input type="text" value="<?php echo htmlspecialchars($address . ', ' . $city . ', ' . $country); ?>" readonly/>
  </div>

  <div class="orders-section">
    <div class="orders-header" id="orders-header">
      <span>View previous orders</span>
      <span class="arrow" id="orders-arrow">&#8963;</span>
    </div>

    <div id="orders-body">
      <?php if (!empty($itemIDs)): ?>
      <div class="order-row" data-id="last">
        <span>Last Order (<?php echo count($itemIDs); ?> items)</span>
        <span class="chev">&gt;</span>
      </div>
      <div class="order-expanded" id="exp-last">
        <?php
        $total = 0;
        foreach ($itemIDs as $i => $pid):
            $stmt = $pdo->prepare("SELECT title, price, product_images FROM products WHERE id = ?");
            $stmt->execute([$pid]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$product) continue;
            $qty      = $itemQtys[$i] ?? 1;
            $subtotal = $product['price'] * $qty;
            $total   += $subtotal;
        ?>
        <div class="order-item">
          <div class="item-img">
            <img src="uploads/<?php echo htmlspecialchars($product['product_images']); ?>" width="40">
          </div>
          <span class="item-name"><?php echo htmlspecialchars($product['title']); ?></span>
          <span class="item-qty">x<?php echo $qty; ?></span>
          <span class="item-price"><?php echo number_format($subtotal, 2); ?> SAR</span>
        </div>
        <?php endforeach; ?>
        <div class="order-total">
          <strong>Total: <?php echo number_format($total, 2); ?> SAR</strong>
        </div>
      </div>
      <?php else: ?>
        <p class="empty-cart-msg">No past orders found.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Logout button -->
  <form method="POST" action="profile.php" style="margin-top: 2rem;">
    <button type="submit" name="logout" class="logout-btn">Log Out</button>
  </form>

  <?php else: ?>

  <div class="no-data-message">
    <p>You don't have any profile information yet.</p>
    <p>Complete a checkout and your details will appear here.</p>
    <a href="home.php" class="button">Start Shopping</a>
  </div>

  <?php endif; ?>

</div>
</body>

<footer id="short_footer"></footer>
<script src="profile.js" defer></script>
</html>
