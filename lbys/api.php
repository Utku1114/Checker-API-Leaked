<?php

header('Content-Type: application/json');

ini_set("display_erros", 0);
error_reporting(0);

if (empty($_GET["ad"]) || empty($_GET["soyad"])) {
    echo json_encode(["success" => "false", "message" => "param error"]);
    die();
}

function getpage($aspcookie)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://lbys.saglik.gov.tr/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_COOKIE, $aspcookie);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Host: lbys.saglik.gov.tr',
        'Origin: https://lbys.saglik.gov.tr',
        'Referer: https://lbys.saglik.gov.tr/',
        'User-Agent: Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36',
    ));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $result = curl_exec($ch);
    curl_close($ch);

    preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
    $cookies = array();

    foreach ($matches[1] as $item) {
        parse_str($item, $cookie);
        array_push($cookies, $cookie);
    }

    return $cookies;
}

function getdetail($aspcookie, $ad, $soyad)
{
    $query = '<ES LR="637794954525056969"><E CPX="452" CPY="125" SR="693" TP="Move" Left="56" Top="108"/><E CPX="221" CPY="154" SR="686" TP="Click" BTN="L" X="37" Y="14"/><E CPX="221" CPY="154" SR="686" TP="ValueChange" TX="' . $ad . '"/><E CPX="221" CPY="154" SR="682" TP="ValueChange" TX="' . $soyad . '"/><E CPX="124" CPY="236" SR="682" TP="LostFocus"/><E CPX="124" CPY="236" SR="688" TP="GotFocus"/><E CPX="124" CPY="236" SR="688" TP="Click" BTN="L" X="54" Y="20"/></ES>';
	$cookie = "ASP.NET_SessionId=" . getpage($aspcookie)["ASP_NET_SessionId"] . "; f5avraaaaaaaaaaaaaaaa_session_=" . getpage($aspcookie)["f5avraaaaaaaaaaaaaaaa_session_"] . "; f5_cspm=" . getpage($aspcookie)["f5_cspm"] . ";";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://lbys.saglik.gov.tr/Route/2.1005215.150.1/kit/tr-TR/IosTheme/1048574.65532.926/0/IosTheme/Content.giris.aspx?vwginstance=0");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Host: lbys.saglik.gov.tr',
        'Origin: https://lbys.saglik.gov.tr',
        'Referer: https://lbys.saglik.gov.tr/',
        'User-Agent: Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36',
    ));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $result = curl_exec($ch);
    curl_close($ch);

    $regex = '/<WG:DR.*?>(.*?)<\/WG:DR>/';
    preg_match_all($regex, $result, $matches);

    $results = array();
    $persons = array();

    foreach ($matches[1] as $item) {
        array_push($results, $item);
    }

    foreach ($results as $xml) {
        $regex = '/VLB="(.*?)"/';
        preg_match_all($regex, $xml, $match);

        $tc = $match[1][2];
        $ad = $match[1][3];
        $soyad = $match[1][4];
        $babaadi = $match[1][5];
        $dogumtarihi = $match[1][6];

        $person = array(
            'tc' => $tc,
            'ad' => $ad,
            'soyad' => $soyad,
            'babaadi' => $babaadi,
            'dogumtarihi' => $dogumtarihi,
        );

        array_push($persons, $person);
    }

    return $persons;
}

$aspcookie = "dujwh3iif2fv5hpvrbhhuiyf";
$infos = getdetail($aspcookie, $_GET["ad"], $_GET["soyad"]);

foreach ($infos as $info) {
    if (!intval($info["tc"])) {
        unset($info);
    }
}

if (empty($infos)) {
    echo json_encode(["success" => "false", "message" => "no data"]);
    die();
} else {
    $number = count($infos);
    echo json_encode(["success" => "true", "number" => $number, "data" => $infos]);
	die();
}