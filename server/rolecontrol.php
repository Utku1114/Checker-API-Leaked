<?php
require '../server/baglan.php';
$uid = $_SESSION['id'];
$query = mysqli_query($conn, "SELECT * FROM `sh_kullanici` WHERE id='$uid'");
while ($getvar = mysqli_fetch_assoc($query)) {
    $k_rol = $getvar['k_rol'];
}
