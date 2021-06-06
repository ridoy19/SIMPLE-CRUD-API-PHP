<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content_Type, Access-Control-Allow-Methods, X-Requested-With, Authorization");

require_once('../db/config.php');
require_once('../auth.php');

$isAuthenticated = isAuth();


$json_data = json_decode(file_get_contents("php://input"), true); // Will return an associative arrray

$email = $json_data['email'];


if ($isAuthenticated) {
 
    $sql = "SELECT * FROM employee WHERE email = '$email'";
    $result = mysqli_query($connection, $sql);

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo json_encode($row);
            }
        }else {
            echo json_encode(array("message" => "Not record found"));
        }
    }else {
        echo json_encode(array('message' => $_SERVER['REQUEST_METHOD']. " method not supported!"));
    }
}else {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo json_encode(array('message' => "Authentication failed!"));
}



