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