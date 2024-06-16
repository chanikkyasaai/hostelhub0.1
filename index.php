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

if (isset($_SESSION['userid'])) {
  
  $userid = $_SESSION['userid'];

  
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
  echo 'User not found.';
}


mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MIT Hostels Website</title>
  <link rel="preconnect" href="https:
  <link rel="preconnect" href="https:
  <link rel="preconnect" href="https:
  <link
    href="https:
    rel="stylesheet">
  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">

  <style>
   
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 960px;
      margin: 0 auto;
      padding: 20px;
    }

   
    header {
      background-color: #333;
      color: #fff;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header h1 {
      margin: 0;
      font-family: 'Exo', sans-serif;
      text-align: center;
      flex-grow: 1;
    }

    .profile {
      display: flex;
      align-items: center;
    }

    .profile-pic {
      width: 100px;
      height: 80px;
      border-radius: 30%;
      object-fit: cover;
      margin-right: 10px;
    }

    .profile-info {
      font-family: 'Exo', sans-serif;
      display: flex;
      flex-direction: column;
      justify-content: center;
      text-align: right;
    }

    .profile-info h2,
    .profile-info p {
      margin: 0;
      font-size: 14px;
    }

   
    nav {
      position: fixed;
      top: 75px;
      left: -250px;
      height: calc(100vh - 75px);
      width: 250px;
      background-color: #333;
      color: #fff;
      transition: left 0.3s;
      z-index: 999;
    }

    nav.active {
      left: 0;
    }

    nav ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      background-color: #333;
    }

    nav ul li {
      margin-right: 10px;
    }

    nav ul li a {
      display: block;
      color: #fff;
      text-decoration: none;
      padding: 10px 20px;
      background-color: #222;
      transition: background-color 0.3s;
    }

    nav ul li a:hover {
      background-color: #555;
    }

    nav ul ul {
      display: none;
    }

    nav ul li:hover>ul {
      display: block;
    }

   
    #menu-icon {
      display: block;
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 999;
      font-size: 24px;
      background: none;
      border: none;
      color: #fff;
      cursor: pointer;
      transition: transform 0.3s;
    }

    #menu-icon:hover {
      transform: scale(1.2);
    }

   
    section {
      margin: 20px 0;
      padding: 20px;
      background-color: #f4f4f4;
      border-radius: 5px;
    }

    section h2 {
      margin-top: 0;
      font-family: 'Exo', sans-serif;
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

    .container {
      max-width: 960px;
      margin: 0 auto;
      padding: 20px;
    }

    .timetable-container {
      margin-top: 20px;
    }

    .timetable-table {
      width: 100%;
      border-collapse: collapse;
      margin: auto;
      background-color: #f4f4f4;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .timetable-table th,
    .timetable-table td {
      padding: 10px;
      text-align: center;
      border: 1px solid #ccc;
    }

    .timetable-table th {
      background-color: #333;
      color: #fff;
    }

   
    @keyframes slideInFromLeft {
      from {
        transform: translateX(-100%);
      }
      to {
        transform: translateX(0);
      }
    }

    .timetable-table {
      animation: slideInFromLeft 0.5s ease-in-out;
    }
  </style>
  <script>
    window.addEventListener('load', function () {
      const menuIcon = document.getElementById('menu-icon');
      const nav = document.querySelector('nav');

      menuIcon.addEventListener('click', function () {
        nav.classList.toggle('active');
      });
    });
  </script>
</head>

<body>
  <header>
    <h1>HOSTELHUB</h1>
    <div class="profile">
      <img class="profile-pic" src="<?php echo $profilePic; ?>" alt="Profile Picture">
      <div class="profile-info">
        <h2><?php echo $name; ?></h2>
        <p>ID: <?php echo $userid; ?></p>
      </div>
    </div>
    <button id="menu-icon">&#9776;</button>
  </header>

  <nav>
    <ul>
      <li><a href="#">Home</a></li>
      <li><a href="laundry.php?userid=<?php echo $userid; ?>">Laundry</a></li>
      <li><a href="store.php?userid=<?php echo $userid; ?>">Store</a></li>
      <li><a href="maintenance.php">Maintenance</a></li>
    
      <li>
        <a href="#">Requests</a>
        <ul>
          <li><a href="outpass.php">Outpass Request</a></li>
          <li><a href="docuserve.php">Docuserve</a></li>
        </ul>
      </li>
      <li><a href="idcard.php">Digital ID Card</a></li>
      <!-- <li><a href="chowtime.html">ChowTime</a></li> -->
      <li><a href="cards.php">Cards</a></li>
      <li><a href="guesthouse.php">Guest House Booking</a></li>
      <li><a href="mailto:chanikyac01@gmail.com">Contact us</a></li>
    </ul>
  </nav>

  <div id="notifications">
    <marquee behavior="scroll" direction="left" scrollamount="10">
      <ul style="font-family: 'Space Mono', monospace;">
        <li>The first version of the HOSTELHUB is onboard. Looking forward for your suggestions </li>
      </ul>
    </marquee>
  </div>
  <section class="timetable-container container">
    <h2 style="text-align: center;">Mess Timetable</h2>
    <table class="timetable-table">
      <thead>
        <tr>
          <th>Year</th>
          <th>Breakfast</th>
          <th>Lunch</th>
          <th>Dinner</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1st</td>
          <td>06.45 AM - 07.30 AM</td>
          <td>11.20 AM - 12.10 PM</td>
          <td>06.45 PM - 07.30 PM</td>
        </tr>
        <tr>
          <td>2nd</td>
          <td>07.30 AM - 08.30 AM</td>
          <td>12.10 PM - 01.10 PM</td>
          <td>07.30 PM - 08.45 PM</td>
        </tr>
        <tr>
          <td>3rd</td>
          <td>07.30 AM - 08.30 AM</td>
          <td>12.10 PM - 01.10 PM</td>
          <td>07.30 PM - 08.45 PM</td>
        </tr>
        <tr>
          <td>4th</td>
          <td>07.30 AM - 08.30 AM</td>
          <td>12.10 PM - 01.10 PM</td>
          <td>07.30 PM - 08.45 PM</td>
        </tr>
      </tbody>
    </table>
  </section>

  <section class="container">
    <h2>About HOSTELHUB</h2>
    <p style="font-family: 'Exo', sans-serif;">Welcome to Hostelhub, the premier residential facility for students at Madras Institute of Technology (MIT). Our aim is to provide a comfortable and convenient living experience for our students. Hostelhub offers a range of services designed to enhance the hostel life experience.

Key Features:
<ul style="font-family: 'Exo', sans-serif;">
<li>Laundry: Access our laundry service to get your clothes cleaned and pressed conveniently.</li>
<li>Store: Explore our well-stocked store for essential items, snacks, and daily necessities.</li>
<li>Maintenance: Report maintenance issues and track their resolution for a smooth living experience.</li>
<li>Outpass Management: Request outpasses for authorized leaves and track their status easily.</li>
<li>Docuserve: Avail services related to documentation and paperwork.
Digital ID Card: Access your digital identification card through Hostelhub for easy verification.</li>
<li>Cards: Discover various card services for efficient payment and access control.
Guest House Booking: Request guest house accommodation and receive notifications upon approval.</li>
<li>Contact Us: Reach out to us for any queries, concerns, or feedback.
Hostelhub is continually evolving to provide enhanced services and improve the hostel experience for our esteemed students. We welcome you to make the most of your hostel life with Hostelhub.</li></ul></p>
  </section>

  <footer>
    <p>&copy; 2023 MIT Hostels. All rights reserved. Designed and Developed by Chanikya Nelapatla</p>
  </footer>
</body>


</html>
