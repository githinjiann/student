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
            height: 70px; /* Increase the height to your preferred value */
        }

        .frame {
            border: 10px solid #333;
            padding: 25px;
            border-radius: 10px;
            width: 300px;
            background-color: #f0f0f0; /* Background color for the frame */
            margin: 0 auto; /* Center the frame horizontally */
        }

        .card-title {
            text-align: center; /* Center the title text */
            font-size: 24px; /* Adjust the font size */
            margin-bottom: 20px; /* Add some spacing below the title */
            color: #007BFF; /* Custom title text color */
            font-family: 'Arial', sans-serif; /* Custom font family for the title */
            font-weight: bold; /* Bold font weight */
            text-decoration: underline; /* Underline the title text */
        }

        .form-check-input:checked + .form-check-label::before {
            background-color: #007BFF; /* Change the radio button color when selected */
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
    <!-- ... (your existing meta tags and style links) ... -->
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#" style="color: green; font-size: 27px;">Egerton University</a>
            <ul class="navbar-nav ms-auto"> <!-- Added this ul for right-aligned links -->
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- ... (your existing content) ... -->

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
                        <input type="radio" id="update_grades" name="action" value="update_grades.php" required
                            class="form-check-input" onclick="redirectToUpdatePage()">
                        <label class="form-check-label" for="update_grades">Update grades</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="view" name="action" value="student_info.php" required
                            class="form-check-input" onclick="redirectToStudentInfoPage()">
                        <label class="form-check-label" for="view">View Student</label>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS (you'll need to have Bootstrap JS files or CDN links) -->
    <script src="path-to-bootstrap-js/bootstrap.min.js"></script>
</body>
</html>
