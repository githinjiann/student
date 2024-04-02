<?php
// Define the default credentials
$defaultUsername = "ann";
$defaultPassword = "123";

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
    <style>
        .navbar.bg-skyblue {
            background-color: skyblue;
        }

           /* Custom style for the navbar and logo */
       

        .navbar img {
            padding: 10px;
            background-color: #4CAF50; /* Green background for the logo */
            border-radius: 50%; /* Make the logo area a circle */
        }

        /* Custom class to set the navbar width */
        .custom-navbar {
            margin: auto;
            max-width: 400px; /* Adjust the max-width as needed */
        }

        /* Apply margin-top to the entire page content */
        body {
            margin-top: 20px;
        }

        </style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-skyblue">
        <div class="container">
            <a class="navbar-brand" href="#" style="font-weight: bold; font-family: georgia, sans-serif;">UNIVERSITY OF EMBU</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <!-- Modify the "Login" link to have an ID for easy access -->
                   
                        <a class="nav-link" href="admin_login.php">Admin</a>
                    </li>
                  

                </ul>
            </div>
        </div>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="image/log.jpg" alt="Your Logo" class="img-fluid logo-img">
            </a>
        </div>
    </nav>
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