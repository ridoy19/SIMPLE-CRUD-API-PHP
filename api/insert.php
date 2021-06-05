<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content_Type, Access-Control-Allow-Methods, X-Requested-With, Authorization");

$js_name = json_decode(file_get_contents("php://input"), true);
$js_email = json_decode(file_get_contents("php://input"), true);
$js_age = json_decode(file_get_contents("php://input"), true);
$js_designation = json_decode(file_get_contents("php://input"), true);


$name = $js_name["name"];
$email = $js_email["email"];
$age = $js_age["age"];
$designation = $js_designation["designation"];


require_once("../db/config.php");

$records = "SELECT * FROM employee WHERE email = '$email'";
$result = mysqli_query($connection, $records);

if (mysqli_num_rows($result) > 0) {
    echo json_encode(array('message' => "Email already in use!"));
}else {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!isset($name) || !isset($email) || !isset($age)  || !isset($designation)) {
            echo json_encode(array('message' => "All fields are required!"));
        }else {
            $sql = "INSERT INTO employee (name, email, age, designation) VALUES('$name', '$email', '$age', '$designation')";
            
            if (mysqli_query($connection, $sql)) {
                echo json_encode(array("message" => "Employee inserted successfully!", "data" => json_encode(mysqli_insert_id($connection))));
            }else {
                echo json_encode(array('message' => "Something went wrong!"));
            }
            
        }
        
    }else {
        echo json_encode(array('message' => $_SERVER['REQUEST_METHOD']. " method not supported!"));
    }
    
}


