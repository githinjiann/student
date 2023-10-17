<?php
// Include your database configuration here
require_once("../connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['student_id']) && isset($_POST['unit_code'])) {
        $studentId = $_POST['student_id'];
        $unitCode = $_POST['unit_code'];

        // SQL statement to delete the student's record
        $sql = "DELETE FROM student_courses WHERE student_id = :student_id AND units = :unit_code";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':student_id', $studentId, PDO::PARAM_STR);
        $stmt->bindParam(':unit_code', $unitCode, PDO::PARAM_STR);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect back to the student information page after successful removal
            header('Location: student_info.php');
            exit();
        } else {
            // Handle the case where deletion fails
            echo "Error: Student removal failed.";
        }
    } else {
        echo "Invalid parameters.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete Student</title>
</head>

<body>
    <h2>Delete Student</h2>
    <form method="POST" action="remove_student.php">
        <label for="student_id">Student ID:</label>
        <input type="text" name="student_id" required><br>

        <label for="unit_code">Unit Code:</label>
        <input type="text" name="unit_code" required><br>

        <input type="submit" value="Delete Student">
    </form>
</body>

</html>