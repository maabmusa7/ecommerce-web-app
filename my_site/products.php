<?php
session_start();//start thr session
include('db.php');//connect to the database
//for security , kicks out anyone who is not logged in
if(!isset($_SESSION['username'])){
  header("location: login.php");
  exit();
}

$query = mysqli_query($conn,"SELECT products.*, categories.name AS category_name 
FROM products
LEFT JOIN categories ON products.category_id=categories.id");


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product - Taja Beauty</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="css/styles.css?v=3?v=3">
</head>
<body class="bg-light">
  
<?php include('includes/navbar.php');?>

  <div class="container mt-5">
    <div class="d-flex justify-content-between aligh-items-center mb-4">
    <h2>All Products</h2>
    <a  href="add_product.php" class="btn btn-success">Add Product</a>
    </div>

    <div class="mb-3">
      <input type="text" id="searchBox" class="form-control"
      placeholder="What are you Looking for?">
    </div>
    
    
    <table class="table table-bordered table-hover bg-white shadow-sm">
      <thead class="table-dark">
        <tr>
          <th>Image</th>
          <th>Product Name</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Category</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($query)) : ?>
        <tr>
          <td>
            <?php if ($row['image']): ?>
              <img src="uploads/<?php echo $row['image']; ?>"  width="60" height="60" style="object-fit:cover;">
            <?php else: ?>
              No Image 
            <?php endif; ?>
          </td>
          <td><?php echo $row['product_name']?></td>
          <td><?php echo $row['price']?></td>
          <td><?php echo $row['stock']?></td>
          <td><?php echo $row['category_name']? htmlspecialchars($row['category_name']): '<span class="text-muted">Uncategorized</span>'?></td>
          <td>
            <form action="add_to_cart.php" method="POST" style="display:inline;">
              <input type="hidden" name="product_id" value="<?php echo $row['id']; ?> ">
              <button type="submit" class="btn btn-success btn-sm">Add to Cart</button>
            </form>
             <a href="edit_product.php?id=<?php echo $row['id'];?>" class="btn btn-warning btn-sm">Edit</a>
             <a href="delete_product.php?id=<?php echo $row['id'];?>" class="btn btn-warning btn-sm"
            onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
          </td>

        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <script>
    document.getElementById('searchBox').addEventListener('keyup', function(){//(JS Events) +(JS HTML DOM)
              //everytime the users releases a key the function is called
      let searchValue = this.value;//this-> searchBox.whatever the user types(JS HTML DOM)

      fetch('search.php', {//JSFetch API, modern way to make HTTP Requests  instead of XMLHttpRequest
        method: 'POST',//JSFetch API
        headers: {//JSFetch API
          'Content-Type': 'application/x-www-form-urlencoded'

        },
        body: 'search=' + encodeURIComponent(searchValue)//makes the search term URL safe(JS Encoding)
      })
      .then(function(response){//(JS Promises)
        return response.text();//convert response into readable text from table rows
      })
      .then(function(data){
        document.querySelector('tbody').innerHTML = data;//find the tbody in the table. replace everything inside of it into the new rows returned from search.php
      });//(JS HTML DOM)
    });
  </script>
  <?php include('includes/footer.php'); ?>
  <?php include('includes/sidebar_script.php'); ?>
</body>
</html>