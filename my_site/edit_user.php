<?php



session_start();//start thr session
include('db.php');//connect to the database
//for security , kicks out anyone who is not logged in
if(!isset($_SESSION['username'])){
  header("location: login.php");
  exit();
}
$success="";
$error= "";

$id= $_GET['id'];

$fetch = mysqli_prepare($conn,"SELECT * FROM users WHERE id=?");
mysqli_stmt_bind_param($fetch,"i", $id);
mysqli_stmt_execute($fetch);
$result = mysqli_stmt_get_result($fetch);
$user = mysqli_fetch_assoc($result);


if(!$user){
  header("Location: users.php");
  exit();
}

if(isset($_POST['update_user'])){
$user_name= trim($_POST['username']);
$new_password= $_POST['new_password'];


if(empty($user_name)){
  $error="Username is required!";
}else{
  //check if username already exists
  $check = mysqli_prepare($conn,"SELECT id FROM users WHERE username=? AND id!=?");//!= check if user name is taken
  mysqli_stmt_bind_param($check,"si", $user_name, $id);
  mysqli_stmt_execute($check);
  mysqli_stmt_store_result($check);

  if(mysqli_stmt_num_rows($check) > 0){
    $error="That username is already taken!";
  }else{
    if(!empty($new_password)){//only admin can update the password
      //update username and password

      $hashed = password_hash($new_password, PASSWORD_DEFAULT);//hash the new pasword befor register(register.php)
      $stmt = mysqli_prepare($conn,"UPDATE users SET username = ?, password=?
      WHERE id=?");
      mysqli_stmt_bind_param($stmt, "ssi", $user_name, $hashed, $id);
    }else{
      //update username only
      $stmt = mysqli_prepare($conn,"UPDATE users SET username=? 
      WHERE id=?");
      mysqli_stmt_bind_param($stmt, "si", $user_name, $id);
    }

  if(mysqli_stmt_execute($stmt)){
    $success= "User updated successfully!";

    if($id == $_SESSION['user_id']){
      $_SESSION['username']= $user_name;
    }

    //close the previous statements before re-fetching
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($fetch);
    
    $fetch2= mysqli_prepare($conn,"SELECT * FROM users WHERE id=?");
    mysqli_stmt_bind_param($fetch2,"i", $id);
    mysqli_stmt_execute($fetch2);

    $result2= mysqli_stmt_get_result($fetch2);
    $user = mysqli_fetch_assoc($result2);
  }else{
    $error= "Databasr error:" . mysqli_stmt_error($stmt);
  }
  }
 }
}
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User - Taja Beauty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css?v=3">
 </head>
 <body class="bg-light">

 <?php include('includes/navbar.php'); ?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h2 class="mb-4">Edit User</h2>

      <?php if($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success)?></div>
      <?php endif; ?>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error) ?></div>
      <?php endif; ?>


      <form action="edit_user.php?id=<?php echo $id; ?>" method="POST" class="bg-white p-4 shadow-sm rounded">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control"
          value="<?php echo htmlspecialchars(isset($_POST['username']) ? $_POST['username'] : $user['username']); ?>">
        </div>
        <div class="mb-3">
        <label class="form-label">New Password</label>
          <input type="password" name="new_password" class="form-control">
          <small class="text-muted">Leave blank to keep current password</small>
        </div>
        <button type="submit" name="update_user" class="btn btn-warning w-100">
          Update User
        </button>
      </form>
       <a href="users.php" class="btn btn-secondary mt-3 w-100">Back to Users</a>
    </div>
  </div>
</div>
  <?php include('includes/footer.php'); ?>
  <?php include('includes/sidebar_script.php'); ?>
 </body>
 </html>
  