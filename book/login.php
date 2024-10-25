<?php
// Database credentials
$host = "localhost";
$dbname = "regdb";
$username = "root";
$password = "";

// Start session
session_start();

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$username = $password = "";
$usernameErr = $passwordErr = "";
$errorMsg = "";
  
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = htmlspecialchars(strip_tags($_POST["username"]));
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = htmlspecialchars(strip_tags($_POST["password"]));
    }

    // Check if there are no errors
    if (empty($usernameErr) && empty($passwordErr)) {
        // Prepare SQL query to select user by username
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE name = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Check if user exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $name, $password_hashed);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $password_hashed)) {
                // Start session and store user info
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $name;

                // Redirect to a welcome page or dashboard
                header("Location: welcome.php");
                exit();
            } else {
                $errorMsg = "Invalid password.";
            }
        } else {
            $errorMsg = "No account found with that username.";
        }
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <style>
        body {
            margin-left: 30px;
            margin-top: 100px;
            font-family: Arial, sans-serif;
            font-weight: bold;
            background-image: url('Abstract Video.gif');
            

        }

        .container {
            width: 400px;
            margin: 20px auto;
            background-color:#0067B9;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            color:darkblue;
            font-family: Kristen ITC;
        }

        h2 {
            text-align: center;
            color: darkblue;
            font-family: Bookman Old Style;
        }

        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 5px 0 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 380px;
            background-color: darkblue;
            font-weight: bold;
            color: white;
            padding: 10px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: lightseagreen;
        }

        .error {
            color: red;
            margin-bottom: 5px;
        }

        .errorMsg {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        
    </style>
</head>
<body>

<div class="container">
    <h2>Login </h2>

    <?php
    // Display error message if login fails
    if (!empty($errorMsg)) {
        echo "<p class='errorMsg'>$errorMsg</p>";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <div class="form-group " >   
    <label for="username">Username</label>
        <span class="error"><?php echo $usernameErr; ?></span>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>

        <label for="password">Password</label>
        <span class="error"><?php echo $passwordErr; ?></span>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login"></div>
    
</div>
</>
</body>
</html>
