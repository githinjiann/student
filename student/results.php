<?php
// Start the session
require_once('../connect.php');
session_start();


// Check if the user is logged in (authenticated)
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Retrieve the student ID from the session
    $studentId = $_SESSION['course_code'];

    // Include your database configuration here



    // Create a PDO database connection


    // Initialize selected semester
    $selectedSemester = '';

    // Check if a semester is selected
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['semester'])) {
        $selectedSemester = $_POST['semester'];
    }
} else {
    // If the user is not logged in, you can redirect them to a login page
    header('Location: login.php'); // Redirect to the login page
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <!-- Add Bootstrap 4 CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar.bg-skyblue {
            background-color: skyblue;
        }

        /* Custom CSS for table styling */
        table {
            width: 80%;
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
<?php include("header.php"); ?>
    <div class="container mt-5">
        <h2>Results</h2>

        <!-- Form to select a semester -->
        <form method="POST" action="results.php">
            <div class="form-group">
                <label for="semester">Select Semester:</label>
                <select class="form-control" id="semester" name="semester">
                    <option value="">Select the semester</option> <!-- Default option -->
                    <option value="Semester 1" <?php if ($selectedSemester === 'Semester 1') echo 'selected'; ?>>Semester 1</option>
                    <option value="Semester 2" <?php if ($selectedSemester === 'Semester 2') echo 'selected'; ?>>Semester 2</option>
                </select>
            </div>
            <!-- Center-align the "View Results" button -->
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">View Results</button>
            </div>
        </form>

        <!-- Result table -->
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($selectedSemester)) {
            try {
                // Define units for Semester 1 and Semester 2 (same as in registrations.php)
                $unitsForSemester1 = [
                    'SIT 215' => 'Computer Graphics',
                    'SIT 212' => 'Cloud Computing',
                    'SIT 213' => 'Mobile Computing',
                    'SIT 214' => 'Database Management',
                ];

                $unitsForSemester2 = [
                    'SIT 220' => 'Group Project',
                    'SIT 221' => 'IoT',
                    'SIT 222' => 'Computer Project',
                    'SIT 223' => 'Software Quality Assurance',
                ];

                $units = $selectedSemester === 'Semester 1' ? $unitsForSemester1 : $unitsForSemester2;
        ?>
                <div class="row">
                    <table>
                        <thead>
                            <tr>
                                <th>Unit Code</th>
                                <th>Unit Name</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($units as $unitCode => $unitName) {
                                echo '<tr>';
                                echo '<td>' . $unitCode . '</td>';
                                echo '<td>' . $unitName . '</td>';

                                // Fetch and display the grades from the database based on the selected semester
                                $gradesQuery = "SELECT grades FROM student_courses WHERE student_id = :student_id AND semester = :semester AND units = :unit";
                                $stmtGrades = $conn->prepare($gradesQuery);
                                $stmtGrades->bindParam(':student_id', $studentId, PDO::PARAM_STR);
                                $stmtGrades->bindParam(':semester', $selectedSemester, PDO::PARAM_STR);
                                $stmtGrades->bindParam(':unit', $unitCode, PDO::PARAM_STR);
                                $stmtGrades->execute();
                                $gradeData = $stmtGrades->fetch(PDO::FETCH_ASSOC);
                                $grade = $gradeData ? $gradeData['grades'] : '';

                                // Check if the grade is empty, and display a message if it is
                                if (empty($grade)) {
                                    echo '<td><strong>Grades not available</strong></td>';
                                } else {
                                    // Display only the grade without unit information
                                    echo '<td>' . $grade . '</td>';
                                }

                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
        <?php
            } catch (PDOException $e) {
                // Handle database query execution errors here
                echo "Database Query Error: " . $e->getMessage();
            }
        }
        ?>
    </div>

    <!-- Add Bootstrap 4 JavaScript links here -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>