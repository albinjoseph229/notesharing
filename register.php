<?php
// Initialize variables
$username = isset($_POST['username']) ? $_POST['username'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$errors = array();

// Include the database connection file
require_once 'db_connection.php';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate username
    if (empty($username)) {
        $errors['username'] = "Username is required";
    }

    // Validate email
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // Validate password
    if (empty($password)) {
        $errors['password'] = "Password is required";
    }

    // If there are no errors, proceed with registration
    if (empty($errors)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $query = "INSERT INTO Users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        if (mysqli_query($conn, $query)) {
            // Registration successful
            echo "Registration successful! You can now <a href='login.php'>login</a>.";
            exit();
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
    }
    .container {
            max-width: 400px;
            margin: 130px auto;
            /* Increase the top margin */
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    h2 {
        text-align: center;
        color: #3333ff; /* changed to blue */
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
        background-color: #3333ff; /* changed to blue */
        color: #fff;
        font-size: 16px;
        cursor: pointer;
    }
    button[type="submit"]:hover {
        background-color: #0000cc; /* changed to darker blue */
    }
    .error {
        color: #ff3333;
    }
</style>
</head>

<body>
    <div class="container">
        <h2>Register</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div>
                <label>Username:</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
                <span class="error"><?php echo isset($errors['username']) ? $errors['username'] : ''; ?></span>
            </div>
            <div>
                <label>Email:</label>
                <input type="text" name="email" value="<?php echo $email; ?>">
                <span class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
            </div>
            <div>
                <label>Password:</label>
                <input type="password" name="password">
                <span class="error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></span>
            </div>
            <div>
                <button type="submit">Register</button>
            </div>
        </form>
        <div>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>

</html>