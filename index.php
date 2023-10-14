<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Custom CSS for sky blue background -->
    <style>
        .navbar.bg-skyblue {
            background-color: skyblue;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        /* Custom CSS for reducing space from the bottom */
        .image-container {
            padding-bottom: 20px; /* Adjust the value as needed */
        }

        /* Hidden section */
        #about-details {
            display: none;
            margin-top: 20px;
        }

        /* Custom footer styles */
        .footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-skyblue">
    <div class="container">
        <a class="navbar-brand" href="#" style="font-weight: bold; font-family: georgia, sans-serif;">EGERTON UNIVERSITY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="about-link">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Login</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="apply.php">Apply</a>
                </li>
                
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-4">
    <!-- Your page content goes here -->
    <h1>Welcome to Our University</h1>
    <p>The Egerton Agricultural College Ordinance was enacted in 1955. In 1979, the Government of Kenya and the United States Agency for International Development (USAID) funded a major expansion of the institution. In 1986, Egerton Agricultural College was gazetted as a constituent college of the University of Nairobi. The following year, 1987, marked the establishment of Egerton University through an Act of Parliament. Egerton University Act of 1987 was repealed and replaced by the Universities Act No. 42 of 2012 and chartered afresh in 2013.

Egerton University is headquartered at Njoro main campus. The main campus also houses the Faculties of Agriculture, Arts and Social Sciences, Education and Community Studies, Engineering and Technology, Environment and Resources Development, Science and Veterinary Medicine & Surgery.</p>

    <div class="row">
        <div class="col-md-6 image-container">
            <img src="image/picture.jpg" alt="Image 1" class="img-fluid">
        </div>
        <div class="col-md-6 image-container">
            <img src="image/picture.jpg" alt="Image 2" class="img-fluid">
        </div>
    </div>
    
    <!-- Hidden information section -->
    <div id="about-details">
        <h2>Additional information</h2>
        <p>Egerton University is headquartered at Njoro main campus. The main campus also houses the Faculties of Agriculture, Arts and Social Sciences, Education and Community Studies, Engineering and Technology, Environment and Resources Development, Science and Veterinary Medicine & Surgery..</p>
    </div>
</div>

<!-- Footer section -->
<!-- Footer section -->
<footer class="footer" style="background-color: red;">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <p>&copy; 2023 Egerton University. All rights reserved.</p>
                <p>Transforming Lives through Quality Education</p>
            </div>
            <div class="col-md-6 image-container">
            <img src="image/pic.jpg" alt="Image 2" class="img-fluid">
        </div>
        </div>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    // JavaScript to toggle visibility of the additional information section
    document.getElementById("about-link").addEventListener("click", function() {
        var aboutDetails = document.getElementById("about-details");
        if (aboutDetails.style.display === "none" || aboutDetails.style.display === "") {
            aboutDetails.style.display = "block";
        } else {
            aboutDetails.style.display = "none";
        }
    });
</script>
</body>
</html>
