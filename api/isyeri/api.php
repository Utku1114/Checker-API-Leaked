<?php
error_reporting(0);
ini_set('display_errors', 0);

include "../../server/authcontrol.php";
include "../../server/cookie.php";

include "../vendor/autoload.php";

use GuzzleHttp\Client;

header('Content-Type: application/json');

$tc = $_POST["tc"];

$client = new Client();
$requestKimlik = $client->request('GET', 'https://hsys.saglik.gov.tr/Takip/VakaTakip/GetVakaIsYeriBilgileri?vakaId=&hastaTc=' . $tc, [
    'headers' => [
        "Accept" => "application/json, text/javascript, */*; q=0.01",
        "Accept-Encoding" => "gzip, deflate, br",
        "Accept-Language" => "en-US,en;q=0.9",
        "Connection" => "keep-alive",
        "Content-Type" => "application/json; charset=utf-8",
        "Cookie" => $cookie, # SİSTEM GİRİŞ COOKİESİ
        "Host" => "hsys.saglik.gov.tr",
        "Referer" => "https://hsys.saglik.gov.tr/Takip/VakaTakip/VakaTakipKayit",
        "sec-ch-ua" => '" Not A;Brand";v="99", "Chromium";v="98", "Google Chrome";v="98"',
        "sec-ch-ua-mobile" => "?0",
        "sec-ch-ua-platform" => '"Windows"',
        "Sec-Fetch-Dest" => "empty",
        "Sec-Fetch-Mode" => "cors",
        "Sec-Fetch-Site" => "same-origin",
        "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36",
        "X-Requested-With" => "XMLHttpRequest"
    ]
]);

$response = json_decode($requestKimlik->getBody()->getContents(), true);
if ($response["State"] == 1) {
    $json_result = json_decode($response["Result"]["responseJsonStr"], true);
    $sayi = count($json_result["sigortaliBilgisi"]["sgkSigortaliBilgileri"]["sigortaliTumOrtakHizmetlerDtoList"]);
    $json_result = json_encode($json_result["sigortaliBilgisi"]["sgkSigortaliBilgileri"]["sigortaliTumOrtakHizmetlerDtoList"][$sayi - 1]);
    echo json_encode(["success" => "true", "message" => "Bulundu", "data" => json_decode($json_result, true), "adres" => $response["Result"]["IsYeriAdres"]]);
} else {
    echo json_encode(["success" => "false", "message" => "Bulunamadı"]);
}