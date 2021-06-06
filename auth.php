<?php

function isAuth() {
    if (isset($_SERVER["PHP_AUTH_USER"]) && isset($_SERVER["PHP_AUTH_PW"])) {
        if ($_SERVER["PHP_AUTH_USER"] == "@TEST!!0249@@&&31342" && $_SERVER["PHP_AUTH_PW"] == "PW@TEST%!!001344hhaf@@#01") {
            return true;
        }else {
            return false;
        }
    }else {
        echo json_encode(array("message" => "Username and Password is required!"));exit;
    }
}
