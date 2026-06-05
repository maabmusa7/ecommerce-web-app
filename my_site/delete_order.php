<?php 
session_start();
include('db.php');

if(!isset($_SESSION['username'])){
  header("Location: login.php");
  exit();
}

$id= $_GET['id'];
//first we delete order items
$stmt1 = mysqli_prepare($conn, "DELETE FROM order_items WHERE order_id=?");
mysqli_stmt_bind_param($stmt1,"i", $id);
mysqli_stmt_execute($stmt1);

//then delete the order
$stmt2 = mysqli_prepare($conn, "DELETE FROM orders WHERE id=?");
mysqli_stmt_bind_param($stmt2,"i", $id);
mysqli_stmt_execute($stmt2);


header("Location: orders.php");
exit();
?>