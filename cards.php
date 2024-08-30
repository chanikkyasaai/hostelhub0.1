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

  $query = "SELECT o.id, o.name, o.student_id, o.block_name, o.room_no, o.date, o.place_of_visit, o.address, o.no_of_days_proposed, o.time_out, o.return_date_time, o.contact_phone, o.parent_phone, o.status, s.name AS student_name, s.profile_pic 
            FROM outpass_details o
            JOIN student_details s ON o.student_id = s.id
            WHERE o.id = '$userid' AND o.status = 'approved'
            ORDER BY o.return_date_time DESC";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
  
      $name = $row['student_name'];
      $profilePic = 'data:image/jpeg;base64,' . base64_encode($row['profile_pic']);
      $studentId = $row['student_id'];
      $blockName = $row['block_name'];
      $roomNo = $row['room_no'];
      $date = $row['date'];
      $placeOfVisit = $row['place_of_visit'];
      $address = $row['address'];
      $returnDateTime = $row['return_date_time'];
      $status = $row['status'];
?>

   
      <!DOCTYPE html>
      <html lang="en">

      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Outpass Card</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100;1,900&family=Space+Mono&family=Zeyada&display=swap" rel="stylesheet">
        <style>
        
          body {
            font-family: 'Exo', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
          }

          .outpass-card {
            max-width: 300px;
            width: 100%;
            background-color: #fff;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
          }

          .profile-pic {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
            object-fit: cover;
          }

          .outpass-card h3 {
            margin: 0;
            font-size: 20px;
            color: #333;
            text-align: center;
          }

          .outpass-card p {
            margin: 0;
            margin-bottom: 5px;
            color: #555;
          }

          .outpass-card .label {
            font-weight: bold;
          }

          .outpass-card .status {
            font-weight: bold;
            color: #4CAF50;
            text-transform: uppercase;
          }

          .outpass-card .date-time {
            font-style: italic;
          }

          .outpass-card .address {
            white-space: pre-wrap;
          }

          .outpass-card .place {
            text-decoration: underline;
            cursor: pointer;
            color: #0000EE;
          }

          .outpass-card .place:hover {
            text-decoration: none;
          }

          .outpass-card .contact {
            color: #0000EE;
            text-decoration: underline;
            cursor: pointer;
          }

          .outpass-card .contact:hover {
            text-decoration: none;
          }

          /* Attractive design */
          .mini-card {
            position: relative;
            background-color: #e4f7ff;
            border-radius: 8px;
            padding: 12px;
            margin-top: 20px;
          }

          .mini-card:before {
            content: '';
            position: absolute;
            top: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-bottom: 5px solid #e4f7ff;
          }

          .mini-card:after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #e4f7ff;
          }
        </style>
      </head>

      <body>
        <div class="outpass-card">
          <img class="profile-pic" src="<?php echo $profilePic; ?>" alt="Profile Picture">
          <h3><?php echo $name; ?></h3>
          <div class="mini-card">
            <p class="label">Student ID:</p>
            <p><?php echo $studentId; ?></p>
            <p class="label">Block Name:</p>
            <p><?php echo $blockName; ?></p>
            <p class="label">Room No:</p>
            <p><?php echo $roomNo; ?></p>
            <p class="label">Date of Outpass:</p>
            <p><?php echo $date; ?></p>
            <p class="label">Place of Visit:</p>
            <p><span class="place"><?php echo $placeOfVisit; ?></span></p>
            <p class="label">Address:</p>
            <p class="address"><?php echo $address; ?></p>
            <p class="label">Return Date and Time:</p>
            <p class="date-time"><?php echo $returnDateTime; ?></p>
            <p class="label">Status:</p>
            <p class="status"><?php echo $status; ?></p>
            <p class="label">Contact Phone:</p>
            <p><a class="contact" href="tel:<?php echo $row['contact_phone']; ?>"><?php echo $row['contact_phone']; ?></a></p>
            <p class="label">Parent Phone:</p>
            <p><a class="contact" href="tel:<?php echo $row['parent_phone']; ?>"><?php echo $row['parent_phone']; ?></a></p>
          </div>
        </div>
      </body>

      </html>
<?php
    } 
  } else {
    echo 'No approved outpasses found.';
    exit;
  }
} else {
  echo 'User ID not found.';
  exit;
}

mysqli_close($conn);
?>
