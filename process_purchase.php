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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['student-id'];
    $mobileNumber = $_POST['mobile-number'];
    $totalPrice = $_POST['total-price'];

    
    $studentSql = "SELECT * FROM student_details WHERE id = '$studentId' AND mobile_number = '$mobileNumber'";
    $studentResult = mysqli_query($conn, $studentSql);

    if (mysqli_num_rows($studentResult) > 0) {
        
        $balanceSql = "SELECT store FROM balance WHERE id = '$studentId'";
        $balanceResult = mysqli_query($conn, $balanceSql);

        if (mysqli_num_rows($balanceResult) > 0) {
            $balanceData = mysqli_fetch_assoc($balanceResult);
            $storeBalance = $balanceData['store'];

            if ($storeBalance >= $totalPrice) {
                
                $newBalance = $storeBalance - $totalPrice;
                $updateBalanceSql = "UPDATE balance SET store = '$newBalance' WHERE id = '$studentId'";
                mysqli_query($conn, $updateBalanceSql);

                
                $insertPurchaseSql = "INSERT INTO store (id, total_price) VALUES ('$studentId', '$totalPrice')";
                mysqli_query($conn, $insertPurchaseSql);

                
                unset($_SESSION['cart']);

                
                $response = array('success' => true);
                echo json_encode($response);
                exit();
            } else {
                $message = "Insufficient store balance!";
            }
        } else {
            $message = "Store balance not found!";
        }
    } else {
        $message = "Invalid student ID or mobile number!";
    }

    
    $response = array('success' => false, 'message' => $message);
    echo json_encode($response);
}
?>
