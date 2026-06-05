<?php 
include('db.php');//to get $conn
//no need to start a session because the file is called seceretly by JS ,not directly visisted by the users
$search = trim($_POST['search']);//get the search term typed by the user and remove spaces
//it comes from JS , not like a normal form submit

$query = mysqli_prepare($conn,"SELECT products.*, categories.name AS category_name
FROM products
LEFT JOIN categories ON products.category_id = categories.id
WHERE products.product_name LIKE ?");


$search_term = "%" . $search . "%";//anything that contains the searched term
mysqli_stmt_bind_param($query, "s", $search_term);
mysqli_stmt_execute($query);
$result= mysqli_stmt_get_result($query);

while($row=mysqli_fetch_assoc($result)){
  //loop through matching products, each loop creates a row that will be injected into the products table by JS
  echo "<tr>
          <td><img src='uploads/". $row['image'] . "'width='50' height='50' style='object-fit:cover;'></td>
          <td>". htmlspecialchars($row['product_name']) ."</td>
          <td> ₺". $row['price'] ."</td>
          <td>". $row['stock'] . "</td>
          <td>". htmlspecialchars($row['category_name']) ."</td>
          <td>
            <a href='edit_product.php?id=". $row['id'] ."'class='btn btn-warning btn-sm'>Edit</a>
            <a href='delete_product.php?id=". $row['id'] ."'class='btn btn-danger btn-sm' onclick='return confirm (\"Are you sure?\")'>Delete</a>
          </td>
        </tr>";
}
//it returns HTML table rows
?>