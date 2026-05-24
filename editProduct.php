
<link rel="stylesheet" href="CSS/style.css">
<?php

session_start();

if (!isset($_SESSION['admin_name'])) {
    if (isset($_COOKIE['admin_name'])) {
        $_SESSION['admin_name'] = $_COOKIE['admin_name'];
    } else {
        header("Location: login.php");
        exit();
    }
}

require_once("Connect.php");


$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);

$data = $stmt->fetch();

?>

<body>

<img src="Images/logo.png" class="corner-img">
<img src="Images/plant.png" class="corner-right">

<h2 class="center-title" style="text-align:center;">Edit Product</h2>

<img src="images/<?php echo $data['product_images']; ?>" width="120">
<form method="POST" enctype="multipart/form-data" onsubmit="return validateEditForm()" class="product-form">

    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

    <label>Title</label>
    <input type="text" name="title" id="title" value="<?php echo $data['title']; ?>">

    <label>Price</label>
    <input type="number" name="price" id="price" value="<?php echo $data['price']; ?>">

    <label>Quantity</label>
    <input type="number" name="quantity" id="quantity" value="<?php echo $data['quantity']; ?>">

    <label>Image</label>
<input type="file" name="image" id="image" accept="image/*">

    <label>Condition</label>
    <select name="product_condition">
        <option value="new" <?php if($data['product_condition']=='new') echo 'selected'; ?>>New</option>
        <option value="used" <?php if($data['product_condition']=='used') echo 'selected'; ?>>Used</option>
    </select>

    <label>Status</label>
    <select name="status">
        <option value="active" <?php if($data['status']=='active') echo 'selected'; ?>>Active</option>
        <option value="inactive" <?php if($data['status']=='inactive') echo 'selected'; ?>>Inactive</option>
    </select>

    <label>Description</label>
    <textarea name="description" id="description"><?php echo $data['description']; ?></textarea>

    <button type="submit" name="update">Save Changes</button>

    <a href="ManagingProducts.php">Cancel</a>

</form>

</body>

<?php
if (isset($_POST['update'])) {

    $imageName = $data['product_images'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

        $imageName = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $imageName);
    }

    $stmt = $pdo->prepare("
        UPDATE products 
        SET title = ?, price = ?, quantity = ?, product_condition = ?, status = ?, description = ?, product_images = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $_POST['title'],
        $_POST['price'],
        $_POST['quantity'],
        $_POST['product_condition'],
        $_POST['status'],
        $_POST['description'],
        $imageName,
        $_POST['id']
    ]);

    header("Location: ManagingProducts.php");
    exit();
}
?>

<script>
function validateEditForm() {

    let title = document.getElementById("title").value.trim();
    let price = document.getElementById("price").value;
    let quantity = document.getElementById("quantity").value;
    let image = document.getElementById("image").files[0];

    if (title === "") {
        alert("Title is required");
        return false;
    }

    if (price === "" || price <= 0) {
        alert("Price must be greater than 0");
        return false;
    }

    if (quantity === "" || quantity < 0) {
        alert("Quantity cannot be negative");
        return false;
    }

    if (image) {

        let allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/gif"];

        if (!allowedTypes.includes(image.type)) {
            alert("Only JPG, PNG, GIF images are allowed");
            return false;
        }

        if (image.size > 2 * 1024 * 1024) {
            alert("Image size must be less than 2MB");
            return false;
        }
    }

    return true;
}
</script>