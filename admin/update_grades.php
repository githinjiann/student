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
<html>

<head>
    <title>Student Results</title>
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
        <h2>Student Results</h2>
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
                // Fetch student data from the database using PDO
                $sql = "SELECT student_id, units, semester, grades FROM student_courses";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($result) {
                    foreach ($result as $row) {
                        $studentId = $row['student_id'];
                        $unitCode = $row['units'];
                        $semester = $row['semester'];
                        $grades = $row['grades'];

                        // Define a function to get the unit name based on unit code
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
                        $unitName = getUnitName($unitCode, $semester);
                ?>

                        <tr>
                            <td><?= $studentId ?></td>
                            <td><?= $unitCode ?></td>
                            <td><?= $unitName ?></td>
                            <td><?= $semester ?></td>
                            <td>
                                <?= $grades ?>
                            </td>
                            <td>
                                <form method="POST" action="update_grades.php">
                                    <input type="hidden" name="student_id" value="<?= $studentId ?>">
                                    <input type="hidden" name="unit_code" value="<?= $unitCode ?>">
                                    <input type="hidden" name="semester" value="<?= $semester ?>">
                                    <select name="grades">
                                        <option value="A" <?= ($grades === "A") ? "selected" : "" ?>>A</option>
                                        <option value="B" <?= ($grades === "B") ? "selected" : "" ?>>B</option>
                                        <option value="C" <?= ($grades === "C") ? "selected" : "" ?>>C</option>
                                        <option value="D" <?= ($grades === "D") ? "selected" : "" ?>>D</option>
                                        <option value="E" <?= ($grades === "E") ? "selected" : "" ?>>E</option>
                                    </select>
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                        </tr>

                <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Bootstrap JavaScript links here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

