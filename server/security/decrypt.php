<?php

function decrypt($key)
{
    $ciphering = "AES-128-CTR";
    $decryption_key = "kronikcheckkey";
    $options = 0;
    $decryption_iv = '1234567891011121';

    $key = urldecode($key);

    $decryption = openssl_decrypt(
        $key,
        $ciphering,
        $decryption_key,
        $options,
        $decryption_iv
    );

    $time = explode("@", $decryption)[1];

    if (time() > $time) {
        return $time;
    } else {
        return true;
    }
}
