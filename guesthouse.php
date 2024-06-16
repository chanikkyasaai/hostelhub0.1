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


$query = "SELECT name, email FROM student_details WHERE id = '$studentId'";
$result = mysqli_query($conn, $query);


if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $name = $row['name'];
  $email = $row['email'];
} else {
  
  $name = ""; 
  $email = ""; 
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $applicantName = isset($_POST['applicant-name']) ? $_POST['applicant-name'] : "";
  $guestName = isset($_POST['guest-name']) ? $_POST['guest-name'] : "";
  $registrationNumber = isset($_POST['registration-number']) ? $_POST['registration-number'] : "";
  $relation = isset($_POST['relation']) ? $_POST['relation'] : "";
  $applicantGender = isset($_POST['applicant-gender']) ? $_POST['applicant-gender'] : "";
  $guestGender = isset($_POST['guest-gender']) ? $_POST['guest-gender'] : "";
  $applicantAddress = isset($_POST['applicant-address']) ? $_POST['applicant-address'] : "";
  $guestAddress = isset($_POST['guest-address']) ? $_POST['guest-address'] : "";
  $mobileNumber = isset($_POST['mobile-number']) ? $_POST['mobile-number'] : "";
  $applicantEmail = isset($_POST['applicant-email']) ? $_POST['applicant-email'] : "";
  $guestEmail = isset($_POST['guest-email']) ? $_POST['guest-email'] : "";
  $purpose = isset($_POST['purpose']) ? $_POST['purpose'] : "";
  $requiredFrom = isset($_POST['required-from']) ? $_POST['required-from'] : "";
  $requiredTo = isset($_POST['required-to']) ? $_POST['required-to'] : "";
  $checkIn = isset($_POST['check-in']) ? $_POST['check-in'] : "";
  $checkOut = isset($_POST['check-out']) ? $_POST['check-out'] : "";
  $accommodationType = isset($_POST['accommodation-type']) ? $_POST['accommodation-type'] : "";
  $boysCount = isset($_POST['boys-count']) ? $_POST['boys-count'] : "";
  $girlsCount = isset($_POST['girls-count']) ? $_POST['girls-count'] : "";
  $daysCount = isset($_POST['days-count']) ? $_POST['days-count'] : "";
  $totalPersons = isset($_POST['total-persons']) ? $_POST['total-persons'] : "";
  $foodRequired = isset($_POST['food']) ? implode(", ", $_POST['food']) : "";
  $roomsRequired = isset($_POST['rooms-required']) ? $_POST['rooms-required'] : "";

  


$query = "INSERT INTO guesthouse (applicant_name, guest_name, registration_number, relation, applicant_gender, guest_gender, applicant_address, guest_address, mobile_number, applicant_email, guest_email, purpose, required_from, required_to, check_in, check_out, accommodation_type, boys_count, girls_count, days_count, total_persons, food_required, rooms_required) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssssi", $applicantName, $guestName, $registrationNumber, $relation, $applicantGender, $guestGender, $applicantAddress, $guestAddress, $mobileNumber, $applicantEmail, $guestEmail, $purpose, $requiredFrom, $requiredTo, $checkIn, $checkOut, $accommodationType, $boysCount, $girlsCount, $daysCount, $totalPersons, $foodRequired, $roomsRequired);


if (mysqli_stmt_execute($stmt)) {
  
  mysqli_stmt_close($stmt);

  
  echo "<script>alert('Request submitted successfully'); window.location.href = 'index.php';</script>";
  exit();
} else {
  
  echo "Error: " . mysqli_error($conn);
}





  
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
  <title>MIT Hostels Website - Guest House Booking Form</title>
  <link rel="stylesheet" href="styles.css">
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
    }

    header h1,
    header h2 {
      margin: 0;
      font-family: 'Exo', sans-serif;
      text-align: center;
    }

   
    .form-container {
      display: flex;
      justify-content: space-between;
      border: 1px solid #ccc;
      border-radius: 4px;
      overflow: hidden;
      margin-bottom: 20px;
    }

    .form-column {
      flex: 1;
      padding: 10px;
      transition: all 0.3s ease;
    }

    .form-column:hover {
      background-color: #f9f9f9;
      transform: scale(1.02);
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      font-weight: bold;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .form-group input[type="submit"] {
      background-color: #333;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      cursor: pointer;
    }


   
    footer {
      background-color: #333;
      color: #fff;
      padding: 10px;
      text-align: center;
    }

    footer p {
      margin: 0;
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
  </style>
</head>

<body>
  <button class="home-button"><a href="index.php">
      <span style="color: white;">Home</span></a>
  </button>
  <header>
    <h1>HOSTELHUB</h1>
    <h2 style="padding-top: 50px;">GUEST HOUSE REQUISITION FORM</h2>
  </header>

  <div class="container">
    <p>Date: <span id="current-date"></span></p>

    <div class="form-container">
      <div class="form-column">
        <h3>Applicant Details</h3>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
          <div class="form-group">
            <label for="applicant-name">Applicant Name:</label>
            <input type="text" id="applicant-name" name="applicant-name" value="<?php echo $name; ?>" readonly required>
          </div>
          <div class="form-group">
            <label for="guest-name">Guest/Visitor Name:</label>
            <input type="text" id="guest-name" name="guest-name" required>
          </div>
          <div class="form-group">
            <label for="registration-number">Registration Number:</label>
            <input type="text" id="registration-number" name="registration-number" value="<?php echo $studentId; ?>" readonly required>
          </div>
          <div class="form-group">
            <label for="relation">Relation with the Applicant:</label>
            <input type="text" id="relation" name="relation" required>
          </div>
          <div class="form-group">
            <label for="applicant-gender">Gender of Applicant:</label>
            <select id="applicant-gender" name="applicant-gender" required>
              <option value="">Select Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="form-group">
            <label for="guest-gender">Gender of Guest/Visitor:</label>
            <select id="guest-gender" name="guest-gender" required>
              <option value="">Select Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="form-group">
            <label for="applicant-address">Address of Applicant:</label>
            <textarea id="applicant-address" name="applicant-address" required></textarea>
          </div>
          <div class="form-group">
            <label for="guest-address">Address of Guest/Visitor:</label>
            <textarea id="guest-address" name="guest-address" required></textarea>
          </div>
          <div class="form-group">
            <label for="mobile-number">Mobile Number:</label>
            <input type="tel" id="mobile-number" name="mobile-number" required>
          </div>
          <div class="form-group">
            <label for="applicant-email">Email (Applicant):</label>
            <input type="email" id="applicant-email" name="applicant-email" value="<?php echo $email; ?>" readonly required>
          </div>
          <div class="form-group">
            <label for="guest-email">Email (Guest/Visitor):</label>
            <input type="email" id="guest-email" name="guest-email" required>
          </div>
          <div class="form-group">
            <label for="purpose">Purpose of Visit:</label>
            <input type="text" id="purpose" name="purpose" required>
          </div>
          <div class="form-group">
            <input type="submit" value="Submit">
          </div>
      </div>

      <div class="form-column">
        <h3>Accommodation Details</h3>
      
          <div class="form-group">
            <label for="required-from">Required From:</label>
            <input type="date" id="required-from" name="required-from" required>
          </div>
          <div class="form-group">
            <label for="required-to">Required To:</label>
            <input type="date" id="required-to" name="required-to" required>
          </div>
          <div class="form-group">
            <label for="check-in">Check-In Time:</label>
            <input type="time" id="check-in" name="check-in" required>
          </div>
          <div class="form-group">
            <label for="check-out">Check-Out Time:</label>
            <input type="time" id="check-out" name="check-out" required>
          </div>
          <div class="form-group">
            <label for="accommodation-type">Accommodation Type:</label>
            <select id="accommodation-type" name="accommodation-type" required>
              <option value="">Select Type</option>
              <option value="single">Single Room</option>
              <option value="double">Double Room</option>
              <option value="suite">Suite</option>
            </select>
          </div>
          <div class="form-group">
            <label for="boys-count">Number of Boys:</label>
            <input type="number" id="boys-count" name="boys-count" required>
          </div>
          <div class="form-group">
            <label for="girls-count">Number of Girls:</label>
            <input type="number" id="girls-count" name="girls-count" required>
          </div>
          <div class="form-group">
            <label for="days-count">Number of Days:</label>
            <input type="number" id="days-count" name="days-count" required>
          </div>
          <div class="form-group">
            <label for="total-persons">Total Number of Persons:</label>
            <input type="number" id="total-persons" name="total-persons" required>
          </div>
          <!-- ...previous code... -->
          <div class="form-group">
            <label for="food">Food Required:</label>
            <div>
              <input type="checkbox" id="breakfast" name="food[]" value="breakfast">
              <label for="breakfast">Breakfast</label>
            </div>
            <div>
              <input type="checkbox" id="lunch" name="food[]" value="lunch">
              <label for="lunch">Lunch</label>
            </div>
            <div>
              <input type="checkbox" id="dinner" name="food[]" value="dinner">
              <label for="dinner">Dinner</label>
            </div>
          </div>
          <!-- ...continue with the rest of the code... -->

          <div class="form-group">
            <label for="rooms-required">Number of Rooms Required:</label>
            <input type="number" id="rooms-required" name="rooms-required" required>
          </div>
        </form>
      </div>
    </div>
  </div>

  <footer>
    <p>MIT Hostels &copy; 2023</p>
  </footer>

  <script>
    
    var currentDate = new Date();
    var day = currentDate.getDate();
    var month = currentDate.getMonth() + 1;
    var year = currentDate.getFullYear();
    var formattedDate = day + "-" + month + "-" + year;
    document.getElementById("current-date").innerHTML = formattedDate;
  </script>
</body>

</html>
