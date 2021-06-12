<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow this api to call from anywhere
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content_Type, Access-Control-Allow-Methods, X-Requested-With, Authorization");

require_once('../db/config.php');
require_once('../auth.php');

$isAuthenticated = isAuth();

$pageNo = htmlspecialchars(isset($_GET["pageNo"])) ? (int)  htmlspecialchars($_GET["pageNo"]) : 1;
$pageSize = htmlspecialchars(isset($_GET["pageSize"])) ? (int) htmlspecialchars($_GET["pageSize"]) : 5;


$startIndex = ($pageNo - 1) * $pageSize;


if ($isAuthenticated) {
    $sql = "SELECT * FROM employee LIMIT $startIndex, $pageSize";
    $result = mysqli_query($connection, $sql);

    $resultTotalCount = mysqli_query($connection, "select count(1) FROM employee");
    $rows = mysqli_fetch_array($resultTotalCount);

    $totalCount = $rows[0];

    $totalPages = ceil($totalCount / $pageSize);
    $remainingPages = ceil($totalPages - $pageNo);

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
                echo json_encode(array("message" => "Success", "data" => $row, "pageNo" => $pageNo, "pageSize" => $pageSize, "totalPages" => $totalPages, "remainingPages" => $remainingPages));
            }
        }else {
            echo json_encode(array('message' => "Not found!", "data" => []));
        }
    }else {
        echo json_encode(array('message' => $_SERVER['REQUEST_METHOD']. " method not supported!"));
    }
}else {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo json_encode(array('message' => "Authentication failed!"));
}



