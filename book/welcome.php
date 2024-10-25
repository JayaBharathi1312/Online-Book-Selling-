<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
    <p>You are logged in successfully.</p>

    <form action="logout.php" method="POST">
        <input type="submit" value="Logout">
    </form>
</body>
</html>
