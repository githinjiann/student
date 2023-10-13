<?php
// Include the database connection file (connect.php)
$dbConfig = [
    'host' => 'localhost',
    'dbname' => 'student',
    'user' => 'root',
    'password' => '',
];
// Include your database connection script here

// Start a session to manage user login state
session_start();

// ... (Your existing code for form processing)

// Redirect to dashboard.php after successful form submission
header('Location: student/dashboard.php');
exit; // Ensure that no further code is executed after the redirection


// Initialize variables
$courseCode = "";
$email = "";

// Check if the admission form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the admission form
    $courseCode = $_POST['program'];
    $email = $_POST['email'];

    // Check if the submitted values match the registered course or email
    // You should replace this with your actual validation logic
    $sql = "SELECT course_code, email FROM users WHERE course_code = :course_code AND email = :email";

    try {
        // Create a prepared statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':course_code', $courseCode, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        // Execute the statement
        $stmt->execute();

        // Fetch the matching record from the database
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Matching record found, proceed with admission
            $_SESSION['loggedin'] = true;
            $_SESSION['course_code'] = $courseCode;
            header('Location: student/dashboard.php');
            exit;
        } else {
            // No matching record found, display an error message
            echo '<script>alert("Course or email does not match our records. Please check your credentials.");</script>';
        }

        // Close the statement
        $stmt = null;
    } catch (PDOException $e) {
        // Handle database errors here (e.g., log the error, display an error message)
        echo '<script>alert("Database error: ' . $e->getMessage() . '");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom background color and font styling */
        body {
            background-color: #f2f2f2; /* Light gray background */
            font-family: georgia, sans-serif; /* Custom font family */
        }

        /* Styling for the title */
        .form-title {
            text-align: center;
            font-family: algerian, sans-serif;
            text-decoration: underline;
            color: #007bff; /* Bootstrap primary color */
            font-size: 40px; /* Custom font size */
            text-transform: Capitalize; /* Capitalize the title text */
        }

        /* Additional CSS for styling */
        .container {
            max-width: 650px; /* Increase the width of the container */
            margin: 50px auto; /* Center align the container */
            background-color: skyblue; /* White background for the container */
            padding: 20px;
            border-radius: 20px; /* Add rounded corners to the container */
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2); /* Add a subtle shadow */
        }

        /* Style for the program selection */
        .program-select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc; /* Custom border color */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Title with styling -->
        <h1 class="form-title">admission form</h1>
        
        <!-- Admission Form -->
        <form action="process_admission.php" method="POST">
            <!-- Full Name Field -->
            <div class="form-group">
                <label for="fullName">Full Name:</label>
                <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter your full name" required>
            </div>
            
            <!-- Admission Number Field -->
            <div class="form-group">
                <label for="admissionNumber">Admission Number:</label>
                <input type="text" class="form-control" id="admissionNumber" name="admissionNumber" placeholder="Enter your admission number" required>
            </div>
            
            <!-- Program Selection Field -->
            <div class="form-group">
                <label for="program">Program Pursuing:</label>
                <select class="program-select" id="program" name="program" required>
                    <option value="" disabled selected>Select your program</option>
                    <option value="IT">Bachelors in Information Technology</option>
                    
                </select>
            </div>
            
            <!-- Email Field -->
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            
            <!-- Submit Button -->
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
