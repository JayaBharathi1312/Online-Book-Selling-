<?php
// Database credentials
$host = "localhost"; // Host name
$dbname = "regdb"; // Database name
$username = "root"; // Database username
$password = ""; // Database password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$name = $email = $password = $phone = $sex = $dob = $language = $address = "";
$nameErr = $emailErr = $passwordErr = $phoneErr = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    if (empty($_POST['name'])) {
        $nameErr = "Name is required";
    } else {
        $name = htmlspecialchars(strip_tags($_POST['name']));
    }

   
    if (empty($_POST['password'])) {
        $passwordErr = "Password is required";
    } else {
        $password = htmlspecialchars(strip_tags($_POST['password']));
        // Hash the password for security
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    }
	if (empty($_POST['email'])) {
        $emailErr = "Email is required";
    } else {
        $email = htmlspecialchars(strip_tags($_POST['email']));
    }

    if (empty($_POST['phone'])) {
        $phoneErr = "Phone number is required";
    } else {
        $phone = htmlspecialchars(strip_tags($_POST['phone']));
    }
	$sex = $_POST['sex'];
    $dob = $_POST['dob'];
    $language = $_POST['language'];
    $address = htmlspecialchars(strip_tags($_POST['address']));

    // Check if there are no errors
    if (empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($phoneErr)) {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (name, password, email, phone, sex, dob,languages, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $name, $password_hashed, $email, $phone, $sex, $dob, $language, $address);
        if ($stmt->execute()) {
            $successMsg = "Registration successful!";
             // Redirect to a welcome page or dashboard
             header("Location: login.php");
             exit();
        } else {
            $errorMsg = "Error: " . $stmt->error;
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
    <title>Registration Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('blink.gif');
        }

        .container {
            width: 40%;
            margin: 20px auto;
            background-color: #313163;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            color: #A5CEF7;
        }

        h2 {
            text-align: center;
            color: #4A9CAD;
        }

        input[type="text"],
input[type="password"],
input[type="email"],
input[type="tel"],
input[type="date"],
select,
textarea {
    width: 100%; /* or a specific width */
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box; /* Ensures padding and border are included in the width */
}


        label {
            font-weight: bold;
            color: #4A9CAD;
        }

        input[type="submit"] {
            width: 100%;
            background-color:  #4A9CAD;
            color: white;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #737BAD;
        }

        .error {
            color: red;
            margin-bottom: 5px;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
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
    <h2>Registration Form</h2>

    <?php
    if (isset($successMsg)) {
        echo "<p class='success'>$successMsg</p>";
    }

    if (isset($errorMsg)) {
        echo "<p class='errorMsg'>$errorMsg</p>";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="name">Full Name</label>
        <span class="error"><?php echo $nameErr; ?></span>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>

        <label for="password">Password</label>
        <span class="error"><?php echo $passwordErr; ?></span>
        <input type="password" id="password" name="password" required>

        <label for="email">Email</label>
        <span class="error"><?php echo $emailErr; ?></span>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

        <label for="phone">Phone Number</label>
        <span class="error"><?php echo $phoneErr; ?></span>
        <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" required>

        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" name="dob" value="<?php echo $dob; ?>" required>

        <label for="sex">Sex</label>
        <select id="sex" name="sex" required>
            <option value="">Select Sex</option>
            <option value="Male" <?php if($sex == 'Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if($sex == 'Female') echo 'selected'; ?>>Female</option>
            <option value="Other" <?php if($sex == 'Other') echo 'selected'; ?>>Other</option>
        </select>

        <label for="language">Language</label>
        <select id="language" name="language" required>
            <option value="">Select Language</option>
            <option value="English" <?php if($language == 'English') echo 'selected'; ?>>English</option>
            <option value="Spanish" <?php if($language == 'Hindi') echo 'selected'; ?>>Spanish</option>
            <option value="French" <?php if($language == 'French') echo 'selected'; ?>>French</option>
        </select>

        <label for="address">Address</label>
        <textarea id="address" name="address" rows="3" required><?php echo $address; ?></textarea>

        <input type="submit" value="Register">
    </form>
</div>

</body>
</html>
