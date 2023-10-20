<?php
// Start the session
require_once('../connect.php');
session_start();

// Check if the user is logged in (authenticated)
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Retrieve the student ID from the session
    $studentId = $_SESSION['course_code'];

    // Include your database configuration here
    // ...

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
        .container {
            margin-top: 20px;
        }

        .narrow-column {
            width: 10%;
        }

        .center-table {
            margin: 0 auto;
            width: 60%;
        }

        /* Custom CSS for the form elements */
        .custom-form {
            max-width: 70%; /* Adjust the max-width as needed */
            margin: 0 auto;
            padding: 5px;
        }

        .alert-success, .alert-warning {
            margin: 0 auto;
            max-width: 400px; /* Minimize the width of the success and warning messages */
        }
    </style>
</head>

<body>
    <h2 class="text-center text-primary mt-3">Student Results</h2>

    <!-- Form to select a semester -->
    <form method="POST" action="results.php" class="custom-form">
        <div class="form-group">
            <label for "semester">Select Semester:</label>
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
    ?>
            <div class="row mt-4">
                <div class="col-12">
                    <table class="table table-bordered center-table">
                        <thead class="thead-dark">
                            <tr>
                                <th class="narrow-column text-center">Unit Code</th>
                                <th class="narrow-column text-center">Unit Name</th>
                                <th class="narrow-column text-center">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
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

                            $selectedSemester = $_POST['semester'];
                            $units = ($selectedSemester === 'Semester 1') ? $unitsForSemester1 : $unitsForSemester2;

                            $gradesUpdated = false;
                            foreach ($units as $unitCode => $unitName) {
                                // Initialize variables
                                $gradeData = null;
                                $grade = '';

                                // Fetch and display the grades from the database based on the selected semester
                                $gradesQuery = "SELECT grades FROM student_courses WHERE student_id = :student_id AND semester = :semester AND units = :unit";
                                $stmtGrades = $conn->prepare($gradesQuery);
                                $stmtGrades->bindParam(':student_id', $studentId, PDO::PARAM_STR);
                                $stmtGrades->bindParam(':semester', $selectedSemester, PDO::PARAM_STR);
                                $stmtGrades->bindParam(':unit', $unitCode, PDO::PARAM_STR);
                                $stmtGrades->execute();
                                $gradeData = $stmtGrades->fetch(PDO::FETCH_ASSOC);
                                if ($gradeData) {
                                    $grade = $gradeData['grades'];
                                    $gradesUpdated = true;
                                }

                                echo '<tr>';
                                echo '<td class="narrow-column">' . $unitCode . '</td>';
                                echo '<td class="narrow-column">' . $unitName . '</td>';
                                echo '<td class="narrow-column text-center">' . $grade . '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
         if ($gradesUpdated) {
    echo '<div class="alert alert-success text-center mt-4">Grades have been updated!</div>';
} else {
    echo '<div class="alert alert-warning text-center mt-4">Grades have not been updated yet.</div>';
}

            ?>

        <?php
        } catch (PDOException $e) {
            // Handle database query execution errors here
            echo "Database Query Error: " . $e->getMessage();
        }
    }
    ?>
</body>
</html>
