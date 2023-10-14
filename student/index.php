<?php
// Database configuration
require_once("../connect.php");

// Start a session to manage user login state
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        echo 'Unauthorized access';
        exit;
    }

    // Get the student ID (course code) from the session
    $studentId = $_SESSION['course_code'];

    // Check if the registration data is provided
    if (isset($_POST['units']) && is_array($_POST['units'])) {
        // Get the selected units from the POST data
        $selectedUnits = $_POST['units'];

        // Create a PDO connection
        

        try {
            // Insert the selected units into the database
        
            $insertStmt = $conn->prepare($insertSql);


            // Return a success message
            // You can add a success message here if needed

        } catch (PDOException $e) {
            echo 'Registration failed: ' . $e->getMessage();
        } finally {
            // Close the database connection
            $conn = null;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <!-- Add Bootstrap 4 CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <a class="navbar-brand" href="#" id="studentPortalLink">Student Dashboard</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav" id="navbarNavItems">
            <li class="nav-item">
                <!-- Add an onclick event to load the unit registration form -->
                <a class="nav-link font-weight-bold" href="#" id="unitRegistrationLink" onclick="loadUnitRegistrationForm()">Unit Registration</a>
            </li>
            <li class="nav-item">
                <!-- Link to the "Results" page -->
                <a class="nav-link font-weight-bold" href="results.php">Results</a>
            </li>
           

        </ul>
    </div>
</nav>

<script>
// JavaScript function to navigate back to the dashboard page
function navigateBackToDashboard() {
    // Use JavaScript to navigate back to the dashboard page
    window.location.href = 'dashboard.php';
}
</script>

<div class="container mt-5">
    <div id="content">
        <!-- Content will be dynamically loaded here -->
    </div>

    <!-- Add this element for the success message -->
    <div id="successMessage" class="alert alert-success" style="display: none;"></div>
</div>

<script>
function loadUnitRegistrationForm() {
    // Send an AJAX request to fetch the unit registration form
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Replace the content of the "content" div with the unit registration form
            document.getElementById('content').innerHTML = xhr.responseText;
        }
    };
    xhr.open('GET', 'registrations.php', true);
    xhr.send();
}
</script>

</body>
</html>
