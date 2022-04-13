<?php
include "../../server/authcontrol.php";

$eposta = htmlspecialchars($_POST['email']);
$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://oauth.hepsiburada.com/api/authenticate/xsrf-token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_COOKIE => "_abck=68909238D66337723B4719CD5F240D59~0~YAAQnKwVAiTcKaJ9AQAAynXd2Qd2gy3ZyQ/EO3Gwr06EfNJqVn3xW+rJGA9ImNzP1vUEJiGqPLnmk6tACC9Dkm1AKTSjVcOYmefOajpR3HMYoVTYwxe5mp4SfWcsXwW+QZ387HmC16lsAqOAoGQFOHPw+bpI8hlTmw0EhBdFT9JCtvhX/4UZany2FJSxQITJvM6qhVduMJ7I7M6kuUdrZ4Xfbh7D7U9K/WTbtndGs1/LxfnpOTGbWEZxFSjZyMdo3j5qWK0z7AfpcKxmceG3Mi0+2OjeQG0NYJDuWUcV6rJK31B+n2pnyapNlgYSf+lrBMx3rOq2potsCIz+qfHUiP0r/mj5Co42TiUi4HazAKp7+JUktu6hA/EvumtveLMZ+fSiQr6dksArWWcAmRWndpz1P5ELKaFRzjcHEeEC~-1~||-1||~-1; wt3_eid=%3B289941511384204%7C216…1LVT126GMgTXZag0K3+lNKW5MIYzEAEroDExBZPKO/QIPkfYhJx/aBt2eMzeuDO1AOb37XfSM0qdbjkIVWVVDW51q5m4MQNnU/A==~3617329~4277057; wt3_sid=%3B289941511384204; oidcReturnUrl=https://www.hepsiburada.com; .AspNetCore.Antiforgery.4Vaf_q21e6g=CfDJ8K7lpL5V5RxGsJcE66HiJatIFQ5g2xm2hHhZ1uV_qg-GV1eJjIjyrvwpP3F8c0O644XDa3dtUancuP8hfktU8fayyNId1sZ5JXYwBpAlrODxFBAhJIb0jmoIX354GnM6sVfTbway6sxqBkr8C1b1Hko; _dgr_top_parent_category=; dgr_login=4e65775265676973746572546573747c4e65777c; isGSMLoginPopoverShown=true; ActivePage=PURE_LOGIN",
  CURLOPT_HTTPHEADER => [
    'authority: https://oauth.hepsiburada.com/api/authenticate/xsrf-token',
    'method: GET',
    'scheme: https',
    'accept: application/json, text/plain, */*',
    'accept-language: tr-TR,tr;q=0.8,en-US;q=0.5,en;q=0.3',
    'content-type: application/json',
    'cookie: _abck=68909238D66337723B4719CD5F240D59~0~YAAQnKwVAiTcKaJ9AQAAynXd2Qd2gy3ZyQ/EO3Gwr06EfNJqVn3xW+rJGA9ImNzP1vUEJiGqPLnmk6tACC9Dkm1AKTSjVcOYmefOajpR3HMYoVTYwxe5mp4SfWcsXwW+QZ387HmC16lsAqOAoGQFOHPw+bpI8hlTmw0EhBdFT9JCtvhX/4UZany2FJSxQITJvM6qhVduMJ7I7M6kuUdrZ4Xfbh7D7U9K/WTbtndGs1/LxfnpOTGbWEZxFSjZyMdo3j5qWK0z7AfpcKxmceG3Mi0+2OjeQG0NYJDuWUcV6rJK31B+n2pnyapNlgYSf+lrBMx3rOq2potsCIz+qfHUiP0r/mj5Co42TiUi4HazAKp7+JUktu6hA/EvumtveLMZ+fSiQr6dksArWWcAmRWndpz1P5ELKaFRzjcHEeEC~-1~||-1||~-1; wt3_eid=%3B289941511384204%7C216…1LVT126GMgTXZag0K3+lNKW5MIYzEAEroDExBZPKO/QIPkfYhJx/aBt2eMzeuDO1AOb37XfSM0qdbjkIVWVVDW51q5m4MQNnU/A==~3617329~4277057; wt3_sid=%3B289941511384204; oidcReturnUrl=https://www.hepsiburada.com; .AspNetCore.Antiforgery.4Vaf_q21e6g=CfDJ8K7lpL5V5RxGsJcE66HiJatIFQ5g2xm2hHhZ1uV_qg-GV1eJjIjyrvwpP3F8c0O644XDa3dtUancuP8hfktU8fayyNId1sZ5JXYwBpAlrODxFBAhJIb0jmoIX354GnM6sVfTbway6sxqBkr8C1b1Hko; _dgr_top_parent_category=; dgr_login=4e65775265676973746572546573747c4e65777c; isGSMLoginPopoverShown=true; ActivePage=PURE_LOGIN',
    'host: oauth.hepsiburada.com',
    'origin: https://giris.hepsiburada.com',
    'referer: https://giris.hepsiburada.com/',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-site',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:95.0) Gecko/20100101 Firefox/95.0'
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

$fim = json_decode($response, true);
$unit_token = $fim['xsrfToken'];
echo $unit_token . '<br>';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://oauth.hepsiburada.com/api/authenticate/emailcheck');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/cookie.txt');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_COOKIE, '_abck=68909238D66337723B4719CD5F240D59~0~YAAQnKwVAiTcKaJ9AQAAynXd2Qd2gy3ZyQ/EO3Gwr06EfNJqVn3xW+rJGA9ImNzP1vUEJiGqPLnmk6tACC9Dkm1AKTSjVcOYmefOajpR3HMYoVTYwxe5mp4SfWcsXwW+QZ387HmC16lsAqOAoGQFOHPw+bpI8hlTmw0EhBdFT9JCtvhX/4UZany2FJSxQITJvM6qhVduMJ7I7M6kuUdrZ4Xfbh7D7U9K/WTbtndGs1/LxfnpOTGbWEZxFSjZyMdo3j5qWK0z7AfpcKxmceG3Mi0+2OjeQG0NYJDuWUcV6rJK31B+n2pnyapNlgYSf+lrBMx3rOq2potsCIz+qfHUiP0r/mj5Co42TiUi4HazAKp7+JUktu6hA/EvumtveLMZ+fSiQr6dksArWWcAmRWndpz1P5ELKaFRzjcHEeEC~-1~||-1||~-1; wt3_eid=%3B289941511384204%7C216…1LVT126GMgTXZag0K3+lNKW5MIYzEAEroDExBZPKO/QIPkfYhJx/aBt2eMzeuDO1AOb37XfSM0qdbjkIVWVVDW51q5m4MQNnU/A==~3617329~4277057; wt3_sid=%3B289941511384204; oidcReturnUrl=https://www.hepsiburada.com; .AspNetCore.Antiforgery.4Vaf_q21e6g=CfDJ8K7lpL5V5RxGsJcE66HiJatIFQ5g2xm2hHhZ1uV_qg-GV1eJjIjyrvwpP3F8c0O644XDa3dtUancuP8hfktU8fayyNId1sZ5JXYwBpAlrODxFBAhJIb0jmoIX354GnM6sVfTbway6sxqBkr8C1b1Hko; _dgr_top_parent_category=; dgr_login=4e65775265676973746572546573747c4e65777c; isGSMLoginPopoverShown=true; ActivePage=PURE_LOGIN');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'authority: https://oauth.hepsiburada.com/api/authenticate/emailcheck',
  'method: POST',
  'path: /wp-admin/admin-ajax.php',
  'scheme: https',
  'accept: application/json, text/plain, */*',
  'accept-language: tr-TR,tr;q=0.8,en-US;q=0.5,en;q=0.3',
  'content-type: application/json',
  'cookie: _abck=68909238D66337723B4719CD5F240D59~0~YAAQnKwVAiTcKaJ9AQAAynXd2Qd2gy3ZyQ/EO3Gwr06EfNJqVn3xW+rJGA9ImNzP1vUEJiGqPLnmk6tACC9Dkm1AKTSjVcOYmefOajpR3HMYoVTYwxe5mp4SfWcsXwW+QZ387HmC16lsAqOAoGQFOHPw+bpI8hlTmw0EhBdFT9JCtvhX/4UZany2FJSxQITJvM6qhVduMJ7I7M6kuUdrZ4Xfbh7D7U9K/WTbtndGs1/LxfnpOTGbWEZxFSjZyMdo3j5qWK0z7AfpcKxmceG3Mi0+2OjeQG0NYJDuWUcV6rJK31B+n2pnyapNlgYSf+lrBMx3rOq2potsCIz+qfHUiP0r/mj5Co42TiUi4HazAKp7+JUktu6hA/EvumtveLMZ+fSiQr6dksArWWcAmRWndpz1P5ELKaFRzjcHEeEC~-1~||-1||~-1; wt3_eid=%3B289941511384204%7C216…1LVT126GMgTXZag0K3+lNKW5MIYzEAEroDExBZPKO/QIPkfYhJx/aBt2eMzeuDO1AOb37XfSM0qdbjkIVWVVDW51q5m4MQNnU/A==~3617329~4277057; wt3_sid=%3B289941511384204; oidcReturnUrl=https://www.hepsiburada.com; .AspNetCore.Antiforgery.4Vaf_q21e6g=CfDJ8K7lpL5V5RxGsJcE66HiJatIFQ5g2xm2hHhZ1uV_qg-GV1eJjIjyrvwpP3F8c0O644XDa3dtUancuP8hfktU8fayyNId1sZ5JXYwBpAlrODxFBAhJIb0jmoIX354GnM6sVfTbway6sxqBkr8C1b1Hko; _dgr_top_parent_category=; dgr_login=4e65775265676973746572546573747c4e65777c; isGSMLoginPopoverShown=true; ActivePage=PURE_LOGIN',
  'host: oauth.hepsiburada.com',
  'origin: https://giris.hepsiburada.com',
  'referer: https://giris.hepsiburada.com/',
  'sec-fetch-dest: empty',
  'sec-fetch-mode: cors',
  'sec-fetch-site: same-site',
  'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:95.0) Gecko/20100101 Firefox/95.0',
  'X-XSRF-TOKEN: ' . $unit_token . '',
));
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"email":"' . $eposta . '"}');

$HOPPPA = curl_exec($ch);

$OCOO = json_decode($HOPPPA, true);

if ($OCOO['success'] == 'true') {
  echo "HEPSİ | #Aktif - $eposta - Geçerli Adres";
} else {
  echo "HEPSİ | #Kapalı - $eposta - Üzgünüm Bu Mail Adresine Kayıtlı Hesap Bulunmuyor!";
}
