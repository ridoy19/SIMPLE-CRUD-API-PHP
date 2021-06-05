<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow this api to call from anywhere
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content_Type, Access-Control-Allow-Methods, X-Requested-With, Authorization");

require_once('../db/config.php');


$sql = 'SELECT * FROM employee';
$result = mysqli_query($connection, $sql);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
            echo json_encode(array("message" => "Success", "data" => $row));
        }
    }else {
        echo json_encode(array('message' => "Not found!", "data" => []));
    }
}else {
    echo json_encode(array('message' => $_SERVER['REQUEST_METHOD']. " method not supported!"));
}

