<?php
session_start();//start thr session
include('db.php');//connect to the database
//for security , kicks out anyone who is not logged in
if(!isset($_SESSION['username'])){
  header("location: login.php");
  exit();
}
$success="";
$error= "";

$id= $_GET['id'];//WE USED GET BECAUSE THE VALUES ARE PASSED THROUGH A URL
$fetch=mysqli_prepare($conn,"SELECT * FROM categories WHERE id=?");
mysqli_stmt_bind_param($fetch,"i", $id);
mysqli_stmt_execute($fetch);

$result = mysqli_stmt_get_result($fetch);
$category = mysqli_fetch_assoc($result);

if(!$category){
  header("Location: categories.php");
  exit();
}



if(isset($_POST['update_category'])){
$name= trim($_POST['name']);

if(empty($name)){
  $error="Category name is required!";
}else{
  //query to handle updating the database
 $stmt = mysqli_prepare($conn, "UPDATE categories SET
  name=?
  WHERE id=?");

  mysqli_stmt_bind_param($stmt,"si", $name, $id);


if(mysqli_stmt_execute($stmt)){
  $success= "Category updated successfully!";
}else{
  $error = "Database error:". mysqli_stmt_error($stmt);
}
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Category - Taja Beauty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css?v=3">
</head>
<body class="bg-light">
 <?php include('includes/navbar.php'); ?>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2 class="mb-4"> Edit Category</h2>
        <?php if($success): ?>
        <div class="alert alert-success"> <?php echo htmlspecialchars($success);?> </div>
        <?php endif; ?>

        <?php if($error): ?>
        <div class="alert alert-danger"> <?php echo htmlspecialchars($error);?> </div>
        <?php endif; ?>

        <form action="edit_category.php?id=<?php echo $id ?>" method="POST" class="bg-white p-4 shadow-sm rounded">

        <div class="mb-3">
          <label class="form-label">Category Name</label>
          <input type="text" name="name" class="form-control" 
          value="<?php echo htmlspecialchars(isset($_POST['name']) ? $_POST['name'] :$category['name']); ?>">
        </div>

        
        <button type="submit" name="update_category" class="btn btn-warning w-100">
          Edit Category
        </button>
        </form>
     </div>
    </div>
  </div>
<?php include('includes/footer.php'); ?>
<?php include('includes/sidebar_script.php'); ?>
  
</body>
</html>