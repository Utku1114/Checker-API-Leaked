<?php

include "checkDogrulama.php";
include "connect.php";

$dosya = @fopen("telekom.txt", "r");
if ($dosya)
{
    while (!feof($dosya))
    {
        $satirlar = fgets($dosya);
        $satirlar = explode("  ", $satirlar);
        if (strlen($satirlar[0]) == 11) {
            mysqli_query($baglan, "UPDATE secmen2015 SET ENGEL='" . $satirlar[1] . "' WHERE TC='" .  $satirlar[0] . "'");
        }
    }
    fclose($dosya);
}

echo "bitti";

?>