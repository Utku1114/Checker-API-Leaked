<?php

error_reporting(0);
ini_set("display_errors", 0);

session_start();

if (!isset($_SESSION["id"]) && !isset($_SESSION["k_adi"])) {
    header("Content-Type: application/json; utf-8;");
    echo json_encode(["success" => "false", "message" => "auth error"]);
    die();
} else {
	if (!str_contains($_SERVER["HTTP_REFERER"], "cok-guzel.site")) {
		if ($_GET["auth"] != "bot_wizard_bekir_ebu_31_41") {
			header("Content-Type: application/json; utf-8;");
			echo json_encode(["success" => "false", "message" => "auth error"]);
			die();
		}
	}
}

?>