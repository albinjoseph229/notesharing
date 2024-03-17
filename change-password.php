<?php
// Start session
session_start();

// Include the database connection file
require_once 'db_connection.php';

// Initialize variables
$current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
$errors = array();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate current password
    $current_password = mysqli_real_escape_string($conn, $current_password);
    $new_password = mysqli_real_escape_string($conn, $new_password);
    $confirm_password = mysqli_real_escape_string($conn, $confirm_password);

    // Retrieve user ID from session or wherever it's stored
    // For demonstration purpose, I assume it's stored in $_SESSION['user_id']
    $user_id = $_SESSION['user_id']; // Adjust this according to your application

    // Query the database to retrieve user information
    $query = "SELECT * FROM Users WHERE user_id=$user_id";
    $result = mysqli_query($conn, $query);

    // Check if the query failed
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Check if the user exists
    if (mysqli_num_rows($result) == 1) {
        // User found, verify current password
        $user = mysqli_fetch_assoc($result);
        if (password_verify($current_password, $user['password'])) {
            // Current password is correct, validate new password
            if ($new_password === $confirm_password) {
                // New password matches confirm password, update password in database
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_query = "UPDATE Users SET password='$hashed_password' WHERE user_id=$user_id";
                $update_result = mysqli_query($conn, $update_query);
                if ($update_result) {
                    // Password updated successfully
                    $_SESSION['success_message'] = "Password changed successfully.";
                    header("Location: dashboard.php"); // Change to the appropriate page
                    exit();
                } else {
                    // Error updating password
                    $errors['general'] = "An error occurred while changing the password.";
                }
            } else {
                // New password and confirm password do not match
                $errors['confirm_password'] = "New password and confirm password do not match.";
            }
        } else {
            // Current password is incorrect
            $errors['current_password'] = "Incorrect current password.";
        }
    } else {
        // User not found
        $errors['general'] = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
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
        <h2>Change Password</h2>
        <?php
        // Check for success message and display it
        if (isset($_SESSION['success_message'])) {
            echo "<p class='success-message'>{$_SESSION['success_message']}</p>";
            unset($_SESSION['success_message']); // Remove the success message from session after displaying
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label>Current Password:</label>
            <input type="password" name="current_password">
            <span class="error"><?php echo isset($errors['current_password']) ? $errors['current_password'] : ''; ?></span>
        </div>
        <div>
            <label>New Password:</label>
            <input type="password" name="new_password">
            <span class="error"><?php echo isset($errors['general']) ? $errors['general'] : ''; ?></span>
        </div>
        <div>
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password">
            <span class="error"><?php echo isset($errors['confirm_password']) ? $errors['confirm_password'] : ''; ?></span>
        </div>
        <div>
            <button type="submit">Change Password</button>
        </div>
    </form>
    <div>
            <p>Return Home? <a href="dashboard.php">Dashboard</a></p>
        </div>
    </div>
</body>

</html>