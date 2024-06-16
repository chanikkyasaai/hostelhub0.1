<?php

session_start();


if (!isset($_SESSION['userid'])) {
  
  header("Location: login.php");
  exit();
}


$studentId = $_SESSION['userid'];


$host = 'localhost';
$username = 'root';
$password = ''; 
$dbname = 'hostelhub';


$conn = mysqli_connect($host, $username, $password, $dbname);


if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


$query = "SELECT * FROM student_details WHERE id = '$studentId'";
$result = mysqli_query($conn, $query);


if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $profilePic = $row['profile_pic'];
  $id = $row['id'];
  $blockName = $row['block_name'];
  $roomNo = $row['room_no'];
  $barcode = $row['barcode_image'];
} else {
  
  $profilePic = ""; 
  $id = "";
  $blockName = "";
  $roomNo = "";
  $barcode = "";
}


mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Digital ID Card</title>
  <link href="https:
  <style>
    body {
      font-family: 'Exo', sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
    }

    .card {
      max-width: 250px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .profile-pic {
      display: block;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      margin: 0 auto 20px;
      object-fit: cover;
    }

    .info {
      text-align: center;
      margin-bottom: 20px;
    }

    .info h2 {
      margin: 0;
      font-size: 20px;
      font-weight: bold;
    }

    .info p {
      margin: 0;
      font-size: 14px;
      color: #777;
    }

    .barcode {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }

    .barcode img {
      height: 30px;
      width: auto;
    }

    .footer {
      text-align: center;
      font-size: 12px;
      color: #777;
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
  </style>
</head>

<body>
  <button class="home-button">
    <a href="index.php">
      <span style="color: white;">Home</span>
    </a>
  </button>

  <div class="card">
    <img class="profile-pic" src="data:image/jpeg;base64,<?php echo base64_encode($profilePic); ?>" alt="Student Photo">
    <div class="info">
      <h2><?php echo $row['name']; ?></h2>
      <p>Registration Number: <?php echo $id; ?></p>
      <p>Block Name: <?php echo $blockName; ?></p>
      <p>Room No: <?php echo $roomNo; ?></p>
    </div>
    <div class="barcode">
    <img src="data:image/png;base64,<?php echo base64_encode($barcode); ?>" alt="Barcode">
    </div>
    <div class="footer">
      <p>&copy; <?php echo date("Y"); ?> HostelHub MIT. All rights reserved.</p>
    </div>
  </div>
</body>

</html>

