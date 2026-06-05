<?php

session_start();
// session_start() must be the FIRST thing on every page that uses sessions
// A session is like a temporary memory that remembers who is logged in

include('db.php');
// Pulls in your database connection so $conn is available here

if(isset($_COOKIE['remember_user'])&& !isset($_SESSION['username'])){
    $cookie_user = $_COOKIE['remember_user'];

    $stmt = mysqli_prepare($conn,"SELECT * FROM users WHERE username= ?");
    mysqli_stmt_bind_param($stmt,"s", $cookie_user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);  

  
    if($row){
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['id'];
        header("Location: index.php");
        exit();
    }
}
if (isset($_POST['login'])) {
    // isset() checks if the form was submitted (the button has name="login")
    // $_POST is a PHP array that holds everything the form sent

    $user = trim($_POST['username']);
    $pass = $_POST['password'];
    // trim() removes accidental spaces before/after the username
    // We never modify the raw password before checking it

    // SECURE WAY: prepared statement (prevents SQL injection)
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    // mysqli_prepare() creates the query with a placeholder "?" instead of the real value
    // This way the database never confuses data with commands

    mysqli_stmt_bind_param($stmt, "s", $user);
    // "s" means the value is a string
    // We're telling PHP: replace the "?" with $user safely

    mysqli_stmt_execute($stmt);
    // Actually runs the query

    $result = mysqli_stmt_get_result($stmt);
    // Gets the result rows from the executed query

    if (mysqli_num_rows($result) > 0) {
        // Checks if any user with that username was found

        $row = mysqli_fetch_assoc($result);
        // Fetches the row as an associative array
        // e.g. $row['username'], $row['password'], $row['email']

        if (password_verify($pass, $row['password'])) {
            // password_verify() compares the plain text password the user typed
            // with the hashed version stored in the database
            // This works because register.php used password_hash() to store it

            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['id'];
            // Store username AND id in session so we can use them on other pages
            // $_SESSION persists across pages until logout
            if(isset($_POST['remember_me'])) {
                setcookie('remember_user',$row['username'], time()+(86400*30),  '/');
            }else{
                setcookie('remeber_user', '', time()-3600, '/');
            }
            header("Location: index.php");
            exit();
            // Redirect to homepage. exit() is important — it stops
            // the rest of the PHP from running after the redirect

        } else {
            $error = "Wrong password. Please try again.";
            // Store error in a variable — we'll display it nicely in the HTML below
        }
    } else {
        $error = "No account found with that username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Taj'a Beauty - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css?v=3">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h2 class="text-center mb-4">Login to Taj'a Beauty</h2>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <!-- This shows a red Bootstrap error box only if $error was set above -->
                <!-- Much better than a JavaScript alert() popup -->

                <form action="login.php" method="POST" class="p-4 bg-white shadow-sm rounded">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember_me" id="remember_me" class="form-check-input">
                        <label for="remember_me" class="form-check-label">Remember Me</label>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                    <p class="text-center mt-3">Don't have an account? <a href="register.php">Register</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>