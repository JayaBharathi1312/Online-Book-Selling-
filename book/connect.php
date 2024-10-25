<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your MySQL password
$dbname = "regdb";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sex = $_POST['sex'];
    $dob = $_POST['dob'];
    $languages = implode(", ", $_POST['languages']);
    $address = $_POST['address'];

    // Prepare an SQL statement to insert the data into the database
    $sql = "INSERT INTO users (name, password, email, phone, sex, dob, languages, address) 
            VALUES ('$name', '$password', '$email', '$phone', '$sex', '$dob', '$languages', '$address')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
