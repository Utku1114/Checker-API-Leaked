<?php

header("Content-Type: application/json; utf-8;");

include "../../server/authcontrol.php";

$conn = new mysqli("localhost", "root", "", "gsm");

if (isset($_POST) || !empty($_POST["gsm"])) {
    $gsm = preg_replace("/[^0-9]+/", "", htmlspecialchars($_POST["gsm"]));

    $sql = "SELECT * FROM `data` WHERE MATCH(`gsm`) AGAINST('$gsm' IN BOOLEAN MODE)";

    if ($conn->query($sql)->num_rows > 0) {
        $data = $conn->query($sql)->fetch_assoc();
        $dbtc = $data["tc"];
        $dbgsm = $data["gsm"];
        echo json_encode(["success" => "true", "message" => ["tc" => $dbtc, "gsm" => $dbgsm]]);
        die();
    } else {
        echo json_encode(["success" => "false", "message" => "not found"]);
        die();
    }

} else {
    echo json_encode(["success" => "false", "message" => "request error"]);
    die();
}
