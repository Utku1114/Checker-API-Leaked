<?php

$baglan = mysqli_connect("localhost", "root", "", "secmen");
	if ($baglan->connect_errno > 0) {
	    die("<center><b>Bağlantı Hatası:</b> " . $baglan->connect_error . "</center>");
	}
    mysqli_set_charset($baglan, "utf8");

?>