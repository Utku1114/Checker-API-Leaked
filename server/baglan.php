<?php
ob_start();
session_start();
error_reporting(0);

$host = 'localhost';
$kullanici = 'root';
$sifre = '';
$db_isim = 'liberal';

$conn = new MySQLi($host, $kullanici, $sifre, $db_isim);
mysqli_set_charset($conn, "utf8");

if ($conn->connect_error) {
	die('Veritabanı Bağlantısı Hatası: ' . $conn->connect_error);
}

/*else {
    echo ("Bağlantı başarılı hocam");
}
<?php
	$conn=mysqli_connect("localhost", "root", "", "boobsi");
	
	if(!$conn){
		die("Error: Failed to connect to database!");
	}
?>*/