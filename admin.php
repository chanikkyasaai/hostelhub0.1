<?php
session_start();

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'hostelhub';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


function fetchTableData($tableName, $statusColumn) {
  global $conn;
  $sql = "SELECT * FROM $tableName ORDER BY $statusColumn = 'Pending' DESC, $statusColumn";
  $result = mysqli_query($conn, $sql);

  $data = array();
  if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }
  }

  return $data;
}


function updateRowStatus($tableName, $primaryKey, $statusColumn, $primaryKeyValue, $status) {
  global $conn;
  $updateQuery = "UPDATE $tableName SET $statusColumn = '$status' WHERE $primaryKey = '$primaryKeyValue'";
  mysqli_query($conn, $updateQuery);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['maintenance-update'])) {
    $complaintId = $_POST['complaint-id'];
    $status = $_POST['complaint-status'];
    updateRowStatus('maintenance_complaints', 'complaint_id', 'status', $complaintId, $status);
  } elseif (isset($_POST['outpass-update'])) {
    $orId = $_POST['outpass-id'];
    $status = $_POST['outpass-status'];
    updateRowStatus('outpass_details', 'or_id', 'status', $orId, $status);
  } elseif (isset($_POST['docuserve-update'])) {
    $requestId = $_POST['docuserve-id'];
    $status = $_POST['docuserve-status'];
    updateRowStatus('docuserve_requests', 'request_id', 'status', $requestId, $status);
  } elseif (isset($_POST['guesthouse-update'])) {
    $guesthouseId = $_POST['guesthouse-id'];
    $status = $_POST['guesthouse-status'];
    updateRowStatus('guesthouse', 'requestid', 'status', $guesthouseId, $status);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HostelHub Main Page</title>
  <link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100;1,900&family=Space+Mono&family=Zeyada&display=swap" rel="stylesheet">
  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <style>

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f2f2f2;
    }

    header {
      background-color: #333;
      color: #fff;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    header h1 {
      margin: 0;
      font-family: 'Exo', sans-serif;
      text-align: center;
    }

    .container {
      max-width: 1080px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
    }

    .button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-right: 10px;
      transition: background-color 0.3s ease;
    }

    .button:hover {
      background-color: #555;
    }

    .table-container {
      overflow-x: auto;
      padding-top: 50px;
      margin-top: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table,
    th,
    td {
      border: 1px solid #ddd;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
      word-wrap: break-word;
    }

    th {
      background-color: #f2f2f2;
    }

    .update-status-form {
      margin-top: 10px;
    }

    .update-status-form label {
      display: block;
      font-weight: bold;
    }

    .table-scroll-container {
      overflow-x: auto;
    }

    @media screen and (max-width: 768px) {
      header {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <header>
  <h1>HOSTELHUB ADMIN</h1>
>
  </header>

  <div class="container">
    <div class="button" onclick="toggleTable('maintenance-complaints')">Maintenance Complaints</div>
    <div class="button" onclick="toggleTable('outpass-requests')">Outpass Requests</div>
    <div class="button" onclick="toggleTable('docuserve-requests')">Docuserve Requests</div>
    <div class="button" onclick="toggleTable('guesthouse')">Guesthouse</div>

 
    <div class="table-container" id="maintenance-complaints">
      <?php
      $complaintsData = fetchTableData('maintenance_complaints', 'status');

      if (!empty($complaintsData)) {
        echo '<h2>Maintenance Complaints</h2>';
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Complaint ID</th>';
        echo '<th>Student ID</th>';
        echo '<th>Name</th>';
        echo '<th>Room Number</th>';
        echo '<th>Problem</th>';
        echo '<th>Image</th>';
        echo '<th>Time Available</th>';
        echo '<th>Status</th>';
        echo '<th>Update Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($complaintsData as $complaint) {
          echo '<tr>';
          echo '<td>' . $complaint['complaint_id'] . '</td>';
          echo '<td>' . $complaint['student_id'] . '</td>';
          echo '<td>' . $complaint['name'] . '</td>';
          echo '<td>' . $complaint['room_number'] . '</td>';
          echo '<td>' . $complaint['problem'] . '</td>';
          echo '<td><img src="data:image/jpeg;base64,' . base64_encode($complaint['image']) . '" alt="Complaint Image" width="100" height="100"></td>';
          echo '<td>' . $complaint['time_available'] . '</td>';
          echo '<td>' . $complaint['status'] . '</td>';
          echo '<td>';
          echo '<form method="POST">';
          echo '<input type="hidden" name="complaint-id" value="' . $complaint['complaint_id'] . '">';
          echo '<select name="complaint-status">';
          echo '<option value="Pending" ' . ($complaint['status'] === 'Pending' ? 'selected' : '') . '>Pending</option>';
          echo '<option value="Completed" ' . ($complaint['status'] === 'Completed' ? 'selected' : '') . '>Completed</option>';
          echo '</select>';
          echo '<input type="submit" name="maintenance-update" value="Update">';
          echo '</form>';
          echo '</td>';
          echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
      } else {
        echo '<p>No maintenance complaints found.</p>';
      }
      ?>
    </div>

 
    <div class="table-container" id="outpass-requests">
      <?php
      $outpassData = fetchTableData('outpass_details', 'status');

      if (!empty($outpassData)) {
        echo '<h2>Outpass Requests</h2>';
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>OR ID</th>';
        echo '<th>ID</th>';
        echo '<th>Name</th>';
        echo '<th>Student ID</th>';
        echo '<th>Block Name</th>';
        echo '<th>Room No</th>';
        echo '<th>Date</th>';
        echo '<th>Place of Visit</th>';
        echo '<th>Address</th>';
        echo '<th>No of Days Proposed</th>';
        echo '<th>Time Out</th>';
        echo '<th>Return Date Time</th>';
        echo '<th>Contact Phone</th>';
        echo '<th>Parent Phone</th>';
        echo '<th>Status</th>';
        echo '<th>Update Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($outpassData as $outpass) {
          echo '<tr>';
          echo '<td>' . $outpass['or_id'] . '</td>';
          echo '<td>' . $outpass['id'] . '</td>';
          echo '<td>' . $outpass['name'] . '</td>';
          echo '<td>' . $outpass['student_id'] . '</td>';
          echo '<td>' . $outpass['block_name'] . '</td>';
          echo '<td>' . $outpass['room_no'] . '</td>';
          echo '<td>' . $outpass['date'] . '</td>';
          echo '<td>' . $outpass['place_of_visit'] . '</td>';
          echo '<td>' . $outpass['address'] . '</td>';
          echo '<td>' . $outpass['no_of_days_proposed'] . '</td>';
          echo '<td>' . $outpass['time_out'] . '</td>';
          echo '<td>' . $outpass['return_date_time'] . '</td>';
          echo '<td>' . $outpass['contact_phone'] . '</td>';
          echo '<td>' . $outpass['parent_phone'] . '</td>';
          echo '<td>' . $outpass['status'] . '</td>';
          echo '<td>';
          echo '<form method="POST">';
          echo '<input type="hidden" name="outpass-id" value="' . $outpass['or_id'] . '">';
          echo '<select name="outpass-status">';
          echo '<option value="Pending" ' . ($outpass['status'] === 'Pending' ? 'selected' : '') . '>Pending</option>';
          echo '<option value="Approved" ' . ($outpass['status'] === 'Approved' ? 'selected' : '') . '>Approved</option>';
          echo '<option value="Rejected" ' . ($outpass['status'] === 'Rejected' ? 'selected' : '') . '>Rejected</option>';
          echo '</select>';
          echo '<input type="submit" name="outpass-update" value="Update">';
          echo '</form>';
          echo '</td>';
          echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
      } else {
        echo '<p>No outpass requests found.</p>';
      }
      ?>
    </div>

   
    <div class="table-container" id="docuserve-requests">
      <?php
      $docuserveData = fetchTableData('docuserve_requests', 'status');

      if (!empty($docuserveData)) {
        echo '<h2>Docuserve Requests</h2>';
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Request ID</th>';
        echo '<th>ID</th>';
        echo '<th>Name</th>';
        echo '<th>Block Name</th>';
        echo '<th>Room No</th>';
        echo '<th>Mobile</th>';
        echo '<th>Document</th>';
        echo '<th>Request Date</th>';
        echo '<th>Status</th>';
        echo '<th>Update Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($docuserveData as $docuserve) {
          echo '<tr>';
          echo '<td>' . $docuserve['request_id'] . '</td>';
          echo '<td>' . $docuserve['id'] . '</td>';
          echo '<td>' . $docuserve['name'] . '</td>';
          echo '<td>' . $docuserve['block_name'] . '</td>';
          echo '<td>' . $docuserve['room_no'] . '</td>';
          echo '<td>' . $docuserve['mobile'] . '</td>';
          echo '<td>' . $docuserve['document'] . '</td>';
          echo '<td>' . $docuserve['request_date'] . '</td>';
          echo '<td>' . $docuserve['status'] . '</td>';
          echo '<td>';
          echo '<form method="POST">';
          echo '<input type="hidden" name="docuserve-id" value="' . $docuserve['request_id'] . '">';
          echo '<select name="docuserve-status">';
          echo '<option value="Pending" ' . ($docuserve['status'] === 'Pending' ? 'selected' : '') . '>Pending</option>';
          echo '<option value="Completed" ' . ($docuserve['status'] === 'Completed' ? 'selected' : '') . '>Completed</option>';
          echo '</select>';
          echo '<input type="submit" name="docuserve-update" value="Update">';
          echo '</form>';
          echo '</td>';
          echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
      } else {
        echo '<p>No docuserve requests found.</p>';
      }
      ?>
    </div>


<div class="table-container" id="guesthouse">
  <?php
  $guesthouseData = fetchTableData('guesthouse', 'status');

  if (!empty($guesthouseData)) {
    echo '<h2>Guesthouse</h2>';
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Request ID</th>';
    echo '<th>Applicant Name</th>';
    echo '<th>Guest Name</th>';
    echo '<th>Registration Number</th>';
    echo '<th>Relation</th>';
    echo '<th>Applicant Gender</th>';
    echo '<th>Guest Gender</th>';
    echo '<th>Applicant Address</th>';
    echo '<th>Guest Address</th>';
    echo '<th>Mobile Number</th>';
    echo '<th>Applicant Email</th>';
    echo '<th>Guest Email</th>';
    echo '<th>Purpose</th>';
    echo '<th>Required From</th>';
    echo '<th>Required To</th>';
    echo '<th>Check-In</th>';
    echo '<th>Check-Out</th>';
    echo '<th>Accommodation Type</th>';
    echo '<th>Boys Count</th>';
    echo '<th>Girls Count</th>';
    echo '<th>Days Count</th>';
    echo '<th>Total Persons</th>';
    echo '<th>Food Required</th>';
    echo '<th>Rooms Required</th>';
    echo '<th>Status</th>';
    echo '<th>Update Status</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($guesthouseData as $guesthouse) {
      echo '<tr>';
      echo '<td>' . $guesthouse['requestid'] . '</td>';
      echo '<td>' . $guesthouse['applicant_name'] . '</td>';
      echo '<td>' . $guesthouse['guest_name'] . '</td>';
      echo '<td>' . $guesthouse['registration_number'] . '</td>';
      echo '<td>' . $guesthouse['relation'] . '</td>';
      echo '<td>' . $guesthouse['applicant_gender'] . '</td>';
      echo '<td>' . $guesthouse['guest_gender'] . '</td>';
      echo '<td>' . $guesthouse['applicant_address'] . '</td>';
      echo '<td>' . $guesthouse['guest_address'] . '</td>';
      echo '<td>' . $guesthouse['mobile_number'] . '</td>';
      echo '<td>' . $guesthouse['applicant_email'] . '</td>';
      echo '<td>' . $guesthouse['guest_email'] . '</td>';
      echo '<td>' . $guesthouse['purpose'] . '</td>';
      echo '<td>' . $guesthouse['required_from'] . '</td>';
      echo '<td>' . $guesthouse['required_to'] . '</td>';
      echo '<td>' . $guesthouse['check_in'] . '</td>';
      echo '<td>' . $guesthouse['check_out'] . '</td>';
      echo '<td>' . $guesthouse['accommodation_type'] . '</td>';
      echo '<td>' . $guesthouse['boys_count'] . '</td>';
      echo '<td>' . $guesthouse['girls_count'] . '</td>';
      echo '<td>' . $guesthouse['days_count'] . '</td>';
      echo '<td>' . $guesthouse['total_persons'] . '</td>';
      echo '<td>' . $guesthouse['food_required'] . '</td>';
      echo '<td>' . $guesthouse['rooms_required'] . '</td>';
      echo '<td>' . $guesthouse['status'] . '</td>';
      echo '<td>';
      echo '<form method="POST">';
      echo '<input type="hidden" name="guesthouse-id" value="' . $guesthouse['requestid'] . '">';
      echo '<select name="guesthouse-status">';
      echo '<option value="Pending" ' . ($guesthouse['status'] === 'Pending' ? 'selected' : '') . '>Pending</option>';
      echo '<option value="Accepted" ' . ($guesthouse['status'] === 'Accepted' ? 'selected' : '') . '>Accepted</option>';
      echo '</select>';
      echo '<input type="submit" name="guesthouse-update" value="Update">';
      echo '</form>';
      echo '</td>';
      echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
  } else {
    echo '<p>No guesthouse data found.</p>';
  }
  ?>
</div>

  <script>
    function toggleTable(tableName) {
      const tableContainers = document.getElementsByClassName('table-container');
      for (const container of tableContainers) {
        if (container.id === tableName) {
          container.style.display = 'block';
        } else {
          container.style.display = 'none';
        }
      }
    }
  </script>
</body>

</html>

<?php

mysqli_close($conn);
?>
