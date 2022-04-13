<?php

include "../../server/authcontrol.php";

$tc = $_POST['tc'];
preg_replace('/^[0-9]+$/', '', $tc);
if (empty($tc)) {
	$result = array(
        'success' => 'false',
        'message' => 'Hatalı TC'
    );
}

$cookie = "oni4zow0wt3akkymgn3utx44";

function getPage($cookie)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://aolweb.meb.gov.tr/AOL01001.aspx");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36");
    curl_setopt($ch, CURLOPT_COOKIE, "ASP.NET_SessionId=$cookie; kullanici=; ekranTipi=");
    $output = curl_exec($ch);
    curl_close($ch);

    // get viewstate with dom
    $dom = new DOMDocument();
    @$dom->loadHTML($output);
    $xpath = new DOMXPath($dom);

    $viewstate = $xpath->query('//*[@id="__VIEWSTATE"]')->item(0)->getAttribute('value');
    $viewstategenerator = $xpath->query('//*[@id="__VIEWSTATEGENERATOR"]')->item(0)->getAttribute('value');
    $eventvalidation = $xpath->query('//*[@id="__EVENTVALIDATION"]')->item(0)->getAttribute('value');

    return array(
        'viewstate' => $viewstate,
        'viewstategenerator' => $viewstategenerator,
        'eventvalidation' => $eventvalidation
    );
}

function beforeGetInfo($tc, $cookie)
{
    $query = http_build_query(array(
        '__VIEWSTATE' => getPage($cookie)['viewstate'],
        '__VIEWSTATEGENERATOR' => getPage($cookie)['viewstategenerator'],
        '__EVENTVALIDATION' => getPage($cookie)['eventvalidation'],
        'txtTCNo' => $tc,
        'hdnPageMode' => 1
    ));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://aolweb.meb.gov.tr/AOL01001.aspx");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36");
    curl_setopt($ch, CURLOPT_COOKIE, "ASP.NET_SessionId=$cookie; kullanici=; ekranTipi=");
    $output = curl_exec($ch);
    curl_close($ch);

    // get #grdAramaSonuclar > tbody > tr:nth-child(2) > td:nth-child(2) with dom
    $dom = new DOMDocument();
    @$dom->loadHTML($output);
    $xpath = new DOMXPath($dom);

    $result = $xpath->query('//*[@id="grdAramaSonuclar"]/tr[2]/td[2]')->item(0)->nodeValue;
    return $result;
}

function getInfo($tc, $cookie)
{
    $query = http_build_query(array(
        '__VIEWSTATE' => getPage($cookie)['viewstate'],
        '__VIEWSTATEGENERATOR' => getPage($cookie)['viewstategenerator'],
        '__EVENTVALIDATION' => getPage($cookie)['eventvalidation'],
        'txtTCNo' => $tc,
        'hdnOgrenciNo' => beforeGetInfo($tc, $cookie),
        'hdnPageMode' => 2
    ));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://aolweb.meb.gov.tr/AOL01001.aspx");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36");
    curl_setopt($ch, CURLOPT_COOKIE, "ASP.NET_SessionId=$cookie; kullanici=; ekranTipi=");
    $output = curl_exec($ch);
    curl_close($ch);

    $dom = new DOMDocument();
    @$dom->loadHTML($output);
    $xpath = new DOMXPath($dom);

    $ogrencino = $xpath->query('//*[@id="lblOgrenciNo"]')->item(0)->nodeValue;
    $ad = $xpath->query('//*[@id="lblAdi"]')->item(0)->nodeValue;
    $soyad = $xpath->query('//*[@id="lblSoyadi"]')->item(0)->nodeValue;
    $anneadi = $xpath->query('//*[@id="lblAnneAdi"]')->item(0)->nodeValue;
    $babadi = $xpath->query('//*[@id="lblBabaAdi"]')->item(0)->nodeValue;
    $okulalan = $xpath->query('//*[@id="lblOkulBolum"]')->item(0)->nodeValue;

    return array(
        'ogrencino' => $ogrencino,
        'ad' => $ad,
        'soyad' => $soyad,
        'anneadi' => $anneadi,
        'babaadi' => $babadi,
        'okulalan' => $okulalan
    );
}

function getPhoto($cookie)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://aolweb.meb.gov.tr/ResimGoster.aspx");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36");
    curl_setopt($ch, CURLOPT_COOKIE, "ASP.NET_SessionId=$cookie; kullanici=; ekranTipi=");
    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}

$a = getPage($cookie);
$b = beforeGetInfo($tc, $cookie);
$c = getInfo($tc, $cookie);
$photo = getPhoto($cookie);

if (str_contains($photo, "JFIF")) {
    $image = 'data:image/jpeg;base64,' . base64_encode($photo);
    $name = $c['ad'];
    $surname = $c['soyad'];
    $fathername = $c['babaadi'];
    $mothername = $c['anneadi'];
    $school = $c['okulalan'];
    $ogrencino = $c['ogrencino'];

    if (empty($name) || empty($surname) || empty($fathername) || empty($mothername) || empty($school) || empty($ogrencino)) {
        $result = array(
            'success' => 'false',
            'message' => 'Bilgiler bulunamadı.'
        );
    } else {
        $result = array(
            'success' => 'true',
            'message' => 'Bilgiler bulundu.',
            'image' => $image,
            'name' => $name,
            'surname' => $surname,
            'fathername' => $fathername,
            'mothername' => $mothername,
            'school' => $school,
            'ogrencino' => $ogrencino
        );
    }

} else {
    $result = array(
        'success' => 'false',
        'message' => 'Bilgiler bulunamadı.'
    );
}

echo json_encode($result);
die();

?>