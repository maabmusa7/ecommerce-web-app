<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
session_start();//start thr session
include('db.php');//connect to the database
//for security , kicks out anyone who is not logged in
if(!isset($_SESSION['username'])){
  header("location: login.php");
  exit();
}

$id = $_GET['id'];

$order_fetch= mysqli_prepare($conn,"SELECT *
FROM orders 
WHERE id= ?");

mysqli_stmt_bind_param($order_fetch,"i", $id);
mysqli_stmt_execute($order_fetch);
$order_result= mysqli_stmt_get_result($order_fetch);
$order = mysqli_fetch_assoc($order_result);

if(!$order){
  header("Location: orders.php");
  exit();
}

//get order items
$items_fetch = mysqli_prepare($conn,"SELECT order_items.*, products.product_name, products.image
FROM order_items
LEFT JOIN products ON order_items.product_id = products.id
WHERE order_items.order_id = ?");

mysqli_stmt_bind_param($items_fetch,"i", $id);
mysqli_stmt_execute($items_fetch);
$items_result = mysqli_stmt_get_result($items_fetch);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order# <?php echo $id; ?> - Taja Beauty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css?v=3">
</head> 
<body class="bg-light">

  <?php include('includes/navbar.php'); ?>

    <div class="container mt-5">
     <h2 class="mb-4">Order # <?php echo $id ?></h2>

     <div class="alert alert-info">
      <strong>Status: <?php echo ucfirst($order['status']) ?></strong>
      <strong>Total: <?php echo number_format($order['total'], 2) ?></strong>
      <strong>Date: <?php echo ucfirst($order['created_at']) ?></strong>
     </div>

     <table class="table table-bordered bg-white shadow-sm">
      <thead class="table-dark">
        <tr>
          <th>Image</th>
          <th>Product</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Subtotal</th>
        </tr>
      </thead>


      <tbody>
        <?php while($item = mysqli_fetch_assoc($items_result)): ?>
          <tr>
            <td>
              <?php if($item['image']): ?>
                <img src="uploads/<?php echo $item['image']; ?>" width="50" height="50" style="object-fit:cover;">
              <?php else: ?>
                No Image
              <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td>₺<?php echo number_format($item['price'], 2) ?></td>
            <td>₺<?php echo number_format($item['price']* $item['quantity'], 2) ?></td>
          </tr>
          <?php endwhile; ?>
      </tbody>
     
    </table>
          <a href="orders.php" class="btn btn-secondary">Back to Orders</a>
    </div>
  <?php include('includes/footer.php'); ?>
  <?php include('includes/sidebar_script.php'); ?>
</body>
</html>