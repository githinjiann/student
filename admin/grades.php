<?php
require_once("connect.php"); // Include the database connection script
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
        <h2>update student marks</h2>
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
                $sql = "SELECT student_id, name, email, department FROM students";

                try {
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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

    <!-- JavaScript to redirect to update_grades.php -->
    <script>
        function redirectToUpdateGradesPage() {
            window.location.href = "update_grades.php";
        }
    </script>

    <!-- Button for admin to update student results -->
    <button class="btn btn-primary" onclick="redirectToUpdateGradesPage()">Update Student Results</button>
</body>

</html>