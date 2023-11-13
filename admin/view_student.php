<?php
require_once("connect.php"); // Include the database connection script

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_student_id'])) {
    // Get the student ID to be deleted
    $deleteStudentId = $_POST['delete_student_id'];

    // Prepare the SQL statement to delete the student
    $deleteSql = "DELETE FROM students WHERE student_id = :student_id";

    try {
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bindParam(':student_id', $deleteStudentId);

        if ($deleteStmt->execute()) {
            // Student deleted successfully
            echo "Student deleted successfully";
        } else {
            // Handle the case where the deletion fails
            echo "Error deleting student";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Student</title>
    <!-- Add Bootstrap CSS links here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-3">
        <h2>View Student</h2>
        <form method="POST" id="deleteForm">
            <label for="delete_student_id">Select Student to Delete:</label>
            <select name="delete_student_id" id="delete_student_id" class="form-select" onchange="updateDeleteFormAction()">
                <?php
                // Query to retrieve student information from the students table using PDO
                $selectSql = "SELECT student_id, name, email, department FROM students";

                try {
                    $selectStmt = $conn->prepare($selectSql);
                    $selectStmt->execute();

                    while ($row = $selectStmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $row["student_id"] . "'>" . $row["name"] . " (ID: " . $row["student_id"] . ")</option>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </select>
            <button type="submit" class="btn btn-danger">Delete Student</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to retrieve student information from the students table using PDO
                $selectSql = "SELECT student_id, name, email, department FROM students";

                try {
                    $selectStmt = $conn->prepare($selectSql);
                    $selectStmt->execute();

                    while ($row = $selectStmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $row["student_id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["department"] . "</td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Bootstrap JavaScript links here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function updateDeleteFormAction() {
            var deleteForm = document.getElementById('deleteForm');
            var selectedStudentId = document.getElementById('delete_student_id').value;
            deleteForm.action = 'view_student.php?delete_student_id=' + selectedStudentId;
        }
    </script>
</body>

</html>
