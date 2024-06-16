<?php

session_start();

if (!isset($_SESSION['userid'])) {

  header("Location: login.php");
  exit();
}

$userid = $_SESSION['userid'];

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'hostelhub';


$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


$query = "SELECT * FROM student_details WHERE id = '$userid'";
$result = mysqli_query($conn, $query);


if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $name = $row['name'];
  $profilePic = $row['profile_pic'];
  $profilePicData = base64_encode($profilePic);
} else {

  $name = "User not found";
  $profilePicData = ""; 
}


$balanceQuery = "SELECT store FROM balance WHERE id = '$userid'";
$balanceResult = mysqli_query($conn, $balanceQuery);


if ($balanceResult && mysqli_num_rows($balanceResult) > 0) {
  $balanceRow = mysqli_fetch_assoc($balanceResult);
  $walletBalance = $balanceRow['store'];
} else {
  
  $walletBalance = 0;
}


$purchasesQuery = "SELECT * FROM store WHERE id = '$userid'";
$purchasesResult = mysqli_query($conn, $purchasesQuery);


$itemsQuery = "SELECT * FROM products";
$itemsResult = mysqli_query($conn, $itemsQuery);

$storeStatusQuery = "SELECT status FROM status WHERE service = 'store'";
$storeStatusResult = mysqli_query($conn, $storeStatusQuery);

if ($storeStatusResult && mysqli_num_rows($storeStatusResult) > 0) {
  $storeStatusRow = mysqli_fetch_assoc($storeStatusResult);
  $storeStatus = $storeStatusRow['status'];
} else {
  $storeStatus = 'closed'; 
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MIT Hostels - Store</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100;1,900&family=Space+Mono&family=Zeyada&display=swap" rel="stylesheet">

  <style>
    /* Global Styles */
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

    /* Header Styles */
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
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    position: relative; 
  }

    .header h1 {
      margin: 0;
      font-size: 24px;
      color: #333;
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
      margin-bottom: 20px;
    }

    .section {
      margin-bottom: 20px;
    }

    .section-button {
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 5px;
      padding: 10px 20px;
      cursor: pointer;
      font-size: 16px;
      margin-right: 10px;
    }

    .section-content {
      display: none;
      margin-top: 10px;
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

    .section-content.active {
      display: block;
    }

    .card {
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      margin-bottom: 10px;
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .card-header h3 {
      margin: 0;
      font-size: 20px;
      color: #333;
    }

    .card-header button {
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 5px;
      padding: 5px 10px;
      cursor: pointer;
    }

    .card-header button:hover {
      background-color: #555;
    }

    .card-content p {
      margin: 0;
      font-size: 16px;
      color: #333;
    }

    .item-card {
      display: flex;
      flex-wrap: wrap;
    }

    .item-card__item {
      width: 200px;
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      margin-right: 10px;
      margin-bottom: 10px;
    }

    .item-card__image {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 5px;
    }

    .item-card__name {
      font-size: 16px;
      margin: 5px 0;
      color: #333;
    }

    .item-card__stock {
      font-size: 14px;
      color: #777;
    }

    .item-card__price {
      font-size: 18px;
      font-weight: bold;
      margin-top: 5px;
      color: #333;
    }


    @keyframes wallet-pulse {
      0% {
        transform: scale(1);
        background-color: #333;
      }

      50% {
        transform: scale(1.2);
        background-color: #4CAF50;
      }

      100% {
        transform: scale(1);
        background-color: #333;
      }
    }

    .balance {
      color: #fff;
      margin-top: 10px;
      font-size: 16px;
      font-weight: bold;
      font-family: 'Exo', sans-serif;
    }

    .Store-status {
      display: flex;
      align-items: center;
      margin-top: 10px;
    }

    .Store-status-text {
      font-size: 16px;
      margin-left: 5px;
      font-family: 'Exo', sans-serif;
    }

    .Store-status-sticker {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      margin-left: 5px;
    }

    .Store-status-open {
      background-color: #4CAF50;
    }

    .Store-status-closed {
      background-color: #ddd;
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
  .store-status {
      display: flex;
      align-items: center;
      margin-top: 10px;
    }

    .store-status-text {
      font-size: 16px;
      margin-left: 5px;
      font-family: 'Exo', sans-serif;
    }

    .store-status-sticker {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      margin-left: 5px;
    }

    .store-status-open {
      background-color: #4CAF50;
    }

    .store-status-closed {
      background-color: #df4242;
    }
  </style>
</head>

<body>

  <header>
    <h1 style="text-align: center; font-family: 'Exo', sans-serif;">HOSTELHUB</h1>

    <h2 style="text-align: center; font-family: 'Exo', sans-serif;">Store</h2>
    <div class="balance">Wallet Balance: <?php echo $walletBalance; ?> Rs</div>
    <div class="store-status">
        <div class="store-status-sticker <?php echo ($storeStatus === 'open') ? 'store-status-open' : 'store-status-closed'; ?>"></div>
        <span class="store-status-text">store is <?php echo ($storeStatus === 'open') ? 'Open' : 'Closed'; ?></span>
        <button class="home-button"><a href="index.php"><span style="color: white;">Home</span></a></button>
      </div>
    <div class="profile">
      <img src="data:image/jpeg;base64,<?php echo $profilePicData; ?>" alt="Profile Picture">
      <span style="color: white;"><?php echo $name; ?> <br> <p>ID: <?php echo $userid; ?></p></span>
      
      
    </div>
  </header>
  <br>
  <div class="sections">
    <div class="section">
      <div class="section-button" onclick="toggleSection('shopping-diary')">Shopping Diary</div>
      <div id="shopping-diary" class="section-content">
        <?php
        if ($purchasesResult && mysqli_num_rows($purchasesResult) > 0) {
          while ($purchase = mysqli_fetch_assoc($purchasesResult)) {
            $ticketId = $purchase['ticketid'];
            $purchaseDate = $purchase['date_created'];
            $totalPrice = $purchase['total_price'];
        ?>
            <div class="card">
              <div class="card-header">
                <h3>Purchase Details</h3>
                <button>Print</button>
              </div>
              <div class="card-content">
                <p>Ticket ID: <?php echo $ticketId; ?></p>
                <p>Date Created: <?php echo $purchaseDate; ?></p>
                <p>Total Price: Rs. <?php echo $totalPrice; ?></p>
              </div>
            </div>
        <?php
          }
        } else {
          echo "<p>No purchases found.</p>";
        }
        ?>
      </div>
    </div>
    <div class="section">
      <div class="section-button" onclick="toggleSection('explore-items')">Explore Items</div>
      <div id="explore-items" class="section-content">
        <div class="item-card">
          <?php
          if ($itemsResult && mysqli_num_rows($itemsResult) > 0) {
            while ($item = mysqli_fetch_assoc($itemsResult)) {
              $itemId = $item['productid'];
              $itemName = $item['name'];
              $itemImage = base64_encode($item['image']);
              $itemPrice = $item['price'];
              $itemStatus = $item['status'];
          ?>
              <div class="item-card__item">
                <img class="item-card__image" src="data:image/jpeg;base64,<?php echo $itemImage; ?>" alt="<?php echo $itemName; ?>">
                <div class="item-card__name"><?php echo $itemName; ?></div>
                <div class="item-card__stock"><?php echo $itemStatus; ?></div>
                <div class="item-card__price">Rs. <?php echo $itemPrice; ?></div>
              </div>
          <?php
            }
          } else {
            echo "<p>No items found.</p>";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  </div>

  <script>
    function toggleSection(sectionId) {
      var section = document.getElementById(sectionId);
      section.classList.toggle('active');
    }
  </script>
  <footer>
    <p>&copy; 2023 MIT Hostels. All rights reserved. Designed and Developed by Chanikya Nelapatla</p>
  </footer>
</body>

</html>
