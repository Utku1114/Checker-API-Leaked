<?php

session_start();

if (isset($_SESSION["verified"]) && $_SESSION["verified"] == true) {
    header("Location: index.php");
    exit();
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doğrula</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        h1 {
            margin-bottom: 15px;
        }

        .text {
            width: 400px;
            height: 35px;
            text-align: center;
            font-weight: bold;
            font-size: 17px;
        }

        .button {
            font-size: 17px;
            font-weight: bold;
            margin-top: 15px;
            width: 150px;
            height: 30px;
        }

        .notification {
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <center>
        <form action="#" method="post">
            <h1>Doğrulama Sayfası</h1>
            <input class="text" type="text" name="dogrula" placeholder="Doğrulama Anahtarı">
            <br>
            <input class="button" type="submit" name="submit" value="Doğrula">
        </form>
    </center>
    <?php

    include "connect.php";

    if (isset($_POST["submit"])) {
        $dogrula = $_POST["dogrula"];

        if ($dogrula == "") {
            echo "<center class='notification' style='color: red; font-size: 20px; font-weight: bold;'>Lütfen doğrulama kodunu giriniz.</center>";
            die();
        }

        $dbKey = $baglan->query("SELECT * FROM dogrulama WHERE verify_key='$dogrula'");
        if ($dbKey->num_rows < 1) {
            echo "<center class='notification' style='color: red; font-size: 20px; font-weight: bold;'>Hatalı doğrulama kodu!</center>";
            die();
        } else {
            $dbKey = $dbKey->fetch_assoc();
            if ($dbKey["verified"] === "false") {
                echo "<center class='notification' style='color: red; font-size: 20px; font-weight: bold;'>Bu doğrulama kodunun kullanımı engellenmiştir!</center>";
                die();
            }

            if ((int)$dbKey["uses"] === (int)$dbKey["use_limit"]) {
                echo "<center class='notification' style='color: red; font-size: 20px; font-weight: bold;'>Doğrulama kodunuzun kullanım limiti doldu.</center>";
                die();
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
                if ($dbKey["ip"] !== "" && $dbKey["ip"] !== $ip) {
                    echo "<center class='notification' style='color: red; font-size: 20px; font-weight: bold;'>Farklı IP saptandı! Lütfen yönetici ile iletişime geçin.</center>";
                    $baglan->query("UPDATE dogrulama SET verified='false' WHERE verify_key='$dogrula'");
                    die();
                } else {
                    $baglan->query("UPDATE dogrulama SET uses=uses+1 WHERE verify_key='$dogrula'");
                    $baglan->query("UPDATE dogrulama SET verified='true' WHERE verify_key='$dogrula'");
                    $baglan->query("UPDATE dogrulama SET ip='$ip' WHERE verify_key='$dogrula'");
                    $_SESSION["verifiedUser"] = true;
                    $_SESSION["verify_key"] = $dogrula;
                    echo "<center class='notification' style='color: green; font-size: 20px; font-weight: bold;'>Doğrulama başarılı</center>";
                    header("Location: index.php");
                    exit();
                }
            }
        }
    }

    ?>
</body>

</html>