<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to the database
    $servername = 'localhost';
    $dbname = 'restaurant_users';
    $dbusername = 'root';
    $dbpassword = "";

    // Create a new MySQLi connection
    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname, "3307");

    // Check the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and execute the SQL query to fetch user data
    $stmt = mysqli_prepare($conn, "SELECT * FROM customers WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    // Check if the user exists
    if (mysqli_num_rows($result) === 1) {
        // Fetch the user record
        $row = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Password is correct, log in the user
            session_start();
            $_SESSION['username'] = $row['username'];
            header("Location: restaurant.php");
            exit();
        } else {
            // Invalid password
            echo "Invalid password";
        }
    } else {
        // User does not exist
        echo "User not found";
    }

    // Close the database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
