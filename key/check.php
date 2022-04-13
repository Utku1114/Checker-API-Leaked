<?php

include "checkDogrulama.php";
include "connect.php";

if ($_GET['dataText'] == "") {
    echo 'Lütfen en az bir yeri doldurun!';
    return;
}

$dataText = $_GET['dataText'];
$dataText = str_replace("startValueOfDataTextYouCutThisTextForSearchData AND", "", $dataText);
$dataText = 'SELECT * FROM secmen2015 WHERE ' . $dataText;

$sonuc = mysqli_query($baglan, $dataText);

if ($baglan->errno > 0) {
    die("<center><b>Sorgu Hatası:</b> " . $baglan->error . "</center>");
} else {
    echo '<center><a style="font-size: 25px; font-weight: bold;text-decoration: none;" href="index.php">Geri Dön</a></center>';
    echo '<br>';
    echo '<center><b>' . mysqli_num_rows($sonuc) . '</b> tane sonuç bulundu!</center>';
    echo '<br>';
    while ($satir = mysqli_fetch_array($sonuc)) {
        $cinsiyet = "";
        if ($satir['CINSIYETI'] == "K") {
            $cinsiyet = "KADIN";
        } else {
            $cinsiyet = "ERKEK";
        }
        echo "<center>";
        echo "<b>TC:</b> " . $satir['TC'];
        echo '<br>';
        echo "<b>AD/SOYAD:</b> " . $satir['ADI'] . " " . $satir['SOYADI'];
        echo '<br>';
        echo "<b>ANNE ADI:</b> " . $satir['ANAADI'];
        echo '<br>';
        echo "<b>BABA ADI:</b> " . $satir['BABAADI'];
        echo '<br>';
        echo "<b>DOĞUM YERİ:</b> " . $satir['DOGUMYERI'];
        echo '<br>';
        echo "<b>DOĞUM TARİHİ:</b> " . $satir['DOGUMTARIHI'];
        echo '<br>';
        echo "<b>CİNSİYETİ:</b> " . $cinsiyet;
        echo '<br>';
        echo "<b>NÜFUS:</b> " . $satir['NUFUSILI'] . " / " . $satir['NUFUSILCESI'];
        echo '<br>';
        echo "<b>ADRES:</b> " . $satir['ADRESIL'] . " / " . $satir['ADRESILCE'] . " / " . $satir['MAHALLE'] . " / " . $satir['CADDE'] . " / NO: " . $satir['KAPINO'] . " / DAIRE: " . $satir['DAIRENO'];
        echo '<br>';
        echo "<b>TELEFON:</b> " . $satir['ENGEL'];
        echo '<br><br>';
        echo '<footer style="text-decoration: underline;">Powered by <b>WizarD</b></footer>';
        echo '</center>';
        echo '<br>';
    }
}
