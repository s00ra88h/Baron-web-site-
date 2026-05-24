<?php

$cart_count = 0;
$cart_total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['qty'];
        $cart_total += $item['price'] * $item['qty'];
    }
}
?>
 

<header>
    <div id="header_left">
        <a href="profile.php" class="header_button" id="profile_btn">
            <img src="Images/profile.png" alt="Profile">
        </a>
        <a href="login.php" class="header_button" id="admin_login_btn">
            <img src="Images/Admin.png" alt="Admin login">
        </a>
    </div>
 
    <form id="search_wrapper" method="GET" action="search.php"
        onsubmit="if(!this.q.value.trim()){
              document.getElementById('empty_search_msg').style.display='block';
              return false;
          }">
        <input id="header_search_bar" type="text" name="q"
               placeholder="Search an item..."
               value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>"
               oninput="document.getElementById('empty_search_msg').style.display='none'">

        <button class="header_button" id="search_btn" type="submit">
            <img src="Images/search.png" alt="Search">
        </button>
    </form>
        <span id="empty_search_msg" class= "error-message" style="display:none;">
        Please type something to search.
        </span>
 
    <a href="cart.php" class="header_button" id="cart_btn">
        <span id="items_number"><?php echo $cart_count; ?></span>
        <img src="Images/cart.png" alt="Cart">
        <span id="cart_total"><?php echo number_format($cart_total, 0); ?> SR</span>
    </a>
</header>