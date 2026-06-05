<?php
session_start();
include('db.php');//connect to the database
//for security 
if(!isset($_SESSION['username'])){
  header("location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

$product_id = $_POST['product_id'];

$check = mysqli_prepare($conn, "SELECT * FROM cart WHERE user_id= ? AND product_id= ?");
mysqli_stmt_bind_param($check,"ii", $user_id, $product_id);
mysqli_stmt_execute($check);
$result = mysqli_stmt_get_result($check);

if(mysqli_num_rows($result) > 0){

$row = mysqli_fetch_assoc($result);
$new_qty = $row['quantity'] + 1;

  $stmt = mysqli_prepare($conn, "UPDATE cart SET quantity =? WHERE user_id=? AND product_id=?");
  mysqli_stmt_bind_param($stmt,"iii", $new_qty, $user_id, $product_id);
  mysqli_stmt_execute($stmt);
}else{
  $stmt = mysqli_prepare($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
  mysqli_stmt_bind_param($stmt,"ii", $user_id, $product_id);
  mysqli_stmt_execute($stmt);
}

header("Location: ". $_SERVER['HTTP_REFERER']);
exit();
?>