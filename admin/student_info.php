<?php
// Connect to your database using PDO
require_once("../connect.php");

// Check if the "student_id" and "semester" parameters are present in the URL
if (isset($_GET['student_id']) && isset($_GET['semester']) && isset($_GET['confirm'])) {
    // Get the student_id and semester from the URL
    $student_id = $_GET['student_id'];
    $semester = $_GET['semester'];

    if ($_GET['confirm'] === "yes") {
        // Query to delete the student
        $deleteSql = "DELETE FROM student_courses WHERE student_id = :student_id AND semester = :semester";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $deleteStmt->bindParam(':semester', $semester, PDO::PARAM_STR);

       if ($deleteStmt->execute()) {
    // Student deleted successfully
    echo "Student with ID $student_id in semester $semester has been deleted.";
    
    // Use JavaScript to redirect immediately after displaying the message
    echo '<script>
        window.location.href = "student_info.php";
    </script>';
} else {
    // Error occurred during deletion
    echo "Error deleting the student.";
}

        
        // Exit to prevent further execution
        exit;
    }
}

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
    </style>
</head>

<body>
    <?php include("header.php"); ?>
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
