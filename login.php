<?php
// Include the database connection file (connect.php)
require_once('connect.php');

// Start a session to manage user login state
session_start();

// Initialize variables
$courseCode = "";
$password = "";
$errorMessage = ""; // Initialize error message

// Check if the login form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the login form
    $password = $_POST['password'];
    $courseCode = $_POST['courseCode'];

    // Validate the course code and password (you should replace this with your actual validation logic)
    // For this example, we'll assume successful login
    // If successful, retrieve the course code from the database
    // Replace this logic with your database retrieval code
    $sql = "SELECT course_code, password FROM users WHERE course_code = :course_code";

    try {
        // Create a prepared statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':course_code', $courseCode, PDO::PARAM_STR);

        // Execute the statement
        $stmt->execute();

        // Fetch the course code and hashed password from the database
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($password, $result['password'])) {
            // Login successful, set a session variable to indicate that the user is logged in
            $_SESSION['loggedin'] = true;

            // Store the course code (student ID) in a session variable
            $_SESSION['course_code'] = $result['course_code']; // Use the actual column name from your database

            // Redirect to the dashboard or another page upon successful login
            header('Location: student/dashboard.php');
            exit;
        } else {
            // Login failed, display an error message
            $errorMessage = "Login failed. Please check your credentials.";
        }

        // Close the statement
        $stmt = null;
    } catch (PDOException $e) {
        // Handle database errors here (e.g., log the error, display an error message)
        $errorMessage = "Database error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Include Bootstrap CSS from a CDN or your project's local files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .navbar.bg-skyblue {
            background-color: skyblue;
        }

        /* Styling for the title */
        .form-title {
            text-align: center;
            text-decoration: underline;
            color: green; /* Bootstrap primary color */
        }

        /* Error message styling */
        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }

        /* Add margin to the back-to-home link */
        .back-to-home {
            margin-top: 10px;
        }

        /* Sticky footer */
        html, body {
            height: 100%;
        }

        .wrapper {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
        }

        .footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 20px 0;
        }
    </style>
</head>

<body class="wrapper">
    <?php include("header.php"); ?>
    <div class="container">
        <!-- Title with styling -->
        <h1 class="form-title">Student Login</h1>

        <!-- Error message for login failures -->
        <?php if (!empty($errorMessage)) { ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php } ?>

        <div class="row justify-content-center">
            <div class="col-md-4">
                <!-- Login Form -->
                <form action="login.php" method="POST">
                    <!-- Course Code Field -->
                  <!-- Course Code Field -->
<!-- Course Code Field -->
<div class="mb-3">
    <label for="courseCode" class="form-label">Course Code</label>
    <input type="text" class="form-control" id="courseCode" name="courseCode" placeholder="Enter the course_code" required value=>
</div>



                    <!-- Password Field -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <!-- Center align and style the login button -->
                    <div class="center-btn">
                        <button type="submit" class="btn btn-primary login-btn">Login</button>
                    </div>

                    <!-- Add a Register link below the login form -->
                    <div class="center-btn">
                        <p>Don't have an account? <a href="register.php">Register here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Back to Home Link -->
        <div class="back-to-home text-center">
            <a href="student/dashboard.php"></a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>&copy; 2023 e.u. All rights reserved. Transforming Lives through Quality Education</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Include Bootstrap JS and jQuery from a CDN or your project's local files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+OGpamoFVy38MVBnE+I1wojt9z4trjNz7FO1mgF5F5js4me" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>

