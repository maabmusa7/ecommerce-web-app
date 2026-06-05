<?php

error_reporting(E_ALL); ini_set('display_errors', 1);
session_start();
include('db.php');//connect to the database
//for security 
if(!isset($_SESSION['username'])){
  header("location: login.php");
  exit();
}

$success="";
$error= "";

$category_query = mysqli_query($conn,"SELECT * FROM categories");

if(isset($_POST["add_product"])){
  $name= trim($_POST['product_name']);
  $description= trim($_POST['description']);
  $price= $_POST['price'];
  $stock = $_POST['stock'];
  $category_id = $_POST['category_id'];

  if(empty($name)){
    $error= "Product name is required!";
  }elseif(empty($price)){
    $error= "Price is required!";
  }elseif(!is_numeric($price) || $price<0){
    $error= "Please enter a valid price";
  }elseif(empty($stock)){
    $error= "Stock is required";
  }elseif(!is_numeric($stock) || $stock < 0){
    $error= "Please enter a valid stock number.";
  }elseif(empty($category_id)){
    $error= "Please select a category";
  }else{
    //all the above checkpoints have been passed
    //now the data is ready to be inserted into the database

    $image_name= NULL;

    if(isset($_FILES['image'])&& $_FILES['image']['error']==0){//0 means the file is uplouded without errors
    $ext = pathinfo ($_FILES['image']['name'], PATHINFO_EXTENSION); 
    $image_name= time() . "." . $ext;//unique time to distinguish images + filenames
    $upload_path= "uploads/" . $image_name;
    move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);//move the file from php storage to the uploads folder before it gets deleted
     }
    
    $stmt = mysqli_prepare($conn,"INSERT INTO products 
    (product_name, description, price, stock, category_id, image)
    VALUES (?, ?, ?, ?, ?, ?)");

    mysqli_stmt_bind_param($stmt,"ssdiis", $name, $description, $price, $stock, $category_id, $image_name);

    if(mysqli_stmt_execute($stmt)){
      $success= "Product added successfully!";
    }else{// i wanted to give the user a helpful guid to exactly what is wrong for a pleasant experience
      $error="Database error:" . mysqli_stmt_error($stmt);  
      //  $error="Something went wrong. pLease try again."
  }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Producut - Taja Beauty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="css/styles.css?v=3">
</head>
<body class="bg-light">
  <?php include('includes/navbar.php');?>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2 class="mb-4">Add New Product</h2>

        <?php if($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <?php if($error):?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif;?>


        <form action="add_product.php" method="POST" class="bg-white p-4 shadow-sm rounded" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="product_name" class="form-control" required>
         </div>
         <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
         </div>
         <div class="mb-3">
            <label class="form-label">Price (₺)</label>
            <input type="number" name="price" class="form-control" step="0.01" min="0" required>
         </div>
         <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" min="0" required>
         </div>
         <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
              <option value="">Select a Category</option>
              <?php while ($cat= mysqli_fetch_assoc($category_query)): ?>
                <option value="<?php echo $cat['id']; ?>">
                  <?php echo $cat['name'];  ?>
                </option>
              <?php endwhile; ?>
            </select>
         </div>
         <div class="mb-3">
                <label class="form-label"> Product Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
         </div>
         <button type="submit" name="add_product" class="btn btn-success w-100">
           Add Product
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