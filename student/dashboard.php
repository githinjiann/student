<?php
// Start the session
session_start();

// Check if the user is logged in (you may have your own logic for this)
if (!isset($_SESSION['user_data'])) {
    // Redirect the user to the login page
    header('Location: index.php'); // Change this to the actual login page URL
    exit; // Make sure to exit after redirection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <!-- Add Bootstrap 4 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <a class="navbar-brand" href="#">Student Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link font-weight-bold" href="index.php">Student portal</a>
            </li>
            <li class="nav-item">
    <a class="nav-link font-weight-bold" href="http://localhost/student/admin/admin_panel.php">Admin panel</a>
</li>

        </ul>
    </div>
</nav>


<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <h3>Welcome, <?php echo $_SESSION['user_data']['fullName']; ?></h3>

        

        </div>
    </div>
</div>

</body>
</html>
