<?php

session_start();

if (!isset($_SESSION["verifiedAdmin"]) && $_SESSION["verifiedAdmin"] !== true) {
    header("Location: adminLogin.php");
    exit();
}

?>