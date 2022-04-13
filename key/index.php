<?php

include "checkDogrulama.php";

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
	unset($_SESSION['verifiedUser']);
	header('location: dogrula.php');
	exit();
}

?>
<!DOCTYPE html>
<html lang="tr">

<head>
	<title>WizarD Data Checker</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="cdn/w.png">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700'>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: "Montserrat", "Trebuchet MS", Helvetica, sans-serif;
			background-color: #26a6d4;
		}

		.card {
			background-color: #fff;
			width: 215px;
			height: 49px;
			border-radius: 20px;
			padding-top: 7px;
		}

		.card .input {
			width: 200px;
			height: 35px;
		}

		.card .input input::placeholder {
			color: rgb(218, 213, 213);
		}

		.card .input input {
			font-family: "Montserrat", "Trebuchet MS", Helvetica, sans-serif;
			width: 100%;
			height: 100%;
			border: none;
			outline: none;
			text-align: center;
			background: #009ED8;
			font-size: 15px;
			color: #fff;
			padding-left: 10px;
			padding-right: 10px;
			border-radius: 20px;
		}

		.button {
			display: inline-block;
			font-family: "Montserrat", "Trebuchet MS", Helvetica, sans-serif;
			-webkit-font-smoothing: antialiased;
			position: relative;
			padding: .8em 1.4em;
			padding-right: 4.7em;
			background: #009ED8;
			border: 2px solid #fff;
			color: white;
			transition: .2s;
			border-radius: 5px;
		}

		.button:before,
		.button:after {
			position: absolute;
			top: 0;
			bottom: 0;
			right: 0;
			padding-top: inherit;
			padding-bottom: inherit;
			width: 2.8em;
			content: "\00a0";
			font-family: 'FontAwesome', sans-serif;
			font-size: 1.2em;
			text-align: center;
			transition: .2s;
			transform-origin: 50% 60%;
		}

		.button:before {
			background: rgba(0, 0, 0, 0.1);
		}

		.button:hover {
			background: #0079a5;
			cursor: pointer;
		}

		.button:active,
		.button:focus {
			background: #002e3f;
			outline: none;
		}

		.button {
			min-width: 15em;
		}

		.search:after {
			content: "\f002";
		}

		.search:hover:after {
			-webkit-animation: none;
			-webkit-transform: scale(1.4);
			animation: none;
			transform: scale(1.4);
		}

		@-webkit-keyframes bounceright {
			from {
				-webkit-transform: translateX(0);
			}

			to {
				-webkit-transform: translateX(3px);
			}
		}

		@-webkit-keyframes wiggle {
			from {
				-webkit-transform: rotate(0deg);
			}

			to {
				-webkit-transform: rotate(30deg);
			}
		}

		@keyframes bounceright {
			from {
				transform: translateX(0);
			}

			to {
				transform: translateX(3px);
			}
		}

		@keyframes wiggle {
			from {
				transform: rotate(0deg);
			}

			to {
				transform: rotate(30deg);
			}
		}

		label {
			cursor: pointer;
		}

		input[type="checkbox"] {
			cursor: pointer;
		}

		table {
			text-align: center;
			margin-top: 25px;
		}

		table input[type="text"] {
			font-weight: bold;
			font-size: 15px;
			text-align: center;
		}

		table td {
			padding: 7px;
			display: inline-block;
			margin-bottom: 7px;
		}

		#optionsDiv {
			display: flex;
			align-items: center;
			justify-content: center;
		}
	</style>
	<link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
</head>

<body>
	<center>
		<form action="check.php" method="get">
			<input type="hidden" id="dataText" name="dataText">
			<div id="optionsDiv">
				<table>
					<tr>
						<td align="center">
							<div class="card">
								<div class="input">
									<input id="tcText" type="text" autocomplete="off" placeholder="TC">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div class="card">
								<div class="input">
									<input id="isimText" type="text" autocomplete="off" placeholder="ADI">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div class="card">
								<div class="input">
									<input id="soyadText" type="text" autocomplete="off" placeholder="SOYADI">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div class="card">
								<div class="input">
									<input id="anneadiText" type="text" autocomplete="off" placeholder="ANNE ADI">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div class="card">
								<div class="input">
									<input id="babaadiText" type="text" autocomplete="off" placeholder="BABA ADI">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div class="card">
								<div class="input">
									<input id="dogumyeriText" type="text" autocomplete="off" placeholder="DOGUM YERİ">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div class="card">
								<div class="input">
									<input id="dogumtarihiText" type="text" autocomplete="off" placeholder="DOGUM TARİHİ (Y-A-G)">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div class="card">
								<div class="input">
									<input id="cinsiyetText" type="text" autocomplete="off" placeholder="CİNSİYETİ (K-E)">
								</div>
							</div>
						</td>
					</tr>
				</table>
				<table>
					<tr>
						<td align="center">
							<div class="card">
								<div class="input">
									<input id="nufusiliText" type="text" autocomplete="off" placeholder="NÜFUS İLİ">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div class="card">
								<div class="input">
									<input id="nufusilcesiText" type="text" autocomplete="off" placeholder="NÜFUS İLÇESİ">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div class="card">
								<div class="input">
									<input id="adresiliText" type="text" autocomplete="off" placeholder="ADRES İLİ">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div class="card">
								<div class="input">
									<input id="adresilcesiText" type="text" autocomplete="off" placeholder="ADRES İLÇESİ">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div class="card">
								<div class="input">
									<input id="adresmahallesiText" type="text" autocomplete="off" placeholder="ADRES MAHALLESİ">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div class="card">
								<div class="input">
									<input id="adrescaddesiText" type="text" autocomplete="off" placeholder="ADRES CADDESİ/SOKAĞI">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div class="card">
								<div class="input">
									<input id="adresbinanoText" type="text" autocomplete="off" placeholder="BİNA NO">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div class="card">
								<div class="input">
									<input id="adresdairenoText" type="text" autocomplete="off" placeholder="DAİRE NO">
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<button class="button search">Sorgula</button>
			<br> <br>
			<a href="?action=logout" style="color: white; text-decoration: none; font-size: 20px;"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
		</form>
	</center>

	<!-- footer
	<footer align="center" style="margin-top: 20px; color: #fff;">
		Created by <span style="font-weight: bold; font-size: 17px; color: #000;">WizarD</span> & Supported by <span style="font-weight: bold; font-size: 17px; color: #000;">AyDee</span> and <span style="font-weight: bold; font-size: 17px; color: #000;">DenizXD</span>
	</footer>
	-->

	<script>
		window.onload = function() {
			var dataText = document.getElementById("dataText")
			var tcText = document.getElementById("tcText").value
			var adText = document.getElementById("isimText").value
			var soyadText = document.getElementById("soyadText").value
			var anneadiText = document.getElementById("anneadiText").value
			var babaadiText = document.getElementById("babaadiText").value
			var dogumyeriText = document.getElementById("dogumyeriText").value
			var dogumtarihiText = document.getElementById("dogumtarihiText").value
			var cinsyetiText = document.getElementById("cinsiyetText").value
			var nufusiliText = document.getElementById("nufusiliText").value
			var nufusilcesiText = document.getElementById("nufusilcesiText").value
			var adresiliText = document.getElementById("adresiliText").value
			var adresilcesiText = document.getElementById("adresilcesiText").value
			var adresmahallesiText = document.getElementById("adresmahallesiText").value
			var adrescaddesiText = document.getElementById("adrescaddesiText").value
			var adresbinanoText = document.getElementById("adresbinanoText").value
			var adresdairenoText = document.getElementById("adresdairenoText").value

			let data = ""

			window.addEventListener('change', (e) => {
				tcText = document.getElementById("tcText").value
				adText = document.getElementById("isimText").value
				soyadText = document.getElementById("soyadText").value
				anneadiText = document.getElementById("anneadiText").value
				babaadiText = document.getElementById("babaadiText").value
				dogumyeriText = document.getElementById("dogumyeriText").value
				dogumtarihiText = document.getElementById("dogumtarihiText").value
				cinsyetiText = document.getElementById("cinsiyetText").value
				nufusiliText = document.getElementById("nufusiliText").value
				nufusilcesiText = document.getElementById("nufusilcesiText").value
				adresiliText = document.getElementById("adresiliText").value
				adresilcesiText = document.getElementById("adresilcesiText").value
				adresmahallesiText = document.getElementById("adresmahallesiText").value
				adrescaddesiText = document.getElementById("adrescaddesiText").value
				adresbinanoText = document.getElementById("adresbinanoText").value
				adresdairenoText = document.getElementById("adresdairenoText").value

				data = "startValueOfDataTextYouCutThisTextForSearchData"

				if (tcText != "") {
					if (data.indexOf("AND TC=") == -1) {
						data = `${data} AND TC='${tcText}'`
					}
				}
				if (adText != "") {
					if (data.indexOf("AND ADI=") == -1) {
						data = `${data} AND ADI='${adText}'`
					}
				}
				if (soyadText != "") {
					if (data.indexOf("AND SOYADI=") == -1) {
						data = `${data} AND SOYADI='${soyadText}'`
					}
				}
				if (anneadiText !== "") {
					if (data.indexOf("AND ANAADI=") == -1) {
						data = `${data} AND ANAADI='${anneadiText}'`
					}
				}
				if (babaadiText !== "") {
					if (data.indexOf("AND BABAADI=") == -1) {
						data = `${data} AND BABAADI='${babaadiText}'`
					}
				}
				if (dogumyeriText !== "") {
					if (data.indexOf("AND DOGUMYERI=") == -1) {
						data = `${data} AND DOGUMYERI='${dogumyeriText}'`
					}
				}
				if (dogumtarihiText !== "") {
					if (data.indexOf("AND DOGUMTARIHI=") == -1) {
						data = `${data} AND DOGUMTARIHI='${dogumtarihiText}'`
					}
				}
				if (cinsyetiText !== "") {
					if (data.indexOf("AND = CINSIYETI=") == -1) {
						data = `${data} AND CINSIYETI='${cinsyetiText}'`
					}
				}
				if (nufusiliText !== "") {
					if (data.indexOf("AND NUFUSILI=") == -1) {
						data = `${data} AND NUFUSILI='${nufusiliText}'`
					}
				}
				if (nufusilcesiText !== "") {
					if (data.indexOf("AND NUFUSILCESI=") == -1) {
						data = `${data} AND NUFUSILCESI='${nufusilcesiText}'`
					}
				}
				if (adresiliText !== "") {
					if (data.indexOf("AND ADRESIL=") == -1) {
						data = `${data} AND ADRESIL='${adresiliText}'`
					}
				}
				if (adresilcesiText !== "") {
					if (data.indexOf("AND ADRESILCE=") == -1) {
						data = `${data} AND ADRESILCE='${adresilcesiText}'`
					}
				}
				if (adresmahallesiText !== "") {
					if (data.indexOf("MAHALLE") == -1) {
						data = `${data} AND MAHALLE='${adresmahallesiText}'`
					}
				}
				if (adrescaddesiText !== "") {
					if (data.indexOf("AND CADDE=") == -1) {
						data = `${data} AND CADDE='${adrescaddesiText}'`
					}
				}
				if (adresbinanoText !== "") {
					if (data.indexOf("AND KAPINO=") == -1) {
						data = `${data} AND KAPINO='${adresbinanoText}'`
					}
				}
				if (adresdairenoText !== "") {
					if (data.indexOf("AND DAIRENO=") == -1) {
						data = `${data} AND DAIRENO='${adresdairenoText}'`
					}
				}

				dataText.value = data
			})
		}
	</script>
</body>

</html>