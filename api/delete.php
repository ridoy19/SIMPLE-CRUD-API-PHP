<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');
header("Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content_Type, Access-Control-Allow-Methods, X-Requested-With, Authorization");

require_once('../db/config.php');
require_once('../auth.php');

$isAuthenticated = isAuth();


$json_data = json_decode(file_get_contents("php://input"), true); // Will return an associative arrray

$email = $json_data['email'];


if ($isAuthenticated) {
    
    $sql = "DELETE FROM employee WHERE email = '$email'";

    if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
        if (mysqli_query($connection, $sql)) {
            echo json_encode(array("message" => $email. " => deleted successfully!"));
        }else {
            echo json_encode(array("message" => "Not record found"));
        }
    }else {
        echo json_encode(array('message' => $_SERVER['REQUEST_METHOD']. " method not supported!"));
    }
}else {
    echo json_encode(array('message' => "Authentication failed!"));
}



