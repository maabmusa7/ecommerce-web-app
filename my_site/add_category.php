<?php
session_start();
include('db.php');//connect to the database
//for security 
include('includes/navbar.php');
if(!isset($_SESSION['username'])){
  header("location: login.php");
  exit();
}

$success="";
$error= "";



if(isset($_POST["add_category"])){
  $name= trim($_POST['name']);
  
  if(empty($name)){
    $error= "Category name is required!";
  }else{// to avoid repition i will check before insertion
    //all the above checkpoints have been passed
    //now the data is ready to be inserted into the database

    $check = mysqli_prepare($conn,"SELECT id FROM categories WHERE name=?");
    mysqli_stmt_bind_param($check,"s", $name);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if(mysqli_stmt_num_rows($check) > 0){
      $error= "This category already exixts!";
    }else{
      $stmt= mysqli_prepare($conn,"INSERT INTO categories (name) VALUES(?)");
      mysqli_stmt_bind_param($stmt,"s", $name);

      if(mysqli_stmt_execute($stmt)) {
        $success = "Category added successfully!";
      }else{
        $error="Database error:" . mysqli_stmt_error($stmt);  
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Category - Taja Beauty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css?v=3">
</head>
<body class="bg-light">
  <?php include('include/navbar.php'); ?>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2 class="mb-4">Add New Category</h2>

        <?php if($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <?php if($error):?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif;?>


        <form action="add_category.php" method="POST" class="bg-white p-4 shadow-sm rounded">
          <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" 
            value="<?php echo htmlspecialchars(isset($_POST['name'])?$_POST['name'] : '');?>">

         </div>
         
         <button type="submit" name="add_category" class="btn btn-success w-100">
           Add Category
         </button>
        </form>
      </div>
    </div>
  </div>
  <?php include('includes/footer.php'); ?>
  <?php include('includes/sidebar_script.php'); ?>
</body>
</html>