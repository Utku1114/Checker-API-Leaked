<?php

define("CIPHER", "AES-128-CTR");
define("KEY", "Kronik.wizard.31.xxx.asd_dsa.lock");
define("IV", "1234567891011121");

function encrypt($string) {
    return openssl_encrypt($string, CIPHER, KEY, OPENSSL_ZERO_PADDING, IV);
}

function decrypt($string) {
    return openssl_decrypt($string, CIPHER, KEY, OPENSSL_ZERO_PADDING, IV);
}

?>