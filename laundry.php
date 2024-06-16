<?php

session_start();


$host = 'localhost';
$username = 'root';
$password = '';
$database = 'hostelhub';

$conn = mysqli_connect($host, $username, $password, $database);


if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


if (isset($_GET['userid'])) {
  
  $userid = $_GET['userid'];

  
  $query = "SELECT * FROM student_details WHERE id = '$userid'";
  $result = mysqli_query($conn, $query);

  
  if ($result) {
    
    if (mysqli_num_rows($result) > 0) {
      
      $row = mysqli_fetch_assoc($result);
      $name = $row['name'];
      $profilePicData = $row['profile_pic'];

      
      $profilePic = 'data:image/jpeg;base64,' . base64_encode($profilePicData);
    } else {
      echo 'User not found.';
    }
  } else {
    echo 'Error fetching user details: ' . mysqli_error($conn);
  }
} else {
  echo 'User ID not found.';
}


$balanceQuery = "SELECT laundry FROM balance WHERE id = '$userid'";
$balanceResult = mysqli_query($conn, $balanceQuery);


if ($balanceResult) {
  
  if (mysqli_num_rows($balanceResult) > 0) {
    
    $balanceRow = mysqli_fetch_assoc($balanceResult);
    $laundryBalance = $balanceRow['laundry'];
  } else {
    echo 'Balance not found.';
  }
} else {
  echo 'Error fetching balance: ' . mysqli_error($conn);
}

$laundryStatusQuery = "SELECT status FROM status WHERE service = 'laundry'";
$laundryStatusResult = mysqli_query($conn, $laundryStatusQuery);

if ($laundryStatusResult && mysqli_num_rows($laundryStatusResult) > 0) {
  $laundryStatusRow = mysqli_fetch_assoc($laundryStatusResult);
  $laundryStatus = $laundryStatusRow['status'];
} else {
  $laundryStatus = 'closed'; 
}


$pendingQuery = "SELECT * FROM laundry WHERE id = '$userid' AND status != 'delivered' ORDER BY ticketid DESC";
$pendingResult = mysqli_query($conn, $pendingQuery);



$completedQuery = "SELECT * FROM laundry WHERE id = '$userid' AND status = 'delivered' ORDER BY ticketid DESC";
$completedResult = mysqli_query($conn, $completedQuery);


mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MIT Hostels - Laundry</title>
  <link rel="preconnect" href="https:
  <link rel="preconnect" href="https:
  <link rel="preconnect" href="https:
  <link
    href="https:
    rel="stylesheet">

  <style>
   
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    .container {
      max-width: 960px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

   
    header {
      background-color: #333;
      color: #fff;
      padding: 20px;
    }

    section h2 {
      margin-top: 0;
    }

   
    .header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.header h1 {
  margin: 0;
  font-size: 24px;
  color: #333;
  text-align: center;
}



    .wallet-card {
      display: flex;
      align-items: center;
      background-color: #333;
      padding: 10px;
      border-radius: 5px;
      color: #fff;
    }

    .wallet-card__balance {
      margin-right: 10px;
      font-weight: bold;
    }

    .status {
      float: right;
      margin-right: 10px;
      font-weight: bold;
    }

   
    .sections {
      display: flex;
      margin-bottom: 20px;
    }

    .section {
      flex: 1;
      margin-right: 10px;
    }

    .section-button {
      margin-bottom: 10px;
      padding: 10px;
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .section-button:hover {
      background-color: #555;
    }

    .section-content {
      display: none;
      background-color: #f4f4f4;
      padding: 20px;
      border-radius: 5px;
    }

    .section-content.visible {
      display: block;
    }

    .card {
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-bottom: 20px;
    }

    .card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 10px;
    }

    .card-header h3 {
      margin: 0;
      font-size: 18px;
      color: #333;
    }

    .card-body p {
      margin: 0;
      margin-bottom: 10px;
      color: #333;
    }

   
    .footer {
      margin-top: 20px;
      text-align: center;
    }

    .footer button {
      margin-right: 10px;
      color: #333;
      text-decoration: underline;
      background: none;
      border: none;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
      font-family: 'Exo', sans-serif;
    }

    .footer button:hover {
      color: #555;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .navbar .section-button {
      padding: 10px 20px;
      background-color: #f1f1f1;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      color: #333;
     
      transition: background-color 0.3s;
     
    }

    .navbar .section-button.active {
      background-color: #ddd;
    }

    .navbar .section-button:hover {
      background-color: #e0e0e0;
     
    }

    .section-content {
      display: none;
    }

    .section-content.visible {
      display: block;
    }

    .card-list {
      list-style-type: none;
      padding: 0;
    }

    .card-list li {
      margin-bottom: 10px;
    }

    .card {
      border: 1px solid #ddd;
      padding: 10px;
      background-color: #f9f9f9;
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .card-header .status {
      font-weight: bold;
    }

   

    @keyframes wallet-pulse {
      0% {
        transform: scale(1);
        background-color: #333;
      }

      50% {
        transform: scale(1.2);
        background-color: #de1717;
      }

      100% {
        transform: scale(1);
        background-color: #333;
      }
    }

   

   
    .home-button {
      position: fixed;
      bottom: 20px;
      right: 20px;
      padding: 10px 20px;
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
      z-index: 9999;
      opacity: 0.8;
      transition: opacity 0.3s ease;
    }

    .home-button:hover {
      opacity: 1;
    }

    .home-button span {
      display: inline-block;
      vertical-align: middle;
      margin-left: 5px;
      animation: bounce 1s infinite;
    }

    @keyframes bounce {
      0% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-10px);
      }

      100% {
        transform: translateY(0);
      }
    }

    .balance {
      color: #fff;
      margin-top: 10px;
      font-size: 16px;
      font-weight: bold;
      font-family: 'Exo', sans-serif;
    }

    .laundry-status {
      display: flex;
      align-items: center;
      margin-top: 10px;
    }

    .laundry-status-text {
      font-size: 16px;
      margin-left: 5px;
      font-family: 'Exo', sans-serif;
    }

    .laundry-status-sticker {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      margin-left: 5px;
    }

    .laundry-status-open {
      background-color: #4CAF50;
    }

    .laundry-status-closed {
      background-color: #df4242;
    }

   
    footer {
      background-color: #333;
      color: #fff;
      padding: 10px;
      text-align: center;
    }

    footer p {
      margin: 0;
      font-family: 'Exo', sans-serif;
    }
  
    .profile {
    position: absolute;
    top: 20%;
    transform: translateY(-50%);
    right: 20px;
    display: flex;
    align-items: center;
    font-family: 'Exo', sans-serif;
    color: #fff;
  }

  .profile img {
    width: 100px;
    height: 80px;
    border-radius: 30%;
    margin-right: 10px;
    object-fit: cover;
  }

  .profile span {
    color: #fff;
    font-family: 'Exo', sans-serif;
  }
  </style>
</head>

<body>
<header>
    <h1 style="text-align: center; font-family: 'Exo', sans-serif;">HOSTELHUB</h1>

    <h2 style="text-align: center; font-family: 'Exo', sans-serif;">LAUNDRY</h2>
    
    <div class="wallet-card">
      <span class="wallet-card__balance">Wallet Balance: <?php echo $laundryBalance; ?> Rs</span>
    </div>


      <div class="laundry-status">
        <div class="laundry-status-sticker <?php echo ($laundryStatus === 'open') ? 'laundry-status-open' : 'laundry-status-closed'; ?>"></div>
        <span class="laundry-status-text">Laundry is <?php echo ($laundryStatus === 'open') ? 'Open' : 'Closed'; ?></span>
        <button class="home-button"><a href="index.php"><span style="color: white;">Home</span></a></button>
      </div>
    <div class="profile">
      <<img class="profile-pic" src="<?php echo $profilePic; ?>" alt="Profile Picture">
      <span style="color: white;"><?php echo $name; ?> <br> <p>ID: <?php echo $userid; ?></p></span>
      
      
    </div>
  </header>

  <div class="container">
    <div class="navbar">
      <button class="section-button active" onclick="toggleSection('pending')">Pending</button>
      <button class="section-button" onclick="toggleSection('completed')">Completed</button>
    </div>

    <div class="sections">
      <div class="section-content visible" id="pending">
        <?php if (mysqli_num_rows($pendingResult) > 0) : ?>
          <ul class="card-list">
            <?php while ($row = mysqli_fetch_assoc($pendingResult)) : ?>
              <li>
                <div class="card">
                  <div class="card-header">
                    <h3>Ticket ID #<?php echo $row['ticketid']; ?></h3>
                    <span class="status"><?php echo $row['status']; ?></span>
                  </div>
                  <div class="card-body">
                    <p>cost: <?php echo $row['cost']; ?> Rs</p>
                    <p>Date and Time: <?php echo $row['date']; ?></p>
                    <p>ETC: 1 day</p>
                  </div>
                </div>
              </li>
            <?php endwhile; ?>
          </ul>
        <?php else : ?>
          <p class="empty-message">No pending laundry orders found.</p>
        <?php endif; ?>
      </div>

      <div class="section-content" id="completed">
        <?php if (mysqli_num_rows($completedResult) > 0) : ?>
          <ul class="card-list">
            <?php while ($row = mysqli_fetch_assoc($completedResult)) : ?>
              <li>
                <div class="card">
                  <div class="card-header">
                    <h3>Ticket ID #<?php echo $row['ticketid']; ?></h3>
                    <span class="status"><?php echo $row['status']; ?></span>
                  </div>
                  <div class="card-body">
                    <p>cost: <?php echo $row['cost']; ?> Rs</p>
                    <p>Date and Time: <?php echo $row['date']; ?></p>
                    <p>Delivery: <?php echo $row['delivery']; ?></p>
                  </div>
                </div>
              </li>
            <?php endwhile; ?>
          </ul>
        <?php else : ?>
          <p class="empty-message">No completed laundry orders found.</p>
        <?php endif; ?>
      </div>
    </div>

    <div class="footer">
      <button class="section-button" onclick="toggleSection('know-more')">Know More</button>
      <button class="section-button" onclick="toggleSection('contact-us')">Contact Us</button>
    </div>

    <div class="section-content" id="know-more">
      <p>
      At Hostelhub, we understand the importance of clean and well-maintained clothing for a comfortable and pleasant hostel experience. Our laundry services are designed to provide convenience and efficiency, ensuring that your laundry needs are taken care of without any hassle.
      
    </div>
    <div class="section-content" id="contact-us">
      <p>
        Contact us at:
        <br>
        Phone: 123-456-7890
        <br>
        Email: contact@hostelhub.com
      </p>
    </div>

    <footer>
      <p>&copy; 2023 MIT Hostels. All rights reserved. | Designed and Developed by Chanikya Nelapatla</p>
    </footer>
  </div>

  <script>
    function toggleSection(sectionId) {
      var sections = document.getElementsByClassName('section-content');
      for (var i = 0; i < sections.length; i++) {
        sections[i].classList.remove('visible');
      }

      var selectedSection = document.getElementById(sectionId);
      selectedSection.classList.add('visible');

      var buttons = document.getElementsByClassName('section-button');
      for (var j = 0; j < buttons.length; j++) {
        buttons[j].classList.remove('active');
      }

      var selectedButton = document.querySelector('.section-button[data-section="' + sectionId + '"]');
      selectedButton.classList.add('active');
    }
  </script>
</body>

</html>
