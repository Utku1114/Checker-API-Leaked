<?php

ini_set("display_errors", 0);
error_reporting(0);

include "../../server/authcontrol.php";

header('Content-Type: application/json');

$type = "http";
$ip = "tr114.proxynet.io";
$port = 14030;
$user = "wizortisbest";
$pass = "kingwizort31";

function step3($ip, $port, $type, $user, $pass, $aspnet_session, $ts_cookie, $request_verification, $request_verification_token, $captcha)
{
    $queryarray = array();
    $queryarray["__RequestVerificationToken"] = $request_verification_token;
    $queryarray["appointmentType"] = 1;
    $queryarray["passportType"] = null;
    $queryarray["Tur"] = null;
    $queryarray["VekaletIl"] = null;
    $queryarray["VekaletKod"] = null;
    $queryarray["Kod"] = null;
    $queryarray["YevmiyeNo"] = null;
    $queryarray["Gun"] = null;
    $queryarray["Ay"] = null;
    $queryarray["Yil"] = null;
    $queryarray["ilgiliTur"] = 0;
    $queryarray["KimlikNoTur"] = 0;
    $queryarray["No"] = null;
    $queryarray["FirstName"] = "İPEK";
    $queryarray["LastName"] = "BİLİR";
    $queryarray["IdentityNo"] = 13103746690;
    $queryarray["BirthDay"] = "18";
    $queryarray["BirthMonth"] = "06";
    $queryarray["BirthYear"] = "2007";
    $queryarray["MobilePhone"] = 5313313131;
    $queryarray["CaptchaCode"] = $captcha;
    $queryarray["VatandaslikIslemTur"] = null;
    $query = http_build_query($queryarray);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://randevu.nvi.gov.tr/Controller/public/ProcessAppointmentStep1");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_PROXY, "$ip:$port");
    curl_setopt($ch, CURLOPT_PROXYTYPE, $type);
    curl_setopt($ch, CURLOPT_PROXYAUTH, "$user:$pass");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_COOKIE, "ASP.NET_SessionId=" . $aspnet_session . "; __RequestVerificationToken=" . $request_verification . "; TS01e9171e=" . $ts_cookie);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36");
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function step4($ip, $port, $type, $user, $pass, $aspnet_session, $request_verification, $ts_cookie)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://randevu.nvi.gov.tr/default/step1");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_PROXY, "$ip:$port");
    curl_setopt($ch, CURLOPT_PROXYTYPE, $type);
    curl_setopt($ch, CURLOPT_PROXYAUTH, "$user:$pass");
    curl_setopt($ch, CURLOPT_COOKIE, "ASP.NET_SessionId=" . $aspnet_session . "; __RequestVerificationToken=" . $request_verification . "; TS01e9171e=" . $ts_cookie);

    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function step5($ip, $port, $type, $user, $pass, $aspnet_session, $request_verification, $ts_cookie)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://randevu.nvi.gov.tr/default/step2");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_PROXY, "$ip:$port");
    curl_setopt($ch, CURLOPT_PROXYTYPE, $type);
    curl_setopt($ch, CURLOPT_PROXYAUTH, "$user:$pass");
    curl_setopt($ch, CURLOPT_COOKIE, "ASP.NET_SessionId=" . $aspnet_session . "; __RequestVerificationToken=" . $request_verification . "; TS01e9171e=" . $ts_cookie);
    $result = curl_exec($ch);
    curl_close($ch);

    @$DOM = new DOMDocument;
    @$DOM->loadHTML($result);

    $items2 = $DOM->getElementsByTagName('input');
    foreach ($items2 as $item2) {
        if ($item2->getAttribute('name') == "__RequestVerificationToken") {
            $token = $item2->getAttribute('value');
        }
    }
    return $token;
}

function step6($ip, $port, $type, $user, $pass, $aspnet_session, $ts_cookie, $request_verification, $request_verification_token)
{
    $queryarray = array();
    $queryarray["__RequestVerificationToken"] = $request_verification_token;
    $queryarray["citySearch"] = null;
    $queryarray["CityId"] = 6;
    $queryarray["directorateSearch"] = null;
    $queryarray["DistrictId"] = 79;
    $query = http_build_query($queryarray);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://randevu.nvi.gov.tr/Controller/public/ProcessAppointmentStep2");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_PROXY, "$ip:$port");
    curl_setopt($ch, CURLOPT_PROXYTYPE, $type);
    curl_setopt($ch, CURLOPT_PROXYAUTH, "$user:$pass");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_COOKIE, "ASP.NET_SessionId=" . $aspnet_session . "; __RequestVerificationToken=" . $request_verification . "; TS01e9171e=" . $ts_cookie);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36");
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function step7($ip, $port, $type, $user, $pass, $aspnet_session, $request_verification, $ts_cookie)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://randevu.nvi.gov.tr/default/step3");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_PROXY, "$ip:$port");
    curl_setopt($ch, CURLOPT_PROXYTYPE, $type);
    curl_setopt($ch, CURLOPT_PROXYAUTH, "$user:$pass");
    curl_setopt($ch, CURLOPT_COOKIE, "ASP.NET_SessionId=" . $aspnet_session . "; __RequestVerificationToken=" . $request_verification . "; TS01e9171e=" . $ts_cookie);
    $result = curl_exec($ch);
    curl_close($ch);

    @$DOM = new DOMDocument;
    @$DOM->loadHTML($result);

    $array = array();

    $items = $DOM->getElementsByTagName('span');
    $nameNumber = 1;
    foreach ($items as $item) {
        if ($item->getAttribute('style') == "font-size: 14px") {
            $array["name_" . $nameNumber] = $item->nodeValue;
            $nameNumber++;
        }
    }

    return $array;
}

$aspnet_session = htmlspecialchars($_POST["aspnet_session"]);
$ts_cookie = htmlspecialchars($_POST["ts_cookie"]);
$request_verification = htmlspecialchars($_POST["request_verification_token"]);
$request_verification_token = htmlspecialchars($_POST["__RequestVerificationToken"]);
$captcha = htmlspecialchars($_POST["captcha"]);

$step3 = step3($ip, $port, $type, $user, $pass, $aspnet_session, $ts_cookie, $request_verification, $request_verification_token, $captcha);
$step4 = step4($ip, $port, $type, $user, $pass, $aspnet_session, $request_verification, $ts_cookie);
$step5 = step5($ip, $port, $type, $user, $pass, $aspnet_session, $request_verification, $ts_cookie);
$step6 = step6($ip, $port, $type, $user, $pass, $aspnet_session, $ts_cookie, $request_verification, $step5);
$step7 = step7($ip, $port, $type, $user, $pass, $aspnet_session, $request_verification, $ts_cookie);
$data = json_encode($step7, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);
setcookie("results", $data, time() + 86400, "/");
echo "success";