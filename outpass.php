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


$query = "SELECT id, name, block_name, room_no , profile_pic FROM student_details WHERE id = '$studentId'";
$result = mysqli_query($conn, $query);


if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $studentId = $row['id'];
  $name = $row['name'];
  $blockName = $row['block_name'];
  $roomNo = $row['room_no'];
  $profilePic = $row['profile_pic'];
} else {
  
  $studentId = ""; 
  $name = ""; 
  $blockName = ""; 
  $roomNo = ""; 
  $profilePic = ""; 
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $name = $_POST['name'];
  $studentId = $_POST['studentId'];
  $blockName = $_POST['blockName'];
  $roomNo = $_POST['roomNo'];
  $date = $_POST['date'];
  $placeOfVisit = $_POST['placeOfVisit'];
  $address = $_POST['address'];
  $noOfDaysProposed = $_POST['noOfDaysProposed'];
  $timeOut = $_POST['timeOut'];
  $returnDateTime = $_POST['returnDateTime'];
  $contactPhone = $_POST['contactPhone'];
  $parentPhone = $_POST['parentPhone'];

  
  $query = "INSERT INTO outpass_details (id, name, student_id, block_name, room_no, date, place_of_visit, address, no_of_days_proposed, time_out, return_date_time, contact_phone, parent_phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "ssssssssssssi", $studentId, $name, $studentId, $blockName, $roomNo, $date, $placeOfVisit, $address, $noOfDaysProposed, $timeOut, $returnDateTime, $contactPhone, $parentPhone);

  
  if (mysqli_stmt_execute($stmt)) {
    
    mysqli_stmt_close($stmt);

    
    echo "<script>alert('Outpass request submitted successfully'); window.location.href = window.location.href;</script>";
  } else {
    
    echo "Error: " . mysqli_error($conn);
  }
}


mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Outpass Request - MIT Hostels Website</title>
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
      justify-content: space-between;
      align-items: center;
    }

    header h1,
    h2 {
      margin: 0;
      font-family: 'Exo', sans-serif;
      text-align: center;
    }

   
    form {
      margin-top: 20px;
      background-color: #f4f4f4;
      border-radius: 5px;
      padding: 20px;
    }

    label {
      display: block;
      margin-bottom: 10px;
      font-family: 'Exo', sans-serif;
      color: #333;
      font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"],
    input[type="time"],
    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-bottom: 10px;
      font-family: 'Exo', sans-serif;
      transition: border-color 0.3s;
    }

    input[type="submit"] {
      background-color: #333;
      color: #fff;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      transition: background-color 0.3s;
      font-family: 'Exo', sans-serif;
    }

    input[type="submit"]:hover {
      background-color: #555;
    }

   
    input[type="text"]:hover,
    input[type="number"]:hover,
    input[type="date"]:hover,
    input[type="time"]:hover,
    textarea:hover {
      background-color: #f4f4f4;
      border-color: #555;
    }

    input[type="submit"]:hover {
      background-color: grey;
      border-color: #555;
    }

   
    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    .animated {
      animation-duration: 0.5s;
      animation-fill-mode: both;
      animation-name: fadeIn;
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
      display: flex;
      align-items: center;
      margin-left: auto;
    }

    .profile-pic {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 10px;
    }

    .profile-info {
      font-family: 'Exo', sans-serif;
      display: flex;
      flex-direction: column;
      justify-content: center;
      text-align: right;
      color: #fff;
    }

    .profile-info h2,
    .profile-info p {
      margin: 0;
      font-size: 14px;
    }

  </style>
</head>

<body>
  <header>
    <h1>HOSTELHUB</h1>
    <h2 style="padding-top: 15px;">Outpass Request</h2>
    <div class="profile">
      <img class="profile-pic" src="data:image/jpeg;base64,<?php echo base64_encode($profilePic); ?>" alt="Profile Picture">
      <div class="profile-info">
        <h2><?php echo $name; ?></h2>
        <p>ID: <?php echo $studentId; ?></p>
      </div>
    </div>
  </header>
  <button class="home-button"><a href="index.php">
      <span style="color: white;">Home</span></a>
  </button>

  <div class="container">

    <form class="animated" action="outpass.php" method="POST">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="<?php echo $name; ?>" readonly>

      <label for="studentId">Registration ID:</label>
      <input type="text" id="studentId" name="studentId" value="<?php echo $studentId; ?>" readonly>

      <label for="blockName">Block No.:</label>
      <input type="text" id="blockName" name="blockName" value="<?php echo $blockName; ?>" readonly>

      <label for="roomNo">Room No.:</label>
      <input type="text" id="roomNo" name="roomNo" value="<?php echo $roomNo; ?>" readonly>

      <label for="date">Date:</label>
      <input type="date" id="date" name="date" required>

      <label for="placeOfVisit">Place of Visit:</label>
      <input type="text" id="placeOfVisit" name="placeOfVisit" required>

      <label for="address">Address:</label>
      <textarea id="address" name="address" rows="4" required></textarea>

      <label for="noOfDaysProposed">No. of Days Proposed to Stay:</label>
      <input type="number" id="noOfDaysProposed" name="noOfDaysProposed" required>

      <label for="timeOut">Time Out:</label>
      <input type="time" id="timeOut" name="timeOut" required>

      <label for="returnDateTime">Date and Time of Return:</label>
      <input type="datetime-local" id="returnDateTime" name="returnDateTime" required>

      <label for="contactPhone">Contact Phone Number:</label>
      <input type="text" id="contactPhone" name="contactPhone" required>

      <label for="parentPhone">Parent Phone Number:</label>
      <input type="text" id="parentPhone" name="parentPhone" required>

      <input type="submit" value="Submit">
    </form>
  </div>
  <footer>
    <p>&copy; 2023 MIT Hostels. All rights reserved. Designed and Developed by Chanikya Nelapatla</p>
  </footer>
</body>

</html>
