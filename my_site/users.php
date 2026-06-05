<?php 
session_start();
include('db.php');

if(!isset($_SESSION['username'])){
  header("Location: login.php");
  exit();
}

$query = mysqli_query($conn,"SELECT * FROM users ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users - Taja Beauty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css?v=3">

</head>
<body class="bg-light">

  <?php include('includes/navbar.php');?>
  <div class="container mt-5">
    <h2 class="mb-4">All Users</h2>

    <table class="table table-bordered table-hover bg-white shadow-sm">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Username</th>
            <th>Registered</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>

          <?php while ($row = mysqli_fetch_assoc($query)) : ?>

          <tr>
            <td><?php echo $row['id']?></td>
            <td><?php echo htmlspecialchars($row['username']);?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
              <a href="edit_user.php?id=<?php echo $row['id'];?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="delete_user.php?id=<?php echo $row['id'];?>" class="btn btn-danger btn-sm"
              onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
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