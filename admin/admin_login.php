<?php
// Define the default credentials
$defaultUsername = "ann";
$defaultPassword = "ann1234";

// Initialize variables to hold error messages
$errorMessage = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered username and password
    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["password"];

    // Check if the entered credentials are valid
    if ($enteredUsername === $defaultUsername && $enteredPassword === $defaultPassword) {
        // Redirect to the admin dashboard (admin_dashboard.php)
        header("Location: admin_dashboard.php");
        exit(); // Ensure that the script stops here and does not continue executing

        // You can add further authentication and session management here if needed
    } else {
        $errorMessage = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <!-- Add Bootstrap CSS and JavaScript links here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3 col-md-4">
        <h2 class="text-center">Admin Login</h2>
        <?php
        if (!empty($errorMessage)) {
            echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
        }
        ?>
        <form action="" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <!-- Add Bootstrap JavaScript links here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>