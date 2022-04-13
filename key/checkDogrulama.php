<?php

session_start();
include 'connect.php';

if (!isset($_SESSION["verifiedUser"]) && $_SESSION["verifiedUser"] !== true) {
	header("Location: dogrula.php");
	exit();
} else {
	$verify_key = $_SESSION["verify_key"];
    $result = $baglan->query("SELECT * FROM dogrulama WHERE verify_key='$verify_key'");
	$result_array = $result->fetch_assoc();
	
	if ($result->num_rows < 1) {
		unset($_SESSION["verifiedUser"]);
		header("Location: dogrula.php");
		exit();
	} else if ($result_array["verified"] === "false") {
		unset($_SESSION["verifiedUser"]);
		header("Location: dogrula.php");
		exit();
	}
}

?>