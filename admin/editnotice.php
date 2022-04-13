<?php
$customCSS = array();
$customJAVA = array();

date_default_timezone_set('Europe/Istanbul');

require '../server/baglan.php';
require '../server/admincontrol.php';
$page_title = 'Duyuru Düzenle';
include('inc/header_main.php');
include('inc/header_sidebar.php');
include('inc/header_native.php');

$id = intval(preg_replace("/[^0-9]+/", "", $_GET["id"]));

if (empty($id)) {
    header("Location: /notice");
	exit;
}

$wizort = $conn->query("SELECT * FROM `sh_duyuru` WHERE id='$id'");
if ($wizort->num_rows < 1) {
	header("Location: /notice");
	exit;
}

$nowDate = date("d.m.Y");
$success = "";
$statustext = "";

if (isset($_POST['icerik'])) {
    $icerik = htmlspecialchars($_POST['icerik']);
	
	if (empty($icerik)) {
		echo "<script>alert('Lütfen bir duyuru içeriği girin!')</script>";
	} else {
		$query = "UPDATE `sh_duyuru` SET d_icerik='$icerik',d_time='$nowDate' WHERE id='$id'";

		if ($conn->query($query) === TRUE) {
			header('location: /editnotice/' . $id);
		} else {
			header('location: /notice');
		}
	}
}

if (str_contains($_SERVER["HTTP_REFERER"], "editnotice/$id")) {
    $statustext = "Duyuru Düzenlendi!";
} else {
    $statustext = "Duyuruyu Düzenleyin!";
}

?>

<center>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <br>
    <?php
    $query = mysqli_query($conn, "SELECT * FROM `sh_kullanici` WHERE id='$id'");
    while ($getvar = mysqli_fetch_assoc($query)) { ?>
        <div class="table-responsive">
            <table id="zero-conf" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Duyuru İçeriği</th>
                        <th>Yayın Tarihi</th>
                    </tr>
                </thead>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM `sh_duyuru` WHERE id='$id'");
                while ($getvar = mysqli_fetch_assoc($query)) {
                    echo '<tr><td>' . $getvar['d_icerik'] . '</td><td>' . $getvar['d_time'] . '</td>';
                }
                ?>
            </table>
        </div><br>
        <div class="tab-pane active" role="tabpanel">
            <h4 class="card-title mb-4"><img style="width: 30px;height: auto; margin-right: -25px;" alt=""><?php echo $statustext ?></h4>
            <form method="post">
                <input class="form-control" type="text" name="icerik" id="icerik" placeholder="<?php echo $success ? $success : "Duyuru içeriği giriniz!" ?>"><br>
        </div>
        <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"><i class="fas fa-search"></i> Paylaş </button>
        </form>
    <?php } ?>
</center>


<!--BİTİŞ-->
<?php
include('inc/footer_native.php');
include('inc/footer_main.php');
?>