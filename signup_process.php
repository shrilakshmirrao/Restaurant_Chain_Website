<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate form data (you can add your own validation logic here)

    // Connect to the database
    $servername = 'localhost';
    $dbname = 'restaurant_users';
    $dbusername = 'root';
    $dbpassword = "";

    // Create a new MySQLi instance
    // $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname, "3307");
    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname, "3307");

    // Check the connection
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // Check the connection
    if (!$conn) {
        die("Connection failed 123: " . mysqli_connect_error());
    }

    // Prepare and execute the SQL query to insert user data into the database
    $stmt = $conn->prepare("INSERT INTO customers (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    
    if ($stmt->execute()) {
        // Redirect the user to a success page
        header("Location: signup_success.html");
        exit();
    } else {
        // Handle database insert errors
        echo "Error: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
