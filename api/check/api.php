<?php
ini_set('display_errors', 0);
error_reporting(0);

include "../../server/authcontrol.php";
include "../vendor/autoload.php";

use GuzzleHttp\Client;

header('Content-Type: application/json');

if (empty($_POST["tc"])) {
    echo json_encode(array(
        'status' => 'error',
        'message' => 'TC Kimlik Numarası Giriniz'
    ));
    exit;
} else if (empty($_POST["method"])) {
    echo json_encode(array(
        'status' => 'error',
        'message' => 'Method Giriniz'
    ));
    exit;
}

$type = "http";
$ip = "tr114.proxynet.io";
$port = 14030;

$tc = htmlspecialchars($_POST['tc']);
$method = htmlspecialchars($_POST['method']);
$cookie = "";

function checkTC($tckimlik)
{
    $olmaz = array(
        '11111111110',
        '22222222220',
        '33333333330',
        '44444444440',
        '55555555550',
        '66666666660',
        '77777777770',
        '88888888880',
        '99999999990'
    );
    if ($tckimlik[0] == 0 or !ctype_digit($tckimlik) or strlen($tckimlik) != 11) {
        return false;
    } else {
        $ilkt = null;
        $sont = null;
        $tumt = null;

        for ($a = 0; $a < 9; $a = $a + 2) {
            $ilkt = $ilkt + $tckimlik[$a];
        }
        for ($a = 1; $a < 9; $a = $a + 2) {
            $sont = $sont + $tckimlik[$a];
        }
        for ($a = 0; $a < 10; $a = $a + 1) {
            $tumt = $tumt + $tckimlik[$a];
        }

        if ((($ilkt * 7) - $sont) % 10 != $tckimlik[9] or $tumt % 10 != $tckimlik[10]) {
            return false;
        } else {
            foreach ($olmaz as $olurmu) {
                if ($tckimlik == $olurmu) {
                    return false;
                }
            }
            return true;
        }
    }
}

if ($method != "adres" && $method != "telefon") {
    echo json_encode(array("status" => "error", "message" => "Geçersiz method"));
    exit;
}

if (checkTC($tc)) {

    /*
    $query = http_build_query(array(
        "param" => (int)$tc,
        "hastaTipi" => 1,
        "IsSahisNumarasi" => false
    ));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://hsys.saglik.gov.tr/Hasta/Islem/GetHastaDetay");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_PROXY, "$ip:$port");
    curl_setopt($ch, CURLOPT_PROXYTYPE, $type);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_PROXYAUTH, "wizortisbest:kingwizort31");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept" => "*//*",
        "Accept-Encoding" => "gzip, deflate, br",
        "Accept-Language" => "tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7",
        "Connection" => "keep-alive",
        "Content-Length" => "51",
        "Content-Type" => "application/x-www-form-urlencoded; charset=UTF-8",
        "Cookie" => $cookie, # SİSTEM GİRİŞ COOKİESİ
        "Host" => "hsys.saglik.gov.tr",
        "Referer" => "https://hsys.saglik.gov.tr/",
        "sec-ch-ua" => '" Not;A Brand";v="99", "Google Chrome";v="97", "Chromium";v="97"',
        "sec-ch-ua-mobile" => "?0",
        "sec-ch-ua-platform" => '"Windows"',
        "Sec-Fetch-Dest" => "empty",
        "Sec-Fetch-Mode" => "cors",
        "Sec-Fetch-Site" => "same-origin",
        "User-Agent" => "Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36",
        "X-Requested-With" => "XMLHttpRequest"
    ));
    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response, true);
    if ($response["HastaAdres"]["DisKapiNo"] !== NULL) {
        $tc = $response["Hasta"]["HastaTc"];
        $ad = $response["Hasta"]["Ad"];
        $soyad = $response["Hasta"]["Soyad"];
        $cinsiyet = $response["Hasta"]["Cinsiyet"];
        $dogumTarihi = $response["Hasta"]["HastaDogumTarihiStr"];
        $telefon = $response["Hasta"]["TelefonNumarasi"];
        $il = $response["HastaAdres"]["IlAdi"];
        $ilce = $response["HastaAdres"]["IlceAdi"];
        $mahalle = $response["HastaAdres"]["MahalleAdi"];
        $disKapi = $response["HastaAdres"]["DisKapiNo"];
        $icKapi = $response["HastaAdres"]["IcKapiNo"];
        $acikAdres = $response["HastaAdres"]["AcikAdres"];
        if ((string)$cinsiyet === "1") {
            $cinsiyet = "ERKEK";
        } else {
            $cinsiyet = "KADIN";
        }

        $person = [
            "success" => "true",
            "telefon" => [
                "ad" => $ad,
                "soyad" => $soyad,
                "telefon" => $telefon,
            ],
            "adres" => [
                "il" => $il,
                "ilce" => $ilce,
                "mahalle" => $mahalle,
                "disKapi" => $disKapi,
                "icKapi" => $icKapi,
                "acikAdres" => $acikAdres
            ]
        ];
    }
    */

    if ($method == "adres") {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://78.135.87.16/wizort/api/hsys/api.php?tc=$tc&method=adres&auth=bot_wizard_bekir_ebu_31_41");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    } else if ($method == "telefon") {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://78.135.87.16/wizort/api/hsys/api.php?tc=$tc&method=telefon&auth=bot_wizard_bekir_ebu_31_41");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    } else {
        echo json_encode(array("status" => "error", "message" => "Geçersiz method"));
    }
} else {
    echo json_encode(["status" => "false", "error" => "tc hatalı"]);
    exit;
}
