<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University of Embu</title>
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
            padding-bottom: 20px;
            /* Adjust the value as needed */
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
    
    <?php include("header.php"); ?>
    <div class="container mt-4">
        <!-- Your page content goes here -->
        <h1>Welcome Universityof Embu</h1>
        <p>The University of Embu is a public chartered World-class University that seeks to generate,
advance and disseminate knowledge through training, research and innovation for the
development of humanity. The University of Embu (UoEm) was initially established as
Embu University College, a Constituent College of the University of Nairobi through Legal
Notice No.65 of 17th June, 2011 by the Former President H.E Mwai Kibaki. The College is
the legal succession of the former Embu Agricultural Staff Training (EAST) College, which
was an agricultural staff college under the Ministry of Agriculture. The predecessor of East
College, the Embu Institute of Agriculture was started in 1947 as an Agricultural Training
School, and later renamed Embu Institute of Agriculture. On 7th October 2016, University
of Embu was established and formally awarded Charter by the fourth President of the
Republic of Kenya, H.E. President Uhuru Kenyatta transitioning the Institution from a
Constituent College of University of Nairobi to a fully- fledged University.
.</p>

        <div class="row">
            <div class="col-md-6 image-container">
                <img src="image/embu.jpg" alt="Image 1" class="img-fluid">
            </div>
            <div class="col-md-6 image-container">
                <img src="image/embu.jpg" alt="Image 2" class="img-fluid">
            </div>
        </div>

  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        // JavaScript to determine the redirection
        document.addEventListener("DOMContentLoaded", function() {
            var loginLink = document.getElementById("login-link");

            // Check if the user has applied (you can change this condition)
            var userHasApplied = true; // Change to true or false based on your logic

            if (userHasApplied) {
                // If the user has applied, set the login link to the login page
                loginLink.href = "login.php";
            } else {
                // If the user has not applied, set the login link to the register page
                loginLink.href = "register.php";
            }
        });
    </script>
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
     <?php include("footer.php");?>
</body>

</html>