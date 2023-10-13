<?php
// Database configuration
$dbConfig = [
    'host' => 'localhost',
    'dbname' => 'student', // Replace with your database name
    'user' => 'root',      // Replace with your database username
    'password' => '',      // Replace with your database password
];

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
        $conn = new PDO("mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}", $dbConfig['user'], $dbConfig['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable error reporting

        try {
            // Insert the selected units into the database
            $insertSql = "INSERT INTO registrations (student_id, unit_code, semester, status) VALUES (:student_id, :unit_code, :semester, 'Pending')";
            $insertStmt = $conn->prepare($insertSql);

            foreach ($selectedUnits as $unitCode) {
                // Bind parameters and execute the statement
                $insertStmt->bindParam(':student_id', $studentId, PDO::PARAM_STR);
                $insertStmt->bindParam(':unit_code', $unitCode, PDO::PARAM_STR);
                // You may want to get the semester value from the form as well.
                // For this example, I'm assuming the semester is hardcoded as 'Semester 1'.
                $semester = 'Semester 1';
                $insertStmt->bindParam(':semester', $semester, PDO::PARAM_STR);
                $insertStmt->execute();
            }

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
            <li class="nav-item">
    <a class="nav-link font-weight-bold" href="logout.php">Logout</a>
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
