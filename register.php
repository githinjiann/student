<?php
// Include the database connection file
require_once('connect.php');

session_start(); // Start the session


$registrationMessage = ''; // Initialize an empty registration message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the registration form
    $fullName = $_POST['fullName'];
    $course = $_POST['course'];
    $email = $_POST['email'];
    $courseCode = $_POST['code']; // Use the correct field name
    $password = $_POST['password'];

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Store the user data in a session variable
    $_SESSION['user_data'] = [
        'fullName' => $fullName,
        'email' => $email,
        'course' => $course,
        'courseCode' => $courseCode,
    ];
    // SQL query to insert user data into the database
    $sql = "INSERT INTO users (full_name, email, course, course_code, password) VALUES (:fullName, :email, :course, :courseCode, :hashedPassword)";

    try {
        // Create a prepared statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':fullName', $fullName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':course', $course, PDO::PARAM_STR);
        $stmt->bindParam(':courseCode', $courseCode, PDO::PARAM_STR); // Use the correct parameter name
        $stmt->bindParam(':hashedPassword', $hashedPassword, PDO::PARAM_STR);

        // Execute the statement
        $stmt->execute();

        // Close the statement
        $stmt = null;

        // Redirect to the login page immediately after successful registration
        header('Location: login.php');
        exit();
    } catch (PDOException $e) {
        // Handle database errors here (e.g., log the error, display an error message)
        $registrationMessage = '<div class="alert alert-danger">Database error: ' . $e->getMessage() . '</div>';
    }
}

// Close the database connection (optional if not needed elsewhere)
$conn = null;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Include Bootstrap CSS from a CDN or your project's local files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
 <style>
    .navbar.bg-skyblue {
        background-color: skyblue;
    }

    /* Styling for the title */
    .form-title {
        text-align: center;
        color: green;
        font-weight: bold;
        margin-top: 0; /* Remove the margin-top */
    }

    .custom-bg {
        background-color: #f0f0f0;
    }

    .registration-details {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
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


<nav class="navbar navbar-expand-lg navbar-light bg-skyblue">
        <div class="container">
            <a class="navbar-brand" href="#" style="font-weight: bold; font-family: georgia, sans-serif;">EGERTON UNIVERSITY</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <!-- Modify the "Login" link to have an ID for easy access -->
                    <li class="nav-item">
                        <a class="nav-link" href="login.php" id="login-link"> Student Login</a>
                   
                   

                </ul>
            </div>
        </div>
    </nav>


<body class="wrapper">
    <div class="container mt-5">
        <h1 class="form-title">Student Registration Form</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form id="registrationForm" action="register.php" method="POST" class="custom-bg registration-details">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" required>
                    </div>
                    <div class="mb-3">
                        <label for "email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Course</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="course" id="bachelor_it" value="bachelor_it">
                            <label class="form-check-label" for="bachelor_it">
                                Bachelors in Information Technology
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Course Code</label>
                        <input type="text" class="form-control" id="code" name="code" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>
            </div>
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

    <!-- Bootstrap Modal for the password mismatch error message -->
    <div class="modal fade" id="passwordMismatchModal" tabindex="-1" aria-labelledby="passwordMismatchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordMismatchModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Passwords do not match. Please go back and try again.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery from a CDN or your project's local files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // JavaScript to generate the student code based on the selected course
        document.querySelectorAll('input[name="course"]').forEach(function(radio) {
            radio.addEventListener("change", function() {
                const course = this.value;
                let code = "";
                const uniqueCode = Math.floor(Math.random() * 9000) + 1000;
                const currentYear = new Date().getFullYear();
                code += "B144/" + uniqueCode + "/" + currentYear;
                if (course === "bachelor_it") {
                    code = "B141/" + uniqueCode + "/" + currentYear;
                }
                document.getElementById("code").value = code;
            });
        });
    </script>
</body>

</html>     