<?php
// Connect to your database using PDO
require_once("../connect.php");

// Query to retrieve student registration information from the student_courses table
$sql = "SELECT student_id, units, semester, grades FROM student_courses";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count the number of registered students
$countSql = "SELECT COUNT(DISTINCT student_id) AS student_count FROM student_courses";
$countStmt = $conn->prepare($countSql);
$countStmt->execute();
$studentCount = $countStmt->fetch(PDO::FETCH_ASSOC)['student_count'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Information</title>
    <!-- Add Bootstrap CSS links here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3">
        <h2>Student Information</h2>
        <p>Total Registered Students: <?php echo $studentCount; ?></p>
        <table class="table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Unit Code</th>
                    <th>Unit Name</th>
                    <th>Grades</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($result)) {
                    // Handle no records found
                    echo "<tr><td colspan='5'>No records found</td></tr>";
                } else {
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["student_id"] . "</td>";
                        echo "<td>" . $row["units"] . "</td>";
                        echo "<td>" . $row["semester"] . "</td>";
                        echo "<td>";
                ?>
                        <form method="POST" action="update_grades.php">
                            <input type="hidden" name="student_id" value="<?php echo $row["student_id"]; ?>">
                            <input type="hidden" name="semester" value="<?php echo $row["semester"]; ?>">
                            <input type="hidden" name="unit_code" value="<?php echo $row["units"]; ?>">
                            <input type="text" name="grades" value="<?php echo isset($row["grades"]) ? $row["grades"] : ''; ?>">
                            
                        </form>
                <?php
                        echo "</td>";
                ?>
                        <td>
                            <form method="POST" action="delete_student.php">
                                <input type="hidden" name="student_id" value="<?php echo $row["student_id"]; ?>">
                                <input type="hidden" name="unit_code" value="<?php echo $row["units"]; ?>">
                                <button type="submit">Delete Student</button>
                            </form>
                        </td>
                <?php
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Bootstrap JavaScript links here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
