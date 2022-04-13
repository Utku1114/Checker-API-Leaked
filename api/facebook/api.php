<?php

include "../../server/authcontrol.php";

ini_set("display_errors", 0);
error_reporting(0);

header("Content-Type: application/json; utf-8");

$conn = new mysqli("localhost", "root", "", "facebook");

if ($conn->connect_errno > 0) {
    echo json_encode(["success" => "false", "message" => "server error"]);
    die();
}

if (isset($_POST["phone"]) && !empty($_POST["phone"])) {
    $phone = "+90" . preg_replace("/[^0-9]+/", "", htmlspecialchars($_POST["phone"]));

    $sql = "SELECT * FROM `users` WHERE MATCH(`fb_phone`) AGAINST(? IN BOOLEAN MODE)";
    $result = $conn->prepare($sql);
    $param = $result->bind_param("s", $phone);
    $exec = $result->execute();

    if ($result === false || $param === false || $exec === false) {
        echo json_encode(["success" => "false", "message" => "user not found"]);
    }

    $result = $result->get_result();

    if ($result->num_rows < 1) {
        die(json_encode(["success" => "false", "message" => "user not found"]));
    } else {
        $array = array();
        while ($row = $result->fetch_assoc()) {
            array_push($array, [
                "fb_id" => $row["fb_id"],
                "fb_phone" => $row["fb_phone"],
                "fb_name" => $row["fb_name"],
                "fb_surname" => $row["fb_surname"],
                "fb_link" => $row["fb_link"],
            ]);
        }
        $result->close();
        die(json_encode(["success" => "true", "message" => $array]));
    }
} else {
    die(json_encode(["success" => "false", "message" => "argument error"]));
}
