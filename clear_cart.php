<?php
session_start();

unset($_SESSION['cart']);

$response = array('success' => true);
echo json_encode($response);
?>
