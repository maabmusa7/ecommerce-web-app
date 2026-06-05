<?php 

error_reporting(E_ALL); ini_set('display_errors', 1);


session_start();
include('db.php');

if(!isset($_SESSION['username'])){
  header("Location: login.php");
  exit();
}

$user_id= $_SESSION['user_id'];

$query = mysqli_prepare($conn,"SELECT orders.*, COUNT(order_items.id) as item_count
FROM orders
LEFT JOIN order_items ON orders.id = order_items.order_id
WHERE orders.user_id = ?
GROUP BY orders.id
ORDER BY orders.created_at DESC");

mysqli_stmt_bind_param($query, "i", $user_id);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders - Taja Beauty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css?v=3">
</head>
<body class="bg-light">


  <?php include('includes/navbar.php')?>
  <div class="container mt-5">
    <h2 class="mb-4">My Orders</h2>

    <table class="table table-bordered table-hover bg-white shadow-sm">
        <thead class="table-dark">
          <tr>
            <th>Order #</th>
            <th>Items</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>

          <?php while ($row = mysqli_fetch_assoc($result)) : ?>

          <tr>
            <td><?php echo $row['id']?></td>
            <td><?php echo $row['item_count']?>Items</td>
            <td>₺<?php echo number_format($row['total'], 2); ?></td>
            <td>
              <span class="badge 
                    <?php echo $row['status'] == 'pending' ? 'bg-warning':
                    ($row['status'] == 'completed' ? 'bg-success' : 'bg-danger' ); ?>">
                    <?php echo ucfirst($row['status']); ?> 
                    </span>
            </td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
              <a href="view_order.php?id=<?php echo $row['id'];?>" class="btn btn-primary btn-sm">View</a>
              <a href="delete_order.php?id=<?php echo $row['id'];?>" class="btn btn-danger btn-sm"
              onclick="return confirm('Are you sure you want to cancel this order?')">Cancel</a>
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