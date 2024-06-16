<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'hostelhub';


$conn = mysqli_connect($host, $username, $password, $dbname);


if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student-id']) && isset($_POST['etc']) && isset($_POST['cost'])) {
  $studentId = $_POST['student-id'];
  $etc = $_POST['etc'];
  $cost = $_POST['cost'];

  
  $balanceQuery = "SELECT laundry FROM balance WHERE id = '$studentId'";
  $balanceResult = mysqli_query($conn, $balanceQuery);

  if ($balanceResult && mysqli_num_rows($balanceResult) > 0) {
    $balanceRow = mysqli_fetch_assoc($balanceResult);
    $laundryBalance = $balanceRow['laundry'];

    
    if ($laundryBalance >= $cost) {
      
      $insertQuery = "INSERT INTO laundry (id, etc, cost, status) VALUES ('$studentId', '$etc', '$cost', 'received')";
      $insertResult = mysqli_query($conn, $insertQuery);

      if ($insertResult) {
        echo '<script>alert("Order placed successfully!");</script>';

        
        $updatedBalance = $laundryBalance - $cost;
        $updateBalanceQuery = "UPDATE balance SET laundry = '$updatedBalance' WHERE id = '$studentId'";
        $updateBalanceResult = mysqli_query($conn, $updateBalanceQuery);
      } else {
        echo '<script>alert("Error placing the order.");</script>';
      }
    } else {
      echo '<script>alert("No sufficient balance in the laundry account.");</script>';
    }
  }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ticket-id-update']) && isset($_POST['status'])) {
  $ticketId = $_POST['ticket-id-update'];
  $status = $_POST['status'];

  
  $updateStatusQuery = "UPDATE laundry SET status = '$status' WHERE ticketid = '$ticketId'";
  $updateStatusResult = mysqli_query($conn, $updateStatusQuery);

  if ($updateStatusResult) {
    echo '<script>alert("Order status updated successfully!");</script>';
  } else {
    echo '<script>alert("Error updating the order status.");</script>';
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ticket-id-delete'])) {
  $ticketId = $_POST['ticket-id-delete'];

  
  $orderQuery = "SELECT * FROM laundry WHERE ticketid = '$ticketId'";
  $orderResult = mysqli_query($conn, $orderQuery);

  if ($orderResult && mysqli_num_rows($orderResult) > 0) {
    $orderRow = mysqli_fetch_assoc($orderResult);
    $cost = $orderRow['cost'];
    $studentId = $orderRow['id'];

    
    $deleteQuery = "DELETE FROM laundry WHERE ticketid = '$ticketId'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
      echo '<script>alert("Order deleted successfully!");</script>';

      
      $balanceQuery = "SELECT laundry FROM balance WHERE id = '$studentId'";
      $balanceResult = mysqli_query($conn, $balanceQuery);

      if ($balanceResult && mysqli_num_rows($balanceResult) > 0) {
        $balanceRow = mysqli_fetch_assoc($balanceResult);
        $laundryBalance = $balanceRow['laundry'];

        
        $updatedBalance = $laundryBalance + $cost;
        $updateBalanceQuery = "UPDATE balance SET laundry = '$updatedBalance' WHERE id = '$studentId'";
        $updateBalanceResult = mysqli_query($conn, $updateBalanceQuery);

        if ($updateBalanceResult) {
          echo '<script>alert("Laundry balance updated successfully!");</script>';
        } else {
          echo '<script>alert("Error updating the laundry balance.");</script>';
        }
      }
    } else {
      echo '<script>alert("Error deleting the order.");</script>';
    }
  }
}

if (isset($_POST['update-laundry-status'])) {
  $laundryStatus = $_POST['laundry-status'];

  
  $statusCheckSql = "SELECT * FROM status WHERE service = 'laundry'";
  $statusCheckResult = mysqli_query($conn, $statusCheckSql);

  if (mysqli_num_rows($statusCheckResult) > 0) {
      
      $updateStatusSql = "UPDATE status SET status = '$laundryStatus' WHERE service = 'laundry'";
      mysqli_query($conn, $updateStatusSql);
  } else {
      
      $insertStatusSql = "INSERT INTO status (service, status) VALUES ('laundry', '$laundryStatus')";
      mysqli_query($conn, $insertStatusSql);
  }
}




$query = "SELECT * FROM laundry ORDER BY date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MIT Hostels Website - Laundry Orders</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="preconnect" href="https:
  <link rel="preconnect" href="https:
  <link rel="preconnect" href="https:
  <link href="https:
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
    }

    header h1,
    header h2 {
      margin: 0;
      font-family: 'Exo', sans-serif;
      text-align: center;
    }

   
    .form-container {
      border: 1px solid #ccc;
      border-radius: 4px;
      overflow: hidden;
      margin-bottom: 20px;
    }

    .form-column {
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

   
    table {
      width: 100%;
      border-collapse: collapse;
    }

    table th,
    table td {
      padding: 8px;
      border: 1px solid #ccc;
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
    .status-container {
            flex: 1;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .status-container h2 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 18px;
            color: #333;
        }

        .status-data {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin: 0;
            padding: 5px 0;
        }

        .update-status-form {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .update-status-form label {
            font-size: 14px;
            font-weight: bold;
           
            margin-right: 5px;
        }

        .update-status-form select {
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
        }

        .update-status-form button {
            padding: 6px 12px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 14px;
            margin-left: 5px;
        }

        .update-status-form button:hover {
            background-color: #555;
        }
  </style>
</head>

<body>
  <header>
    <h1>HOSTELHUB</h1>
    <h2>Laundry Admin</h2>
             <!-- Status Section -->
             <div class="status-container">
            <h2>Status</h2>
            <?php
            
            $statusSql = "SELECT * FROM status WHERE service = 'laundry'";
            $statusResult = mysqli_query($conn, $statusSql);

            if (mysqli_num_rows($statusResult) > 0) {
                while ($row = mysqli_fetch_assoc($statusResult)) {
                    echo "<p>Status of Laundry: <strong>{$row['status']}</strong></p>";
                }
            }
            ?>

            <!-- Form to update status for the laundry -->
            <form method="POST" class="update-status-form">
                <label for="laundry-status">laundry Status:</label>
                <select name="laundry-status" required>
                    <option value="open">Open</option>
                    <option value="close">Close</option>
                </select>
                <button type="submit" name="update-laundry-status">Update</button>
            </form>
        </div>
    </header>
  </header>

  <div class="container">
    <div class="form-container">
      <div class="form-column">
        <h3>Create New Order</h3>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="form-group">
            <label for="student-id">Student ID:</label>
            <input type="text" id="student-id" name="student-id" required>
          </div>
          <div class="form-group">
            <label for="etc">ETC:</label>
            <input type="datetime-local" id="etc" name="etc" required>
          </div>
          <div class="form-group">
            <label for="cost">Cost:</label>
            <input type="text" id="cost" name="cost" required>
          </div>
          <div class="form-group">
            <input type="submit" value="Create Order">
          </div>
        </form>
      </div>
    </div>

    <div class="form-container">
      <div class="form-column">
        <h3>Update Order Status</h3>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="form-group">
            <label for="ticket-id-update">Ticket ID:</label>
            <input type="text" id="ticket-id-update" name="ticket-id-update" required>
          </div>
          <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" required>
              <option value="">Select Status</option>
              <option value="received">received</option>
              <option value="washing">washing</option>
              <option value="pending">pending</option>
              <option value="delivered">delivered</option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" value="Update Status">
          </div>
        </form>
      </div>
    </div>

    <div class="form-container">
      <div class="form-column">
        <h3>Delete Order</h3>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="form-group">
            <label for="ticket-id-delete">Ticket ID:</label>
            <input type="text" id="ticket-id-delete" name="ticket-id-delete" required>
          </div>
          <div class="form-group">
            <input type="submit" value="Delete Order">
          </div>
        </form>
      </div>
    </div>

    <?php
    if (mysqli_num_rows($result) > 0) {
      
      echo '<h3>Laundry Orders</h3>';
      echo '<table>';
      echo '<tr><th>Ticket ID</th><th>ID</th><th>Date</th><th>ETC</th><th>Delivery</th><th>Cost</th><th>Status</th></tr>';

      while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['ticketid'] . '</td>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['date'] . '</td>';
        echo '<td>' . $row['etc'] . '</td>';
        echo '<td>' . $row['delivery'] . '</td>';
        echo '<td>' . $row['cost'] . '</td>';
        echo '<td>' . $row['status'] . '</td>';
        echo '</tr>';
      }

      echo '</table>';
    } else {
      echo '<h3>No orders found.</h3>';
    }
    ?>
  </div>

  <footer>
    <p>MIT Hostels &copy; 2023</p>
  </footer>

  <script>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['student-id']) && isset($_POST['etc']) && isset($_POST['cost'])) {
        
      } elseif (isset($_POST['ticket-id-update']) && isset($_POST['status'])) {
        
      } elseif (isset($_POST['ticket-id-delete'])) {
        
      }
    }
    ?>
  </script>
</body>

</html>
