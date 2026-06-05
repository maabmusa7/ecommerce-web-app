<?php
session_start();//start thr session
include('db.php');//connect to the database
//for security , kicks out anyone who is not logged in
if(!isset($_SESSION['username'])){
  header("location: login.php");
  exit();
}

$cart_id= $_POST['cart_id'];
$quantity= $_POST['quantity'];

if($quantity < 1){
  $quantity= 1;
}
$stmt=mysqli_prepare($conn,"UPDATE cart SET quantity=? WHERE id=?");
mysqli_stmt_bind_param($stmt,"ii",$quantity, $cart_id);
mysqli_stmt_execute($stmt);

header("Location: cart.php");
exit();
?>