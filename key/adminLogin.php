<?php

session_start();

include 'connect.php';

if (isset($_SESSION["verifiedAdmin"]) && $_SESSION["verifiedAdmin"] == true) {
    header("Location: admin.php");
    exit;
}

if (isset($_POST["submit"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM adminLogin WHERE username = '$username' AND password = '$password'";
    $result = $baglan->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION["verifiedAdmin"] = true;
        $_SESSION["username"] = $username;
        header("Location: admin.php");
        exit;
    } else {
        echo "<center style='color: red; font-size: 20px; font-weight: bold;'>Yanlış kullanıcı adı ve şifre!</center>";
    }
}

?>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Admin Giriş Sayfası</title>
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
	<link rel="stylesheet" href="cdn/adminStyle.css">

</head>

<body>
	<h2>Admin Giriş Sayfası</h2>
	<div class="container" id="container">
		<div class="form-container sign-in-container">
			<form action="#" method="post">
				<h1>Giriş Yapınız</h1>
				<input type="username" name="username" placeholder="Kullanıcı Adı" />
				<input type="password" name="password" placeholder="Şifre" />
				<button type="submit" name="submit">Giriş</button>
			</form>
		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-right">
					<h1>Wizard Farkı</h1>
					<p>:DDDDDDDDDDDDDDDDD</p>
					<button class="ghost" id="signUp">I Love You</button>
				</div>
			</div>
		</div>
	</div>

	<script src="cdn/adminScript.js"></script>

</body>

</html>