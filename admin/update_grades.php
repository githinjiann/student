<?php
// Start the session
session_start();

// Include your database connection
require_once("../connect.php");

// Define units for Semester 1
$unitsForSemester1 = [
    'SIT 215' => 'Computer Graphics',
    'SIT 212' => 'Cloud Computing',
    'SIT 213' => 'Mobile Computing',
    'SIT 214' => 'Database Management',
];

// Define units for Semester 2 (same as in registrations.php)
$unitsForSemester2 = [
    'SIT 220' => 'Group Project',
    'SIT 221' => 'IoT',
    'SIT 222' => 'Computer Project',
    'SIT 223' => 'Software Quality Assurance',
];

// Define the getUnitName function outside the loop
function getUnitName($unitCode, $semester)
{
    global $unitsForSemester1, $unitsForSemester2;
    if ($semester === 'Semester 1' && array_key_exists($unitCode, $unitsForSemester1)) {
        return $unitsForSemester1[$unitCode];
    } elseif ($semester === 'Semester 2' && array_key_exists($unitCode, $unitsForSemester2)) {
        return $unitsForSemester2[$unitCode];
    } else {
        return 'Unknown Unit';
    }
}

// Check if the form is submitted

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the submitted form
    $studentId = $_POST['student_id'];
    $semester = $_POST['semester'];
    $unitCode = $_POST['unit_code'];
    $newGrades = $_POST['grades'];

    try {
        // Prepare the SQL statement to update grades
        $sql = "UPDATE student_courses SET grades = :grades WHERE student_id = :student_id AND units = :unit_code AND semester = :semester";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':grades', $newGrades);
        $stmt->bindParam(':student_id', $studentId);
        $stmt->bindParam(':unit_code', $unitCode);
        $stmt->bindParam(':semester', $semester);

        // Execute the statement
        if ($stmt->execute()) {
            // Grades updated successfully
            // Store the updated grades in a session variable
            $_SESSION['updated_grades'] = $newGrades;
            // Redirect back to the student information page
            header("Location: update_grades.php");
            exit;
        } else {
            // Handle the case where the update fails
            echo "Error updating grades";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Results</title>
    <!-- Add Bootstrap CSS links here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar.bg-skyblue {
            background-color: skyblue;
        }

        /* Custom style for the navbar and logo */
        .navbar {
            background-color: green;
        }

        .navbar img {
            padding: 10px;
            background-color: #4CAF50; /* Green background for the logo */
            border-radius: 50%; /* Make the logo area a circle */
        }

        /* Custom class to set the navbar width */
        .custom-navbar {
            margin: auto;
            max-width: 400px; /* Adjust the max-width as needed */
        }

        /* Apply margin-top to the entire page content */
        body {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="image/logo.jpg" alt="Your Logo" class="img-fluid logo-img">
            </a>
        </div>
    </nav>

    <div class="container mt-3">
        <?php
        // Fetch student data from the database using PDO
        $sql = "SELECT student_id, semester, units, grades FROM student_courses";
        $stmt = $conn->prepare($sql);

        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                $currentStudent = null;

                foreach ($result as $row) {
                    $studentId = $row['student_id'];
                    $semester = $row['semester'];
                    $grades = $row['grades'];
                    $unitCode = $row['units'];
                    $unitName = getUnitName($unitCode, $semester);

                    // Display student details only when a new student is encountered
                    if ($studentId !== $currentStudent) {
                        if ($currentStudent !== null) {
                            echo "</tbody>";
                            echo "</table>";
                        }
                        echo "<h2>Student Details</h2>";
                        echo "<p>Student ID: $studentId</p>";
                        echo "<p>Semester: $semester</p>";
                        echo "<h2>Registered Units</h2>";
                        echo "<div class='table-responsive'>";
                        echo "<table class='table'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Unit Code</th>";
                        echo "<th>Unit Name</th>";
                        echo "<th>Grades</th>";
                        echo "<th>Action</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        $currentStudent = $studentId;
                    }

                    // Display unit information
                    echo "<tr>";
                    echo "<td>$unitCode</td>";
                    echo "<td>$unitName</td>";
                    echo "<td>$grades</td>";
                    echo "<td>";
                    echo "<form method='POST' action='update_grades.php'>";
                    echo "<input type='hidden' name='student_id' value='$studentId'>";
                    echo "<input type='hidden' name='semester' value='$semester'>";
                    echo "<input type='hidden' name='unit_code' value='$unitCode'>";
                    echo "<select name='grades' class='form-select'>";
                    echo "<option value='A' " . (($grades === "A") ? "selected" : "") . ">A</option>";
                    echo "<option value='B' " . (($grades === "B") ? "selected" : "") . ">B</option>";
                    echo "<option value='C' " . (($grades === "C") ? "selected" : "") . ">C</option>";
                    echo "<option value='D' " . (($grades === "D") ? "selected" : "") . ">D</option>";
                    echo "<option value='E' " . (($grades === "E") ? "selected" : "") . ">E</option>";
                    echo "</select>";
                    echo "<button type='submit' class='btn btn-primary'>Update</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            } else {
                echo "<p>No records found</p>";
            }
        } else {
            // Handle the query execution error
            echo "Error executing the query.";
        }
        ?>
    </div>

    <!-- Add Bootstrap JavaScript links here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
