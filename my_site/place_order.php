<?php




//calculate total- create order - get order_id- add each oreder to order_items - clear cart
session_start();//start thr session
include('db.php');//connect to the database
//for security , kicks out anyone who is not logged in

if(!isset($_SESSION['username'])){
  header("location: login.php");
  exit();
}

$user_id = $_SESSION["user_id"];

$cart= mysqli_prepare($conn,"SELECT cart.*, products.price
FROM cart 
LEFT JOIN products ON cart.product_id = products.id
WHERE cart.user_id= ?");

mysqli_stmt_bind_param($cart,"i", $user_id);
mysqli_stmt_execute($cart);
$cart_result= mysqli_stmt_get_result($cart);
$cart_items = mysqli_fetch_all($cart_result, MYSQLI_ASSOC);
//fetch all rows into an array in a single operation

//IF CART IS EMPTY GOES BACK TO CART
if(empty($cart_items)){
  header("Location: cart.php");
  exit();
}

//otherwitse total is calculated
$total = 0;
foreach($cart_items as $item){
  $total += $item['price']* $item['quantity'];
}

//create the order
$status="pending";
$order = mysqli_prepare($conn,"INSERT INTO orders (user_id, total, status) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($order,"ids", $user_id, $total, $status);
mysqli_stmt_execute($order);
$order_id = mysqli_insert_id($conn); //retrieve the id of the last created order

//add each cart item to order_items
foreach( $cart_items as $item){//loop through an array
  $stmt = mysqli_prepare($conn,"INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt,"iiid", $order_id,$item['product_id'], $item['quantity'], $item['price']);
mysqli_stmt_execute($stmt);
}
//clear cart
$clear = mysqli_prepare($conn, "DELETE FROM cart WHERE user_id = ?") ;
mysqli_stmt_bind_param($clear,"i", $user_id);
mysqli_stmt_execute($clear);

//return to orders page
header("Location: orders.php");
exit();
?>