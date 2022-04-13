<?php
error_reporting(0);
ini_set('display_errors', 0);

require '../server/baglan.php';

$uid = $_SESSION['id'];

$query = mysqli_query($conn, "SELECT * FROM `sh_kullanici` WHERE id='$uid'");
while ($getvar = mysqli_fetch_assoc($query)) {
    $roll = $getvar['k_rol'];
    switch ($roll) {
        case '0':
            $uyelik = "Freemium";
            break;
        case '1':
            $uyelik = "Admin";
            break;
        case '2':
            $uyelik = "SkyPremium";
            break;
    }
    $bitis_tarihi = $getvar['u_time'];
    if (empty($bitis_tarihi)) {
        $bitis_tarihi = 1;
    }
    if ($bitis_tarihi !== "1") {
        function kontrol($kayit, $bitis)
        {
            $ilk = strtotime($kayit);
            $son = strtotime($bitis);
            if ($ilk - $son > 0) {
                return 1;
            } else {
                return 0;
            }
        }
        date_default_timezone_set('Europe/Istanbul');
        $bugun_tarih = date('Y-m-d'); // Bugünün Tarihini Çekiyoruz
        if (kontrol($bugun_tarih, $bitis_tarihi)) { // Kontrol Ediliyor.
            $null = 1;
            $yetki = 0;
            $query = "UPDATE `sh_kullanici` SET k_rol='$yetki',u_time='$null' WHERE id=$uid";
            if ($conn->query($query) !== TRUE) {
                echo $conn->error;
            }
            // Üyelik bitirme işlemleri

        }
    }
}
