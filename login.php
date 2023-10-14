<?php
// Include the database connection file (connect.php)
require_once('connect.php');

// Start a session to manage user login state
session_start();

// Initialize variables
$courseCode = "";
$password = "";

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
            // Login failed, display an error message or redirect to an error page
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

<!-- Rest of your HTML code for the login page -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Include Bootstrap CSS from a CDN or your project's local files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        /* Custom background and text color */
        body {
            background-color: #f0f0f0; /* Custom background color */
            color: #333; /* Custom text color */
        }

        /* Additional CSS for styling */
        .container {
            max-width: 500px;
            margin-top: 50px;
            background-color: #b3ffb3; /* Background color for the container */
            padding: 20px;
            border-radius: 10px; /* Add rounded corners to the container */
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2); /* Add a subtle shadow */
        }

        /* Styling for the title */
        .form-title {
            text-align: center;
            text-decoration: underline;
            color: green; /* Bootstrap primary color */
        }

        /* Center align the button */
        .center-btn {
            text-align: center;
        }

        /* Style for the login button */
        .login-btn {
            background-color: green; /* Custom button color */
            border-color: green; /* Custom button border color */
            color: white; /* Custom button text color */
            padding: 10px 20px; /* Custom button padding */
            border-radius: 5px; /* Add rounded corners to the button */
        }

        /* Style for the login button on hover */
        .login-btn:hover {
            background-color: darkgreen; /* Custom button color on hover */
            border-color: darkgreen; /* Custom button border color on hover */
        }

        /* Error message styling */
        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Title with styling -->
        <h1 class="form-title">Student Login</h1>

        <!-- Error message for login failures -->
        <?php if (isset($errorMessage)) { ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php } ?>

        <!-- Login Form -->
        <form action="login.php" method="POST">
            <!-- Course Code Field -->
            <div class="mb-3">
                <label for="courseCode" class="form-label">Course Code</label>
                <input type="text" class="form-control" id="courseCode" name="courseCode" placeholder="Enter or paste your course code" required>
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
        </form>
    </div>

    <!-- Include Bootstrap JS and jQuery from a CDN or your project's local files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+OGpamoFVy38MVBnE+I1wojt9z4trjNz7FO1mgF5F5js4me" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
