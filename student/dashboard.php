<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <!-- Add Bootstrap 4 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar.bg-skyblue {
            background-color: skyblue;
        }


           /* Custom style for the navbar and logo */
        .navbar {
            background-color: green;
        }

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


        .dashboard-frame {
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 30px;
            background-color: #f5f5f5;
        }

        .dashboard-title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .dashboard-link {
            text-align: center;
            margin-bottom: 10px;
        }

        /* Style for the footer */
        .footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

       .logo-img {
    display: block;
    max-width: 100%;
    margin: 0 auto;
}

    </style>
</head>

 <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="image/logo.jpg" alt="Your Logo" class="img-fluid logo-img">
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6 dashboard-frame">
                <h3 class="dashboard-title">Student Portal</h3>
                <p class="dashboard-link">
                    <a href="registrations.php" class="btn btn-primary btn-block">Registrations</a>
                </p>
                <p class="dashboard-link">
                    <a href="results.php" class="btn btn-primary btn-block">Results</a>
                </p>
                <p class="dashboard-link">
                    <a href="logout.php" class="btn btn-danger btn-block">Logout</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>&copy; 2023 e.u. All rights reserved. Transforming Lives through Quality Education</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
