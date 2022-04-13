<?php

include "../../server/baglan.php";

if (isset($_POST['username'])) {
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $key = generateRandomString(32);
    $username = htmlspecialchars($_POST['username']);
    $date = date("Y-m-d H:i:s");

    $sql = "INSERT INTO `sh_kullanici` (`k_key`, `k_adi`, `k_verified`, `k_time`) VALUES ('$key', '$username', 'true', '$date')";
    $result = $conn->query($sql);

    if ($result) {
        echo json_encode(array("success" => true, "key" => $key, "username" => $username));
        die();
    } else {
        echo json_encode(array("success" => false));
        die();
    }
} else {
    echo json_encode(array("success" => false));
    die();
}
