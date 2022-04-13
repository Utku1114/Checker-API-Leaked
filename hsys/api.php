<?php
error_reporting(0);
ini_set('display_errors', 0);

if ($_GET["auth"] != "bot_wizard_bekir_ebu_31_41") {
	header("Content-Type: application/json; utf-8;");
	echo json_encode(["success" => "false", "message" => "auth error"]);
	die();
}

include "../../../server/cookie.php";

include "../vendor/autoload.php";
use GuzzleHttp\Client;

header('Content-Type: application/json');

if (empty($_GET["tc"])) {
    echo json_encode(array(
        'status' => 'error',
        'message' => 'TC Kimlik Numarası Giriniz'
    ));
    exit;
} else if (empty($_GET["method"])) {
    echo json_encode(array(
        'status' => 'error',
        'message' => 'Method Giriniz'
    ));
    exit;
}

$tc = $_GET['tc'];
$method = $_GET['method'];

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

if ($method != "adres" && $method != "telefon" && $method != "kisi") {
    echo json_encode(array("status" => "error", "message" => "Geçersiz method"));
    exit;
}

if (checkTC($tc)) {
    $client = new Client();
    $requestKimlik = $client->request('POST', 'https://hsys.saglik.gov.tr/Hasta/Islem/GetHastaDetay', [
        'form_params' => [
            "param" => "$tc",
            "hastaTipi" => "1",
            "IsSahisNumarasi" => "false"
        ],
        'headers' => [
            "Accept" => "*/*",
            "Accept-Encoding" => "gzip, deflate, br",
            "Accept-Language" => "tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7",
            "Cache-Control" => "no-cache",
            "Connection" => "keep-alive",
            "Content-Length" => "51",
            "Content-Type" => "application/x-www-form-urlencoded; charset=UTF-8",
            "Cookie" => $cookie, # SİSTEM GİRİŞ COOKİESİ
            "Host" => "hsys.saglik.gov.tr",
            "Origin" => "https://hsys.saglik.gov.tr",
            "Pragma" => "no-cache",
            "Referer" => "https://hsys.saglik.gov.tr/Takip/HastaTakip/Anasayfa",
            "sec-ch-ua" => '"Google Chrome";v="95", "Chromium";v="95", ";Not A Brand";v="99"',
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
		
		if ($telefon == null) {
			$telefon = "Bulunamadı";
		}

        $person = [
			"kisi" => [
				"ad" => $ad,
				"soyad" => $soyad,
				"dogumTarihi" => $dogumTarihi
			],
			"telefon" => [
				"ad" => $ad,
				"soyad" => $soyad,
				"telefon" => $telefon,
			],
            "adres" => [
				"ad" => $ad,
				"soyad" => $soyad,
                "il" => $il,
                "ilce" => $ilce,
                "mahalle" => $mahalle,
                "disKapi" => $disKapi,
                "icKapi" => $icKapi,
                "acikAdres" => $acikAdres
            ]
        ];

        if ($method == "adres") {
            echo json_encode(array("status" => "success", "message" => "Adres bilgisi alındı", "person" => $person["adres"]));
        } else if ($method == "telefon") {
            echo json_encode(array("status" => "success", "message" => "Telefon bilgisi alındı", "person" => $person["telefon"]));
        } else if ($method == "kisi") {
            echo json_encode(array("status" => "success", "message" => "Kişi bilgisi alındı", "person" => $person["kisi"]));
        } else {
            echo json_encode(array("status" => "error", "message" => "Geçersiz method"));
        }
    }
} else {
    echo json_encode(["status" => "false", "error" => "tc hatalı"]);
    exit;
}
