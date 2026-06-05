<?php
session_start();//start thr session
include('db.php');//connect to the database
//for security , kicks out anyone who is not logged in
if(!isset($_SESSION['username'])){
  header("location: login.php");
  exit();
}

$query = mysqli_query($conn,"SELECT * FROM categories");



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categories - Taja Beauty</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="css/styles.css?v=3">
</head>
<body class="bg-light">
  
<?php include('includes/navbar.php');?>

  <div class="container mt-5">
    

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-4">All Categories</h2>
      <a  href="add_category.php" class="btn btn-success">Add Category</a>
    </div>
    <table class="table table-bordered table-hover bg-white shadow-sm">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Category Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($query)) : ?>
        <tr>
          <td><?php echo htmlspecialchars($row['id']); ?></td>
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td>
            <a href="edit_category.php?id=<?php echo $row['id'];?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="delete_category.php?id=<?php echo $row['id'];?>" class="btn btn-danger btn-sm"
            onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
          </td>

        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <?php include('includes/footer.php'); ?>
  <?php include('includes/sidebar_script.php'); ?>
</body>
</html>