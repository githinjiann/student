<?php
// Connect to your database here
$servername = "localhost";
$username = "root";
$password = "";
$database = "student";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
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
        <table class="table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Unit Code</th>
                    <th>Unit Name</th>
                    <th>Grades</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
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
                    <button type="submit">Update</button>
                </form>
                <?php
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No records found</td></tr>";
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
