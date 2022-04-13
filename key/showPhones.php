<?php
include "checkDogrulama.php";
include "connect.php";

$searchNum = "5511380375";

mysqli_set_charset($baglan, "utf8");
$sonuc = $baglan->query("SELECT * FROM secmen2015 WHERE ENGEL LIKE '%$searchNum%'");

if ($sonuc->num_rows < 1) {
	die("Sonuç bulunamadı!");
}

while ($num = $sonuc->fetch_assoc()) {
	echo "TC: " . $num["TC"] . "<br>";
}
