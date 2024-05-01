<?php
// Start session
session_start();

// Retrieve booking details from query parameters or session
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['entryDate']) && isset($_GET['exitDate']) && isset($_GET['vehicleNumber'])) {
    $entryDate = $_GET['entryDate'];
    $exitDate = $_GET['exitDate'];
    $vehicleNumber = $_GET['vehicleNumber'];

    // Store booking details in session for future use
    $_SESSION['entryDate'] = $entryDate;
    $_SESSION['exitDate'] = $exitDate;
    $_SESSION['vehicleNumber'] = $vehicleNumber;
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['entryDate']) && isset($_SESSION['exitDate']) && isset($_SESSION['vehicleNumber'])) {
    // Booking confirmation logic can go here
    // For now, let's just display the booking details
    $entryDate = $_SESSION['entryDate'];
    $exitDate = $_SESSION['exitDate'];
    $vehicleNumber = $_SESSION['vehicleNumber'];
} else {
    // Redirect to the homepage if booking details are not available
    header('Location: index.html');
    exit();
}

// Store the entry details in the session if they are provided
if (isset($_GET['entryDate']) && isset($_GET['exitDate']) && isset($_GET['vehicleNumber'])) {
    $_SESSION['entryDetails'][] = array(
        'entryDate' => $_GET['entryDate'],
        'exitDate' => $_GET['exitDate'],
        'vehicleNumber' => $_GET['vehicleNumber']
    );
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
    <div class="container">
        <div class="row">
            <h2 class="text-center text-light mb-2">Vehicle Record</h2>
            <!-- HTML code for displaying entry date, exit date, vehicle number, and booking status in a tabular form -->
            <table class="bg-light">
                <tr>
                    <th>Entry Date</th>
                    <th>Exit Date</th>
                    <th>Vehicle Number</th>
                    <th>Booking Status</th>
                </tr>
                <?php
    // Display the stored entry details
    if (isset($_SESSION['entryDetails'])) {
        foreach ($_SESSION['entryDetails'] as $entry) {
            echo "<tr>";
            echo "<td>{$entry['entryDate']}</td>";
            echo "<td>{$entry['exitDate']}</td>";
            echo "<td>{$entry['vehicleNumber']}</td>";
            echo "<td>Confirm</td>";
            echo "</tr>";
        }
    }
    ?>
                <!--<tr>
                    <td id="entryDateCell"><?php echo $_GET['entryDate']; ?></td>
                    <td id="exitDateCell"><?php echo $_GET['exitDate']; ?></td>
                    <td id="vehicleNumberCell"><?php echo $_GET['vehicleNumber']; ?></td>
                    <td id="bookingStatusCell" class="bg-success text-center text-light">Confirm</td>
                </tr>-->
            </table>
        </div>
    </div>  

    <div class="container return-btn">
        <div class="row">
            <a href="data.php"><button class="btn btn-outline-light">Go back</button></a>
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
    </script>
</body>
</html>
