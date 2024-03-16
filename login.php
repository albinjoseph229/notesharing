<?php
// Start session
session_start();

// Include the database connection file
require_once 'db_connection.php';

// Initialize variables
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$errors = array();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username/email
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Check if username/email exists in database
    $query = "SELECT * FROM Users WHERE username='$username' OR email='$username'";
    $result = mysqli_query($conn, $query);

    // Check if the query failed
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) == 1) {
        // Username/email exists, verify password
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Password is correct, redirect to dashboard or homepage
            $_SESSION['user_id'] = $user['user_id']; // Set session variable
            header("Location: dashboard.php"); // Change to the appropriate page
            exit();
        } else {
            // Password is incorrect
            $errors['password'] = "Incorrect password";
        }
    } else {
        // Username/email not found
        $errors['username'] = "Username/email not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 150px auto;
            /* Increase the top margin */
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #3333ff;
            /* changed to blue */
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #3333ff;
            /* changed to blue */
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0000cc;
            /* changed to darker blue */
        }

        .error {
            color: #ff3333;
        }
    </style>
</head>

<body>
    
    <div class="container">
        <h2>Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div>
                <label>Username/Email:</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
                <span class="error"><?php echo isset($errors['username']) ? $errors['username'] : ''; ?></span>
            </div>
            <div>
                <label>Password:</label>
                <input type="password" name="password">
                <span class="error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></span>
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
        </form>
        <div>
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
    </div>
</body>

</html>