<?php

function encrypt($key)
{
    $ciphering = "AES-128-CTR";
    $encryption_key = "kronikcheckkey";
    $options = 0;
    $encryption_iv = '1234567891011121';
    
    $key = $key . "@" . strtotime("+60 seconds");

    $encryption = openssl_encrypt(
        $key,
        $ciphering,
        $encryption_key,
        $options,
        $encryption_iv
    );

    return urlencode($encryption);
}
