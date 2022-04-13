<?php
$customCSS = array();
$customJAVA = array(
    '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.0/dist/sweetalert2.all.min.js"></script>'
);

require '../server/baglan.php';
require '../server/admincontrol.php';

$page_title = 'User Settings';

include('inc/header_main.php');
include('inc/header_sidebar.php');
include('inc/header_native.php');

$id = intval(preg_replace("/[^0-9]+/", "", htmlspecialchars($_GET["id"])));
if (!isset($id) || empty($id)) {
    header("Location: /users");
    die();
}

$yetkii = strip_tags(htmlspecialchars($_POST["yetkii"]));

if (isset($yetkii) && !isset($_POST["sil"])) {
    if ($yetkii === "0" || $yetkii === "2") {
        if ($yetkii === "0") {
            $newDate = 1;
        } else {
            date_default_timezone_set('Europe/Istanbul');
            $nowDate = date("Y-m-d");
            $newDate = strtotime('30 day', strtotime($nowDate));
            $newDate = date('Y-m-d', $newDate);
        }
        $query = "UPDATE `sh_kullanici` SET k_rol='$yetkii', u_time='$newDate' WHERE id=$id";

        if ($conn->query($query) !== TRUE) {
            echo $conn->error;
        } else {
            header('location: /edituser/' . $id);
        }
    }
}

if ($_POST["sil"] === "sil") {
    $sql = "DELETE FROM `sh_kullanici` WHERE `id`='$id'";
    if ($conn->query($sql) === TRUE) {
        header('location: /users');
    }
}
if ($_POST["deaktif"] === "deaktif") {
    $sql = "UPDATE `k_verified`='false' FROM `sh_kullanici` WHERE `id`='$id'";
    if ($conn->query($sql) === TRUE) {
        header('location: /edituser/' . $id);
    }
}
if ($_POST["aktif"] === "aktif") {
    $sql = "UPDATE `k_verified`='true' FROM `sh_kullanici` WHERE `id`='$id'";
    if ($conn->query($sql) === TRUE) {
        header('location: /edituser/' . $id);
    }
}

?>
<style>
    input[type="checkbox"].ios8-switch {
        position: absolute;
        margin: 8px 0 0 16px;
    }

    input[type="checkbox"].ios8-switch+label {
        position: relative;
        padding: 5px 0 0 50px;
        line-height: 2.0em;
    }

    input[type="checkbox"].ios8-switch+label:before {
        content: "";
        position: absolute;
        display: block;
        left: 0;
        top: 0;
        width: 40px;
        /* x*5 */
        height: 24px;
        /* x*3 */
        border-radius: 16px;
        /* x*2 */
        background: #fff;
        border: 1px solid #d9d9d9;
        -webkit-transition: all 0.3s;
        transition: all 0.3s;
    }

    input[type="checkbox"].ios8-switch+label:after {
        content: "";
        position: absolute;
        display: block;
        left: 0px;
        top: 0px;
        width: 24px;
        /* x*3 */
        height: 24px;
        /* x*3 */
        border-radius: 16px;
        /* x*2 */
        background: #fff;
        border: 1px solid #d9d9d9;
        -webkit-transition: all 0.3s;
        transition: all 0.3s;
    }

    input[type="checkbox"].ios8-switch+label:hover:after {
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }

    input[type="checkbox"].ios8-switch:checked+label:after {
        margin-left: 16px;
    }

    input[type="checkbox"].ios8-switch:checked+label:before {
        background: #55D069;
    }
</style>
<script>
    function onlyOne(checkbox) {
        var checkboxes = document.getElementsByName("yetkii")
        checkboxes.forEach((item) => {
            if (item !== checkbox) item.checked = false
        })
    }
</script>
<center>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <br>
    <?php
    $query = mysqli_query($conn, "SELECT * FROM `sh_kullanici` WHERE id='$id'");
    if ($query->num_rows < 1) {
        header("Location: /users");
    }
    while ($getvar = mysqli_fetch_assoc($query)) { ?>
        <div class="w3-container">
            <ul class="w3-ul w3-card-4">
                <li class="w3-bar" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <div class="w3-bar-item">
                        <span>Anahtar: <b><?php echo $getvar["k_key"]; ?></b></span>
                        <br>
                        <span>Üyelik: <b>
                                <?php
                                $rol = $getvar['k_rol'];
                                switch ($rol) {
                                    case '0':
                                        $yetki = "Freemium";
                                        break;
                                    case '1':
                                        $yetki = "Admin";
                                        break;
                                    case '2':
                                        $yetki = "SkyPremium";
                                        break;
                                }
                                echo $yetki;
                                ?>
                            </b>
                        </span>
                        <br>
                        <span>
                            Üyelik Durumu: <b>
                                <?php
                                $durum = "";
                                if ($getvar["k_verified"] === "true") {
                                    $durum = "Aktif";
                                } else {
                                    $durum = "Pasif";
                                }
                                echo $durum;
                                ?>
                            </b>
                        </span>
                        <br>
                        <span>
                            Üyelik Bitiş Tarihi: <b>
                                <?php
                                $uyetarih = $getvar['u_time'];
                                if ($uyetarih != "1") {
                                    $nowDate = date("Y-m-d");
                                    $d1 = new DateTime($nowDate);
                                    $d2 = new DateTime($uyetarih);
                                    $gun = $d1->diff($d2)->days;
                                    $uyeliktarih = $uyetarih;
                                } else if ($uyetarih == "1") {
                                    $uyeliktarih = "Üyelik Yok";
                                    $gun = "Üyelik Yok";
                                }
                                if (!empty($uyeliktarih)) {
                                    echo $uyeliktarih;
                                }
                                ?>
                            </b>
                        </span>
                        <br>
                        <span>
                            Kalan Gün: <b>
                                <?php
                                echo $gun;
                                ?>
                            </b>
                        </span>
                    </div>
                    <form method="POST" action="">
                        <?php
                        if ($checkID === $id) {
                        ?>
                            <h4 style="color: red;">Kendi profilini düzenleyemez veya silemezsin!</h4>
                        <?php
                        } else if ($id !== $checkID && $k_rol !== $rol) {
                        ?>
                            <input class="ios8-switch" onChange="this.form.submit()" <?php if ($rol === "0") echo "checked" ?> id="checkbox-1" type="checkbox" name="yetkii" value="0" onclick="onlyOne(this)">
                            <label for="checkbox-1" style="display: inline;">Freemium</label>
                            <input class="ios8-switch" onChange="this.form.submit()" <?php if ($rol === "2") echo "checked" ?> id="checkbox-2" type="checkbox" name="yetkii" value="2" onclick="onlyOne(this)">
                            <label for="checkbox-2" style="display: inline;">Premium</label>
                            <div style="display: flex; flex-direction: row; justify-content: center; align-items: center;">
                                <button onclick="this.form.submit()" name="sil" value="sil" class="btn waves-effect waves-light btn-rounded btn-danger" style="width: 30px; height: 30px; outline: none; margin-left: 5px; display: flex; justify-content: center; align-items: center;"><i class="fas fa-trash-alt"></i></button>
                                <button onclick="this.form.submit()" name="deaktif" value="deaktif" class="btn waves-effect waves-light btn-rounded btn-success" style="width: 30px; height: 30px; outline: none; margin-left: 5px; display: flex; justify-content: center; align-items: center;"><i class="fas fa-check"></i></button>
                                <button onclick="this.form.submit()" name="aktif" value="aktif" class="btn waves-effect waves-light btn-rounded btn-warning" style="width: 30px; height: 30px; outline: none; margin-left: 5px; display: flex; justify-content: center; align-items: center;"><i class="fas fa-ban"></i></button>
                            </div>
                        <?php
                        } else {
                        ?>
                            <h4 style="color: red;">Kendinle aynı yetkideki bir kullanıcıyı düzenleyemez veya silemezsin!</h4>
                        <?php
                        }
                        ?>
                    </form>
                </li>
            </ul>
        </div>
    <?php } ?>
</center>


<!--BİTİŞ-->
<?php
include('inc/footer_native.php');
include('inc/footer_main.php');
?>