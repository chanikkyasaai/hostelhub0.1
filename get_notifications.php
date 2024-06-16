

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

  
  $messages = getCompletedGuesthouseRequests($conn, $userid);

  
  echo json_encode($messages);

} else {
  echo json_encode(array()); 
}


mysqli_close($conn);
?>
