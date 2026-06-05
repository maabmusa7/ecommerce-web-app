<?php
session_start();//start thr session
include('db.php');//connect to the database
//for security , kicks out anyone who is not logged in
if(!isset($_SESSION['username'])){
  header("location: login.php");
  exit();
}

$id= $_GET['id'];//WE USED GET BECAUSE THE VALUES ARE PASSED THROUGH A URL
$fetch=mysqli_prepare($conn,"SELECT * FROM products WHERE id=?");
mysqli_stmt_bind_param($fetch,"i", $id);
mysqli_stmt_execute($fetch);

$result = mysqli_stmt_get_result($fetch);
$product = mysqli_fetch_assoc($result);

if(!$product){
  header("Location: products.php");
  exit();
}

$success="";
$error= "";

if(isset($_POST['update_product'])){
$name= trim($_POST['product_name']);
$description= trim($_POST['description']);
$price= $_POST['price'];
$stock= $_POST['stock'];
$category_id= $_POST['category_id'];

if(empty($name)){
  $error="Product name is required!";
}elseif(empty($price)){
  $error="Price name is required!";
}elseif(!is_numeric($price) || $price < 0){
  $error="Prlease enter a valid price.";
}
elseif(empty($stock)){
  $error="Stock name is required!";
}
elseif(!is_numeric($price) || $price < 0){
  $error="Please enter a valid stock number.";
}
elseif(empty($category_id)){
  $error="Please select a category.";
}else{
  //query to handle updating the database

  $image_name= $product['image'];
  if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
    $image_name= time(). "_" .basename($_FILES['image']['name']);
    $upload_path= "uploads/" . $image_name;
    move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);
  }
  $stmt = mysqli_prepare($conn, "UPDATE products SET
  product_name=?,
  description=?,
  price=?,
  stock=?,
  category_id=?,
  image=?
  WHERE id=?");


mysqli_stmt_bind_param($stmt, "ssdiiss", $name, $description, $price, $stock, $category_id, $image_name, $id);

if(mysqli_stmt_execute($stmt)){
  $success= "Product updated successfully!";
}else{
  $error = "Database error:". mysqli_stmt_error($stmt);
}
}
}
$cat_query= mysqli_query($conn, "SELECT * FROM categories");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product - Taja Beauty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css?v=3">
</head>
<body class="bg-light">
  <?php include('includes/navbar.php');?>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2 class="mb-4"> Edit Product</h2>
        <?php if($success): ?>
        <div class="alert alert-success"> <?php echo htmlspecialchars($success);?> </div>
        <?php endif; ?>

        <?php if($error): ?>
        <div class="alert alert-danger"> <?php echo htmlspecialchars($error);?> </div>
        <?php endif; ?>

        <form action="edit_product.php?id=<?php echo $id ?>" method="POST" class="bg-white p-4 shadow-sm rounded" enctype="multipart/form-data">

        <div class="mb-3">
          <label class="form-label">Product Name</label>
          <input type="text" name="product_name" class="form-control" required 
          value="<?php echo htmlspecialchars(isset($_POST['product_name']) ? $_POST['product_name'] :$product['product_name']); ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars(isset($_POST['description']) ? $_POST['description'] :$product['description']); ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Price (₺)</label>
          <input type="number" name="price" class="form-control" step="0.01" min="0" required 
          value="<?php echo htmlspecialchars(isset($_POST['price']) ? $_POST['price'] :$product['price']); ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Stock</label>
          <input type="number" name="stock" class="form-control" min="0" required 
          value="<?php echo htmlspecialchars(isset($_POST['stock']) ? $_POST['stock'] :$product['stock']); ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Category</label>
          <select name="category_id" class="form-select">
            <option value="">Select a Category</option>
              <?php while($cat = mysqli_fetch_assoc($cat_query)): ?>
              <option value="<?php echo $cat['id']; ?>"
                <?php echo (isset($_POST['category_id']) ? $_POST['category_id'] :$product['category_id']) == $cat['id'] ?'selected':''; ?>>
                <?php echo htmlspecialchars($cat['name']); ?>
              </option>
              <?php endwhile; ?>
          </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Current Image</label></div><br>
            <?php if($product['image']):?>
              <img src="uploads/<?php echo $product['image']; ?> " width="80" height="80" style="object-fit:cover;" class="mb-2"><br>
            <?php else: ?>
              <p class="text-muted">No image uploaded</p>
            <?php endif; ?>
            <label class="form-label">Upload New Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="text-muted">Leave blank to keep current image</small>
        </div>
        <button type="submit" name="update_product" class="btn btn-warning w-100">
          Update Product
        </button>
        </form>
        <div class="text-center mt-3 mb-3">
    <a href="products.php" class="btn-outline-custom">← Back to Products</a>
</div>
     </div>
    </div>
  </div>
  <?php include('includes/footer.php'); ?>
  <?php include('includes/sidebar_script.php'); ?>
</body>
</html>

