<?php
use PHPMailer\PHPMailer\PHPMailer;

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

    // Validate full name (at least two names)
    $nameParts = explode(' ', $fullName);
    if (count($nameParts) < 2) {
        $registrationMessage = '<div class="alert alert-danger">Please enter at least two names for the full name.</div>';
        // You might want to redirect the user back to the registration form or handle this in JavaScript
    } else {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if the email is already registered
        $checkEmailSql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $checkEmailStmt = $conn->prepare($checkEmailSql);
        $checkEmailStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $checkEmailStmt->execute();
        $emailCount = $checkEmailStmt->fetchColumn();

        if ($emailCount > 0) {
            $registrationMessage = '<div class="alert alert-danger">This email is already registered. Please use a different email.</div>';
            // You might want to redirect the user back to the registration form or handle this in JavaScript
        } else {
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

                // Send a welcome email using PHPMailer
                require './PHPMailer/src/PHPMailer.php';
                require './PHPMailer/src/SMTP.php';
                require './PHPMailer/src/Exception.php';

                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'annndutaw2020@gmail.com';
                    $mail->Password   = 'iqpx finz mfqb cpzp';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;

                    $mail->setFrom('annndutaw2020@gmail.com', 'Egerton University');
                    $mail->addAddress($email); // Use the email provided during registration

                    $mail->isHTML(true);
                    $mail->Subject = 'Welcome to Egerton University';
                    $mail->Body    = 'Dear ' . $fullName . ',<br> Welcome to Egerton University. Your course code is: ' . $courseCode;
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();

                    // Set a session variable indicating successful registration
                    $_SESSION['registration_success'] = true;
            
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } catch (PDOException $e) {
                // Handle database errors here (e.g., log the error, display an error message)
                $registrationMessage = '<div class="alert alert-danger">Database error: ' . $e->getMessage() . '</div>';
            }
        }
    }
}

// Check if the registration success session variable is set
if (isset($_SESSION['registration_success']) && $_SESSION['registration_success'] === true) {
    // Display the success message
    $registrationMessage = '<div class="alert alert-success">Registration successful! Please check your email for the course code.</div>';

    // Clear the session variable to avoid showing the message on page refresh
    unset($_SESSION['registration_success']);
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
            <a class="navbar-brand" href="#" style="font-weight: bold; font-family: georgia, sans-serif;">UNIVERSITY OF EMBU</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                
                    <li class="nav-item">
                        <a class="nav-link" href="login.php" id="login-link"> Student Login</a>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">appy now </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

<body class="wrapper">



    <div class="container mt-5">
        <h1 class="form-title">Student Registration Form</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Display the registration success message -->
                <?php echo $registrationMessage; ?>

                <form id="registrationForm" action="register.php" method="POST" class="custom-bg registration-details">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
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
                    <button type="submit" class="btn btn-primary btn-block" onclick="showSuccessModal()">Register</button>
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

    <!-- Registration Success Modal -->
    <div class="modal fade" id="registrationSuccessModal" tabindex="-1" aria-labelledby="registrationSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registrationSuccessModalLabel">Registration Successful</h5>
                    
                </div>
                <div class="modal-body">
                    Registration successful! Please check your email for the course code.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="redirectToLogin()">OK</button>
                </div>
            </div>
        </div>
    </div>


    

    <!-- Include Bootstrap JS and jQuery from a CDN or your project's local files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- ... Previous HTML code ... -->

<!-- JavaScript to show the success modal immediately after registration -->
<!-- JavaScript to show the success modal and validate form before submission -->
<!-- ... Previous HTML code ... -->

<!-- JavaScript to show the success modal and validate form before submission -->
<!-- JavaScript to show the success modal and validate form before submission -->
<script>
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


    // Function to show the success modal and validate form before submission
    function showSuccessModal() {
        // Validate form before submission
        const fullName = document.getElementById("fullName").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();

        if (fullName === "" || email === "" || password === "") {
            alert("Please fill in all the required fields.");
            return false; // Prevent form submission
        }

        // Show the modal
        $('#registrationSuccessModal').modal('show');
    }

    // Handle the modal's "hidden" event and redirect to the login page
    $('#registrationSuccessModal').on('hidden.bs.modal', function (e) {
        redirectToLogin();  // Redirect after the modal is fully hidden
    });

    // Function to redirect to the login page
    function redirectToLogin() {
        window.location.href = 'login.php';
    }
</script>

<!-- ... Remaining HTML code ... -->


</body>
</html>
