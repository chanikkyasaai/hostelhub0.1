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


$query = "SELECT id, name, block_name, room_no ,profile_pic FROM student_details WHERE id = '$studentId'";
$result = mysqli_query($conn, $query);


if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $id = $row['id'];
  $name = $row['name'];
  $blockName = $row['block_name'];
  $roomNo = $row['room_no'];
  $profilePic = $row['profile_pic'];
} else {
  
  $id = ""; 
  $name = ""; 
  $blockName = ""; 
  $roomNo = ""; 
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $mobile = $_POST['mobile'];
  $document = $_POST['document'];

  
  $query = "INSERT INTO docuserve_requests (id, name, block_name, room_no, mobile, document) VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "ssssss", $id, $name, $blockName, $roomNo, $mobile, $document);

  
  if (mysqli_stmt_execute($stmt)) {
    
    mysqli_stmt_close($stmt);

    
    echo "<script>alert('Request submitted successfully'); window.location.href = 'index.php';</script>";
    exit();
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
  <title>DocuServe Request - MIT Hostels Website</title>
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
    input[type="email"],
    input[type="tel"],
    select,
    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-bottom: 10px;
      font-family: 'Exo', sans-serif;
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
    <h2 style="padding-top: 15px;">DocuServe Request</h2>
    <div class="profile">
      <img class="profile-pic" src="data:image/jpeg;base64,<?php echo base64_encode($profilePic); ?>" alt="Profile Picture">
      <div class="profile-info">
        <h2><?php echo $name; ?></h2>
        <p>ID: <?php echo $studentId; ?></p>
      </div>
    </div>
  </header>

  <div class="container">

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="<?php echo $name; ?>" readonly required>

      <label for="mobile">Mobile Number:</label>
      <input type="tel" id="mobile" name="mobile" required>

      <label for="course">Block & Room No.:</label>
      <input type="text" id="course" name="course" value="<?php echo $blockName . ' - ' . $roomNo; ?>" readonly required>

      <label for="document">Document Required:</label>
      <textarea id="document" name="document" rows="4" required></textarea>

      <input type="submit" value="Submit">
    </form>
    <button class="home-button"><a href="index.html">
        <span style="color: white;">Home</span></a>
    </button>

  </div>
  <footer>
    <p>&copy; 2023 MIT Hostels. All rights reserved. Designed and Developed by Chanikya Nelapatla</p>
  </footer>
</body>

</html>
