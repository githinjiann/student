<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Bootstrap CSS (you'll need to have Bootstrap files or CDN links) -->
    <link rel="stylesheet" href="path-to-bootstrap-css/bootstrap.min.css">
    <style>
        .navbar {
            background-color: skyblue;
            height: 70px;
            /* Increase the height to your preferred value */
        }

        .frame {
            border: 10px solid #333;
            padding: 25px;
            border-radius: 10px;
            width: 300px;
            background-color: #f0f0f0;
            /* Background color for the frame */
            margin: 0 auto;
            /* Center the frame horizontally */
        }

        .card-title {
            text-align: center;
            /* Center the title text */
            font-size: 24px;
            /* Adjust the font size */
            margin-bottom: 20px;
            /* Add some spacing below the title */
            color: #007BFF;
            /* Custom title text color */
            font-family: 'Arial', sans-serif;
            /* Custom font family for the title */
            font-weight: bold;
            /* Bold font weight */
            text-decoration: underline;
            /* Underline the title text */
        }

        .form-check-input:checked+.form-check-label::before {
            background-color: #007BFF;
            /* Change the radio button color when selected */
        }
    </style>
    <script>
        function redirectToUpdatePage() {
            // Redirect to the update_grades.php page
            window.location.href = "update_grades.php";
        }

        function redirectToStudentInfoPage() {
            // Redirect to the student_info.php page
            window.location.href = "student_info.php";
        }
    </script>
</head>

<body>

    <!DOCTYPE html>
    <html lang="en">

    <head>
    <head>
    <title>Admin Login</title>
    <!-- Add Bootstrap CSS and JavaScript links here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar.bg-skyblue {
            background-color: skyblue;
        }
        </style>

</head>
    </head>

    <body>
         <?php include("header.php");?>

        <script src="path-to-bootstrap-js/bootstrap.min.js"></script>
    </body>

    </html>
    <div class="container mt-4">
        <div class="text-center"> <!-- Center-align the title -->
            <h1 class="card-title">Welcome to the Admin Dashboard</h1>
        </div>

        <!-- Frame-like Device with Action Selection using Bootstrap classes -->
        <div class="card frame">
            <div class="card-body">
                <h2 class="card-title">Choose an Action</h2>
                <form action="process_action.php" method="post">
              <div class="form-check">
    <input type="radio" id="update_grades" name="action" value="update_grades.php" required class="form-check-input" onclick="redirectToUpdatePage()">
    <label class="form-check-label" for="update_grades">
        <span class="text-primary">Update grades</span>
    </label>
</div>

<div class="form-check">
    <input type="radio" id="view" name="action" value="student_info.php" required class="form-check-input" onclick="redirectToStudentInfoPage()">
    <label class="form-check-label" for="view">
        <span class="text-primary">View Student</span>
    </label>
</div>
<p class="dashboard-link">
                    <a href="logout.php" class="btn btn-danger btn-block">Logout</a>
                </p>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS (you'll need to have Bootstrap JS files or CDN links) -->
    <script src="path-to-bootstrap-js/bootstrap.min.js"></script>
</body>

</html>