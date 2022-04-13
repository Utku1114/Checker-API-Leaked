<?php

include 'connect.php';

if (isset($_GET['remove'])) {
    $remove = (int)preg_replace('/[^0-9]/', '', $_GET['remove']);
    $query = "DELETE FROM dogrulama WHERE id='$remove'";
    $result = $baglan->query($query);
    echo "success";
}

if (isset($_GET['deactive'])) {
    $deactive = (int)preg_replace('/[^0-9]/', '', $_GET['deactive']);
    $query = "UPDATE dogrulama SET verified='false' WHERE id='$deactive'";
    $result = $baglan->query($query);
    echo "success";
}

if (isset($_GET['active'])) {
    $active = (int)preg_replace('/[^0-9]/', '', $_GET['active']);
    $query = "UPDATE dogrulama SET verified='true' WHERE id='$active'";
    $result = $baglan->query($query);
    echo "success";
}

if (isset($_GET['reset'])) {
    $reset = (int)preg_replace('/[^0-9]/', '', $_GET['reset']);
    $query = "UPDATE dogrulama SET ip='', verified='', uses='0' WHERE id='$reset'";
    $result = $baglan->query($query);
    echo "success";
}

?>