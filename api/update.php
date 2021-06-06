<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
header("Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content_Type, Access-Control-Allow-Methods, X-Requested-With, Authorization");


require_once("../db/config.php");
require_once('../auth.php');

$isAuthenticated = isAuth();


$json_data = json_decode(file_get_contents("php://input"), true);

$name = $json_data["name"];
$email = $json_data["email"];
$age = $json_data["age"];
$designation = $json_data["designation"];


if ($isAuthenticated) {
    if ($_SERVER["REQUEST_METHOD"] === "PUT") {
    
        $records = "SELECT * FROM employee WHERE email = '$email'";
        $result = mysqli_query($connection, $records);
    
        if (mysqli_num_rows($result) > 0) {
            if (empty($name) || empty($email) || empty($age)  || empty($designation)) {
                echo json_encode(array('message' => "Fields can't be empty!'"));
            }else {
                $sql = "UPDATE employee SET name = '$name', age = '$age', designation = '$designation' WHERE email = '$email'";
                
                if (mysqli_query($connection, $sql)) {
                    echo json_encode(array("message" => "Employee updated successfully!"));
                }else {
                    echo json_encode(array('message' => "Something went wrong!"));
                }            
            }   
        }else {
            echo json_encode(array('message' => "Email adress not found!"));    
        }
    }else {
        echo json_encode(array('message' => $_SERVER['REQUEST_METHOD']. " method not supported!"));
    }
    
}else {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo json_encode(array('message' => "Authentication failed!"));
}



