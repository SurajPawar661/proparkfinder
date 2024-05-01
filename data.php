<?php
// Start session
session_start();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "userdb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the form data
    $stmt = $conn->prepare("INSERT INTO vehicle_registration (owner_name, vehicle_name, vehicle_number, registration_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $owner_name, $vehicle_name, $vehicle_number, $registration_date);

    // Set parameters
    $owner_name = $_POST['owner_name'];
    $vehicle_name = $_POST['vehicle_name'];
    $vehicle_number = $_POST['vehicle_number'];
    $registration_date = $_POST['registration_date'];

    // Validate input
    if (empty($owner_name) || empty($vehicle_name) || empty($vehicle_number) || empty($registration_date)) {
        echo "Error: All fields are required";
    } else {
        // Execute SQL query
        if ($stmt->execute()) {
            // Store owner's name in session
            $_SESSION['owner_name'] = $owner_name;
            echo "<script>alert('Registration successful');</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to ProParkFinder</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <!--background-section-->
    <div class="background"><div class="overlay">
        <div class="quarter-bg"></div>
    </div></div>


   <section>
    <!--Header section-->
    <nav class="navbar navbar-expand-lg bg-body-dark ">
        <div class="container-fluid">
          <a class="navbar-brand text-light" href="index.html" id="title">
            ProParkFinder
          </a>
          <button class="navbar-toggler navbar-dark border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link text-light active" aria-current="page" href="index.html">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-light" href="#">About Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-light" href="#">Contact Us</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    

    <!--main-content-->
    <div class="container map-data">
        <div class="row">
        <!-- Form for vehicle type and area selection -->
  <form id="parkingForm">
    <label for="vehicleType" class="fs-3 select-type">Select Vehicle Type:</label>
    <select id="vehicleType" class="btn btn-outline-light text-start px-4">
      <option value="select" >Select</option>
      <option value="car">Car</option>
      <option value="bike">Bike</option>
      <!-- Add more options if needed -->
    </select>

    <label for="area"  class="fs-3 select-area">Select Area:</label>
    <select id="area" class="btn btn-outline-light text-start px-4">
      <option value="select" >Select</option>
      <option value="Shivaji Nagar">Shivaji Nagar</option>
      <option value="Kothrud">Kothrud</option>
      <option value="Aundh">Aundh</option>
      <option value="Camp">Camp</option>
      <option value="Koregaon Park">Koregaon Park</option>
      <option value="Hadapsar">Hadapsar</option>
      <option value="Baner">Baner</option>
      <option value="Wakad">Wakad</option>
      <option value="Hinjawadi">Hinjawadi</option>
      <option value="Magarpatta City">Magarpatta City</option>
      <!-- Add more areas as needed -->
    </select>
    <br><br>
    <center><button type="submit" class="btn btn-outline-light">Find Parking</button></center>
            </form>
        </div>
    </div>

    <!-- Map container -->
    <div class="container map">
        <div class="row">
        <div id="areaImage" class="mt-1"></div>
        </div>
    </div>

    <!-- "Book Now" button container -->
   <div class="container book">
    <div class="row">
    <div id="bookNowButton">        
        <a href="booking page.html"><button onclick="bookNow()" class="btn btn-outline-light" type="submit">Book Now</button></a>
    </div>
    </div>
   </div>

   </section>
    <!--footer-->
     <footer class="container-fluid footer bg-dark text-light">
        <div class="row">
            <div class="copyright">
                <p class="fs-3">@2024 ProParkFinder. All rights reserved</p>
            </div>
        </div>
    </footer>

    <script>
     // Event listener for form submission
    document.getElementById('parkingForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent form submission

      var vehicleType = document.getElementById('vehicleType').value;
      var area = document.getElementById('area').value;

      // Get iframe code for the selected area
      var iframeCode = getIframeCode(area);

      // Display the map
      document.getElementById('areaImage').innerHTML = iframeCode;

      // Display the "Book Now" button
      displayBookNowButton();
    });

    // Function to get iframe code for the selected area
    function getIframeCode(area) {
      // Replace these with the iframe code for the different areas
      var iframeCodes = {
        "Shivaji Nagar": '<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d25448.566758939945!2d73.83657201763877!3d18.531067413249623!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sparking%20is%20shivaji%20nagar!5e0!3m2!1sen!2sin!4v1714544507918!5m2!1sen!2sin" width="800" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        "Kothrud": '<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d60528.407626335924!2d73.80136430195726!3d18.527750825257403!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sparking%20in%20kothrud!5e0!3m2!1sen!2sin!4v1714545773036!5m2!1sen!2sin" width="800" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        "Aundh": '<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d60520.311557205!2d73.77858403758243!3d18.550604749041238!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sparking%20in%20aundh!5e0!3m2!1sen!2sin!4v1714545817997!5m2!1sen!2sin" width="800" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        "Camp": '<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d60533.784575937345!2d73.84203675467414!3d18.512557503026088!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sparking%20in%20camp!5e0!3m2!1sen!2sin!4v1714545980230!5m2!1sen!2sin" width="800" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        "Koregaon Park": '<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d60533.73014448245!2d73.84203666218832!3d18.512711366988785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sparking%20in%20koregaon%20park!5e0!3m2!1sen!2sin!4v1714546007328!5m2!1sen!2sin" width="800" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        "Hadapsar": '<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d60534.07880206526!2d73.88048871814013!3d18.511725778778885!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sparking%20in%20hadapsar!5e0!3m2!1sen!2sin!4v1714546049618!5m2!1sen!2sin" width="800" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        "Baner": '<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d60516.823141630986!2d73.78021048455965!3d18.560443625037504!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sparking%20in%20baner!5e0!3m2!1sen!2sin!4v1714546080923!5m2!1sen!2sin" width="800" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        "Wakad": '<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d15125.646104238442!2d73.75308747960695!3d18.60055105714493!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sparking%20in%20wakad!5e0!3m2!1sen!2sin!4v1714546104506!5m2!1sen!2sin" width="800" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        "Hinjawadi": '<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d60502.53571373383!2d73.7221871019459!3d18.600688100495336!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sparking%20in%20hinjawadi!5e0!3m2!1sen!2sin!4v1714546136561!5m2!1sen!2sin" width="800" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        "Magarpatta City": '<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d35992.60522987761!2d73.91977449315577!3d18.517303464896365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sparking%20in%20magarpatta%20city!5e0!3m2!1sen!2sin!4v1714546167383!5m2!1sen!2sin" width="800" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        // Add more areas and iframe codes as needed
      };

      return iframeCodes[area] || '<p>No map available for this area</p>';
    }

    // Function to display the "Book Now" button
    function displayBookNowButton() {
            document.getElementById('bookNowButton').style.display = 'block';
        }
    </script>
</body>
</html>