<?php
// Connect to your database using PDO
require_once("../connect.php");

// Check if the "student_id" and "semester" parameters are present in the URL
if (isset($_GET['student_id']) && isset($_GET['semester']) && isset($_GET['confirm'])) {
    // Get the student_id and semester from the URL
    $student_id = $_GET['student_id'];
    $semester = $_GET['semester'];

    if ($_GET['confirm'] === "yes") {
        // Check if the student has registered for multiple semesters
        $checkMultipleSemestersSql = "SELECT COUNT(DISTINCT semester) AS semester_count FROM student_courses WHERE student_id = :student_id";
        $checkStmt = $conn->prepare($checkMultipleSemestersSql);
        $checkStmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $checkStmt->execute();
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
        $semesterCount = $result['semester_count'];

        try {
            if ($semesterCount > 1) {
                // If the student has registered for multiple semesters, only delete the selected semester
                $deleteSql = "DELETE FROM student_courses WHERE student_id = :student_id AND semester = :semester";
                $deleteStmt = $conn->prepare($deleteSql);
                $deleteStmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                $deleteStmt->bindParam(':semester', $semester, PDO::PARAM_STR);
            } else {
                // If the student has registered for only one semester, delete all records for that student
                $deleteSql = "DELETE FROM student_courses WHERE student_id = :student_id";
                $deleteStmt = $conn->prepare($deleteSql);
                $deleteStmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
            }

            $deleteStmt->execute();

            if ($deleteStmt->rowCount() > 0) {
                echo '<script>
                    alert("Student with ID ' . $student_id . ' has been deleted.");
                    window.location.href = "student_info.php";
                </script>';
                exit; // Exit to prevent further execution
            } else {
                echo '<script>
                    alert("No records were deleted for the student.");
                    window.location.href = "student_info.php";
                </script>';
                exit; // Exit to prevent further execution
            }
        } catch (PDOException $e) {
            echo '<script>
                alert("Error deleting the student: ' . $e->getMessage() . '");
                window.location.href = "student_info.php";
            </script>';
            exit; // Exit to prevent further execution
        }
    }
}

// Rest of your code for displaying student information remains unchanged

// Query to retrieve student registration information from the student_courses table
$sql = "SELECT DISTINCT student_id, semester FROM student_courses";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count the number of registered students
$studentCount = count($result);
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

        /* Custom style for the navbar and logo */
       

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
                <img src="image/log.jpg" alt="Your Logo" class="img-fluid logo-img">
            </a>
        </div>
    </nav>
    
    <div class="container mt-3 text-center">
        <h2>Student Details</h2>
        <p>Total Registered Students: <?php echo $studentCount; ?></p>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Semester</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (empty($result)) {
                            // Handle no records found
                            echo "<tr><td colspan='3'>No records found</td></tr>";
                        } else {
                            foreach ($result as $row) {
                                echo "<tr>";
                                echo "<td>" . $row["student_id"] . "</td>";
                                echo "<td>" . $row["semester"] . "</td>";
                                echo "<td>
                                    <!-- Add a link to trigger student deletion with a confirmation dialog -->
                                    <a href='?student_id=" . $row["student_id"] . "&semester=" . $row["semester"] . 
                                    '&confirm=yes' . "' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>
                                </td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JavaScript links here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
