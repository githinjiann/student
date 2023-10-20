<?php
// Include your database configuration here
require_once("../connect.php");

// Start a session to manage user login state
session_start();

// Check if the user is logged in
if (!isset($_SESSION['course_code']) || empty($_SESSION['course_code'])) {
    echo 'Course code is not set. Please check your login process.';
    exit;
}

// Get the student ID (course code) from the session
$studentId = $_SESSION['course_code'];

// Define units for Semester 1
$unitsForSemester1 = [
    'SIT 215' => 'Computer Graphics',
    'SIT 212' => 'Cloud Computing',
    'SIT 213' => 'Mobile Computing',
    'SIT 214' => 'Database Management',
];

// Define units for Semester 2
$unitsForSemester2 = [
    'SIT 220' => 'Group Project',
    'SIT 221' => 'IoT',
    'SIT 222' => 'Computer Project',
    'SIT 223' => 'Software Quality Assurance',
];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the registration data is provided
    if (isset($_POST['units']) && is_array($_POST['units']) && isset($_POST['semester'])) {
        $studentId = $_SESSION['course_code']; // Get the student ID from the session
        $semester = $_POST['semester']; // Get the selected semester
        $selectedUnits = $_POST['units']; // Get the selected units as an array

        if (count($selectedUnits) !== count($unitsForSemester1) && $semester === 'Semester 1') {
            // Display a failure message for incomplete selection
            echo '<script>alert("Please select all units for Semester 1.");</script>';
        } elseif (count($selectedUnits) !== count($unitsForSemester2) && $semester === 'Semester 2') {
            // Display a failure message for incomplete selection
            echo '<script>alert("Please select all units for Semester 2.");</script>';
        } else {
            // Include your database connection code here
            try {
                $stmt = $conn->prepare("INSERT INTO student_courses (student_id, semester, units, grades) VALUES (:student_id, :semester, :unitCode, null)");

                // Bind parameters outside the loop
                $stmt->bindParam(':student_id', $studentId, PDO::PARAM_STR);
                $stmt->bindParam(':semester', $semester, PDO::PARAM_STR);

                foreach ($selectedUnits as $unitCode) {
                    // Bind the unitCode for each unit
                    $stmt->bindParam(':unitCode', $unitCode, PDO::PARAM_STR);
                    $stmt->execute();
                }

                // Set a session variable to indicate successful registration
                $_SESSION['registration_success'] = true;

                // Redirect to the dashboard page after successful registration
                echo '<script>alert("Unit registration is successful!"); window.location.href = "dashboard.php";</script>';
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}
?>
<!-- Rest of your HTML and JavaScript -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Registration</title>
    <!-- Add Bootstrap 4 CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin: 0 auto; /* Center the container horizontally */
        }

        .navbar.bg-skyblue {
            background-color: skyblue;
        }

        .form-card {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
        }

        /* Custom CSS for the table */
        .custom-table {
            margin: 0 auto;
            max-width: 100%; /* Adjust the max-width as needed */
        }

        .custom-table th {
            text-align: center; /* Center align the table headers */
        }

        .custom-table td {
            text-align: center; /* Center align the table cells */
        }

        /* Custom CSS for the form elements */
        .custom-form {
            max-width: 70%; /* Adjust the max-width as needed */
            margin: 0 auto;
            padding: 5px;
        }

        /* Custom CSS for the title */
        .custom-title {
            text-align: center;
            font-weight: bold;
            color: skyblue;
            
        }
    </style>
</head>
<body>
    
    <div class="container mt-5">
        <!-- Success message popup initially hidden -->
        <div class="alert alert-success" id="successMessage" style="display: none;">
            Registration successful. You will now be redirected to the dashboard.
        </div>
        <!-- Error message div for displaying validation errors -->
        <div class="alert alert-danger" id="errorMessage" style="display: none;"></div>
        <h2 class="custom-title">Unit Registration</h2>
        <form method="POST" action="registrations.php" id="registrationForm" onsubmit="return validateForm();" class="custom-form">
            <!-- Semester selection -->
            <div class="form-group">
                <label for="semester">Select Semester</label>
                <select class="form-control" id="semester" name="semester" onchange="updateUnits">
                    
                    <option value="Semester 1">Semester 1</option>
                    <option value="Semester 2">Semester 2</option>
                </select>
            </div>
            <!-- Unit selection (display Semester-specific units) -->
            <div class="form-group" id="unitSelection" style="display: none;">
                
                <div class="table-responsive custom-table">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Unit Code</th>
                                <th>Unit Name</th>
                                <th>Register</th>
                            </tr>
                        </thead>
                        <tbody id="unitTableBody">
                            <!-- Units for Semester 1 and Semester 2 will be dynamically populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <button type="submit" class="btn btn-primary d-block mx-auto mt-3">Submit</button>
        </form>
    </div>

    
    <!-- JavaScript to show the unit selection when a semester is chosen -->
    <script>
        const form = document.getElementById('registrationForm');
        const semesterSelect = document.getElementById('semester');
        const unitSelection = document.getElementById('unitSelection');
        const unitTableBody = document.getElementById('unitTableBody');

        // Function to validate the form before submission
        function validateForm() {
            const selectedSemester = semesterSelect.value;
            const selectedUnits = document.querySelectorAll('input[name="units[]"]:checked');

            if (selectedSemester === "") {
                alert('Please select the semester before submitting the form.');
                return false;
            } else if (selectedUnits.length === 0) {
                alert('Please select all units before submitting the form.');
                return false;
            }

            return true; // Form is valid
        }

        // Function to update the displayed units based on the selected semester
        function updateUnits() {
            const selectedSemester = semesterSelect.value;
            const unitsToDisplay = (selectedSemester === 'Semester 1') ? <?php echo json_encode($unitsForSemester1); ?> : <?php echo json_encode($unitsForSemester2); ?>;
            
            // Clear the table body
            unitTableBody.innerHTML = '';

            // Create and append rows for unit selection
            for (const unitCode in unitsToDisplay) {
                const unitName = unitsToDisplay[unitCode];
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${unitCode}</td>
                    <td>${unitName}</td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="units[]" value="${unitCode}">
                        </div>
                    </td>
                `;
                unitTableBody.appendChild(row);
            }

            // Show the unit selection when the semester is selected
            unitSelection.style.display = (selectedSemester !== "") ? 'block' : 'none';
        }

        // Initially hide the unit selection
        unitSelection.style.display = 'none';

        // Call updateUnits when the page loads
        window.addEventListener('load', updateUnits);

        semesterSelect.addEventListener('change', updateUnits);
    </script>
</body>
</html>
