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
    'SIT 215' => 'Computer',
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
                $stmt = $conn->prepare("INSERT INTO student_courses (student_id, semester, units) VALUES (:student_id, :semester, :unitCode)");

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


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Registration</title>
    <!-- Add Bootstrap 4 CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar.bg-skyblue {
            background-color: skyblue;
        }

        /* Custom CSS for table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f2f2f2;
            /* Background color */
            font-family: Arial, sans-serif;
            /* Font */
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            /* Table cell borders */
        }

        th {
            background-color: blue;
            /* Header background color */
            color: white;
            /* Header text color */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
            /* Even row background color */
        }

        tr:nth-child(odd) {
            background-color: #ffffff;
            /* Odd row background color */
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

        <h2>Unit Registration</h2>
        <form method="POST" action="registrations.php" id="registrationForm" onsubmit="return validateForm();">
            <!-- Semester selection -->
            <div class="form-group">
                <select class="form-control" id="semester" name="semester">
                    <option value="">Select the semester please</option>
                    <option value="Semester 1">Semester 1</option>
                    <option value="Semester 2">Semester 2</option>
                </select>
            </div>

            <!-- Unit selection (display Semester-specific units) -->
            <div class="row" id="unitSelection" style="display: none;">
                <table>
                    <tr>
                        <th>Unit Code</th>
                        <th>Unit Name</th>
                        <th>Register</th>
                    </tr>
                    <!-- Units for Semester 1 and Semester 2 will be dynamically populated here -->
                </table>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- JavaScript to show the table when a semester is selected -->
    <script>
        const form = document.getElementById('registrationForm');
        const semesterSelect = document.getElementById('semester');
        const unitSelection = document.getElementById('unitSelection');

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

            // Determine which units to display based on the selected semester
            const unitsToDisplay = (selectedSemester === 'Semester 1') ? <?php echo json_encode($unitsForSemester1); ?> : <?php echo json_encode($unitsForSemester2); ?>;

            // Build the table with the selected units
            const table = document.createElement('table');
            table.style.width = '80%';
            table.style.borderCollapse = 'collapse';
            table.style.backgroundColor = '#f2f2f2';
            table.style.fontFamily = 'Arial, sans-serif';

            const headerRow = document.createElement('tr');
            const header1 = document.createElement('th');
            header1.textContent = 'Unit Code';
            const header2 = document.createElement('th');
            header2.textContent = 'Unit Name';
            const header3 = document.createElement('th');
            header3.textContent = 'Register';
            headerRow.appendChild(header1);
            headerRow.appendChild(header2);
            headerRow.appendChild(header3);
            table.appendChild(headerRow);

            for (const unitCode in unitsToDisplay) {
                const unitName = unitsToDisplay[unitCode];
                const row = document.createElement('tr');
                const cell1 = document.createElement('td');
                cell1.textContent = unitCode;
                const cell2 = document.createElement('td');
                cell2.textContent = unitName;
                const cell3 = document.createElement('td');
                const checkbox = document.createElement('input');
                checkbox.className = 'form-check-input';
                checkbox.type = 'checkbox';
                checkbox.name = 'units[]';
                checkbox.value = unitCode;
                cell3.appendChild(checkbox);

                row.appendChild(cell1);
                row.appendChild(cell2);
                row.appendChild(cell3);

                table.appendChild(row);
            }

            // Remove the existing table (if any) and append the updated one
            while (unitSelection.firstChild) {
                unitSelection.removeChild(unitSelection.firstChild);
            }
            unitSelection.appendChild(table);

            // Show the table when the semester is selected
            unitSelection.style.display = (selectedSemester !== "") ? 'block' : 'none';
        }

        // Initially hide the table
        unitSelection.style.display = 'none';


        // Call updateUnits when the page loads
        window.addEventListener('load', updateUnits);

        semesterSelect.addEventListener('change', updateUnits);
    </script>
</body>

</html>
