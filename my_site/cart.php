<?php

session_start();//start thr session
include('db.php');//connect to the database
//for security , kicks out anyone who is not logged in
if(!isset($_SESSION['username'])){
  header("location: login.php");
  exit();
}

$user_id = $_SESSION["user_id"];

$query= mysqli_prepare($conn,"SELECT cart.*, products.product_name, products.price, products.image
FROM cart 
LEFT JOIN products ON cart.product_id = products.id
WHERE cart.user_id= ?");

mysqli_stmt_bind_param($query,"i", $user_id);
mysqli_stmt_execute($query);
$result= mysqli_stmt_get_result($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart - Taja Beauty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css?v=3">
</head>
<body class="bg-light">

  <?php include('includes/navbar.php'); ?>

  <div class="container mt-5">
    <h2 class="mb-4">My Cart</h2>

    <table class="table table-bordered table-hover bg-white shadow-sm">
      <thead class="table-dark">
        <tr>
          <th>Image</th>
          <th>Product</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Subtotal</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $total = 0;
        while ($row= mysqli_fetch_assoc($result)):
          $subtotal = $row['price']* $row['quantity'];
          $total+=$subtotal;
          ?>
        <tr>
          <td>
          <?php if ($row['image']): ?>
            <img src = "uploads/<?php echo $row['image']; ?>" width="50" height="50" style="object-fit:cover;">
          <?php else: ?>
            No Image
          <?php endif; ?>
          </td>
          <td><?php echo htmlspecialchars($row['product_name']);?></td>
          <td>₺ <?php echo $row['price']; ?></td>
          <td>
            <form action="update_cart.php" method="POST" style="display:flex; gap:5px;">
              <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
              <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" min="1" class="form-control" style="width:70px;">
              <button type="submit" class="btn btn-sm btn-primary">Update</button>
            </form>
          </td>
          <td>₺ <?php echo number_format($subtotal, 2);?></td>
          <td>
            <a href="delete_cart.php?id=<?php echo $row['id']; ?>"
            class="btn btn-danger btn-sm"
            onclick="return confirm('Remove this item from cart?')">Remove</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
      <tfoot class="table-dark">
        <tr>
          <td colspan="4" class="text-end fw-bold">Total</td>
          <td colspan="2">₺ <?php echo number_format($total, 2)?></td>
        </tr>
      </tfoot>
    </table>
    
    <?php if($total> 0): ?> <!-- the button only appears when there is an item in cart-->
      <div class="text-end mt-3">
        <a href="place_order.php" class="btn btn-success btn-lg">
          Place Order (₺ <?php echo number_format($total, 2) ?>)
        </a>
      </div>
      <?php endif; ?>
  </div>
  <?php include('includes/footer.php'); ?>
  <?php include('includes/sidebar_script.php'); ?>
</body>
</html>