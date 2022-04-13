<?php

include "adminHeader.php";
include "connect.php";

?>
<div class="card ">
    <div class="card-header">
        <h3 class='text-center'>Add New Key</h3>
    </div>
    <div class="cad-body">
        <div style="width:600px; margin:0px auto">
            <form class="" action="" method="post">
                <div class="form-group pt-3">
                    <label for="name">Maxiumum Uses</label>
                    <input type="number" name="maxuses" max="100" min="1" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" name="addKey" class="btn btn-success">Add Key</button>
                </div>
            </form>
        </div>
    </div>
    <div style="text-align: center; padding-left: 50px; padding-right: 50px;">
        <?php
        if (isset($_POST['addKey'])) {
            function generateRandomString($length = 10) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
            }

            $maxuses = $_POST['maxuses'];
            $key = generateRandomString(20);
            $sql = "INSERT INTO dogrulama (verify_key, use_limit, uses, created) VALUES ('$key', '$maxuses', 0, NOW())";
            $baglan->query($sql);
            echo "<div class='alert alert-success'>Key Added - <b>$key</b> / <b>$maxuses</b></div>";
        }
        ?>
    </div>
</div>