<?php
session_start();
include('db.php');
// Same as login — we need the database connection

if (isset($_POST['register'])) {
    // Runs only when the form is submitted

    $user = trim($_POST['username']);
    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    // We added a confirm password field below in the HTML

    // --- VALIDATION ---
    if (strlen($user) < 3) {
        $error = "Username must be at least 3 characters.";

    } elseif (strlen($pass) < 6) {
        $error = "Password must be at least 6 characters.";

    } elseif ($pass !== $confirm) {
        $error = "Passwords do not match.";
        

    } else {
        // Check if username is already taken
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        // store_result() lets us use num_rows on a prepared statement

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "That username is already taken.";

        } else {
            // Hash the password before saving — NEVER store plain text passwords
            $hashed = password_hash($pass, PASSWORD_DEFAULT);
            // password_hash() scrambles the password into something like:
            // $2y$10$abcdef... — unreadable, but verifiable later with password_verify()

            // Insert the new user into the database
            $stmt2 = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt2, "ss", $user, $hashed);
            // "ss" = two strings

            if (mysqli_stmt_execute($stmt2)) {
                // Registration successful — redirect to homepage
                $_SESSION['username'] = $user;
                $_SESSION['user_id'] = mysqli_insert_id($conn);
                header("Location: index.php");
                exit();
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Taja Beauty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css?v=3">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h2 class="text-center mb-4">Join Taja Beauty</h2>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="register.php" method="POST" class="p-4 bg-white shadow-sm rounded">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                        <!-- New field to make sure user doesn't mistype their password -->
                    </div>
                    <button type="submit" name="register" class="btn btn-success w-100">Sign Up</button>
                    <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>