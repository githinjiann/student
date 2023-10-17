<?php
// Start the session
require_once("../connect.php");
session_start();

$unitsForSemester1 = [
    'SIT 215' => 'Computer',
    'SIT 212' => 'Cloud Computing',
    'SIT 213' => 'Mobile Computing',
    'SIT 214' => 'Database Management',
];

// Define units for Semester 2 (same as in registrations.php)
$unitsForSemester2 = [
    'SIT 220' => 'Group Project',
    'SIT 221' => 'IoT',
    'SIT 222' => 'Computer Project',
    'SIT 223' => 'Software Quality Assuarance',
];

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
            header("Location: student_info.php");
            exit;
        } else {
            // Handle the case where the update fails
            echo "Error updating grades";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Handle cases where the form was not submitted

}
?>



<!DOCTYPE html>
<html>

<head>
    <title>Student Information</title>
    <!-- Add Bootstrap CSS links here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
     <style>
        .navbar.bg-skyblue {
            background-color: skyblue;
        }
        </style>
</head>

<body>
     <?php include("header.php"); ?>
    <div class="container mt-3">
        <h2>Student Information</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Unit Code</th>
                    <th>Unit Name</th>
                    <th>Semester</th>
                    <th>Grades</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Connect to your database here
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "student";

                // Create a connection
                $conn = new mysqli($servername, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query to retrieve student registration information from the student_courses table
                $sql = "SELECT student_id, units, semester, grades FROM student_courses";

                $result = $conn->query($sql);

                if (!$result) {
                    // Handle SQL errors
                    die("SQL Error: " . $conn->error);
                }

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $unitName = '';
                        // Check if the unit code is in Semester 1 or Semester 2
                        if (array_key_exists($row["units"], $unitsForSemester1) && $row["semester"] == 'Semester 1') {
                            $unitName = $unitsForSemester1[$row["units"]];
                        } elseif (array_key_exists($row["units"], $unitsForSemester2) && $row["semester"] == 'Semester 2') {
                            $unitName = $unitsForSemester2[$row["units"]];
                        }

                        if (!empty($unitName)) {
                            echo "<tr>";
                            echo "<td>" . $row["student_id"] . "</td>";
                            echo "<td>" . $row["units"] . "</td>";
                            echo "<td>" . $unitName . "</td>";
                            echo "<td>" . $row["semester"] . "</td>";
                            echo "<td>" . $row["grades"] . "</td>";
                            echo '<td>
                                    <form method="POST" action="update_grades.php">
                                        <input type="hidden" name="student_id" value="' . $row["student_id"] . '">
                                        <input type="hidden" name="unit_code" value="' . $row["units"] . '">
                                        <input type="hidden" name="semester" value="' . $row["semester"] . '">
                                        <select name="grades">
                                            <option value="A" ' . ($row["grades"] == "A" ? "selected" : "") . '>A</option>
                                            <option value="B" ' . ($row["grades"] == "B" ? "selected" : "") . '>B</option>
                                            <option value="C" ' . ($row["grades"] == "C" ? "selected" : "") . '>C</option>
                                            <option value="D" ' . ($row["grades"] == "D" ? "selected" : "") . '>D</option>
                                            <option value="E" ' . ($row["grades"] == "E" ? "selected" : "") . '>E</option>
                                        </select>
                                        <button type="submit">Update</button>
                                    </form>
                                </td>';
                            echo "</tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found</td></tr>";
                }

                // Close the database connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Bootstrap JavaScript links here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>