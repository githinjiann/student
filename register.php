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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        /* Custom styles for the registration form */
        .container {
            text-align: center; /* Center align content in the container */
            max-width: 600px; /* Adjust the maximum width as needed */
            background-color: skyblue; /* Background color for the container */
            padding: 30px;
            border-radius: 10px; /* Add rounded corners to the container */
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2); /* Add a subtle shadow */
        }

        .form-title {
            color: #333; /* Title text color */
            text-decoration: underline; /* Underline the title */
            font-family: Georgia, sans-serif; /* Set font type to Georgia */
            text-transform: capitalize; /* Capitalize the title */
        }

        .form-label {
            font-weight: bold; /* Bold labels */
        }

        .btn-primary {
            background-color: #007bff; /* Primary button color */
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Button color on hover */
            border-color: #0056b3;
        }

        /* Custom styles for the registration details */
        .registration-details {
            background-color: #fff; /* Background color for the details section */
            border-radius: 10px; /* Add rounded corners to the details section */
            padding: 20px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2); /* Add a subtle shadow */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Title with styling -->
        <h1 class="form-title">Student Application Form</h1>

        <!-- Registration Failure Message -->
        <?php echo $registrationMessage; ?>

        <form id="registrationForm" action="register.php" method="POST">
            <!-- Full Name Field -->
            <div class="mb-3">
                <label for="fullName" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="fullName" name="fullName" required>
            </div>

            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <!-- Course Field (Radio Buttons) -->
            <div class="mb-3">
                <label class="form-label">Course</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="course" id="bachelor_it" value="bachelor_it">
                    <label class="form-check-label" for="bachelor_it">
                        Bachelors in Information Technology
                    </label>
                </div>
               

            <!-- Code Field (Generated based on Course) -->
            <div class="mb-3">
                <label for="code" class="form-label">Course Code</label>
                <input type="text" class="form-control" id="code" name="code" readonly>
            </div>

            <!-- Password Field -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            

            <!-- Register Button -->
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
    </div>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+OGpamoFVy38MVBnE+I1wojt9z4trjNz7FO1mgF5F5js4me" crossorigin="anonymous"></script>
    <script>
        // JavaScript to generate the student code based on the selected course
        document.querySelectorAll('input[name="course"]').forEach(function(radio) {
            radio.addEventListener("change", function() {
                const course = this.value;
                let code = "";

                // Generate a random unique code (e.g., between 1000 and 9999)
                const uniqueCode = Math.floor(Math.random() * 9000) + 1000;

                // Set the common prefix
                code += "B144/" + uniqueCode + "/";

                // Get the current year
                const currentYear = new Date().getFullYear();

                // Append the current year
                code += currentYear;

                // If it's the IT course, change the prefix to "B141"
                if (course === "bachelor_it") {
                    code = "B141/" + uniqueCode + "/" + currentYear;
                }

                document.getElementById("code").value = code;
            });
        });

        // JavaScript for form validation and submission (if needed)
    </script>
</body>
</html>
