<?php

include 'checkDogrulamaAdmin.php';
include 'adminHeader.php';
include 'connect.php';

?>

<div class="card ">
    <div class="card-header">
        <h3>
            <i class="fas fa-users mr-2"></i>
            Key List
            <span class="float-right">Welcome!
                <strong>
                    <span class="badge badge-lg badge-secondary text-white">
                        <?php
                            $username = $_SESSION["username"];
                            if (isset($username)) {
                                echo $username;
                            }
                        ?>
                    </span>
                </strong>
            </span>
        </h3>
    </div>
    <div class="card-body pr-2 pl-2">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Verify Key</th>
                    <th class="text-center">IP</th>
                    <th class="text-center">Verified</th>
                    <th class="text-center">Uses</th>
                    <th class="text-center">Use Limit</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Tools</th>
                </tr>
            </thead>
            <tbody align="center">
                <?php
                    $query = "SELECT * FROM dogrulama";
                    $keys = $baglan->query($query);
                    while ($row = $keys->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row["id"] ?></td>
                        <td><?= $row["verify_key"] ?></td>
                        <td><?= $row["ip"] ?></td>
                        <td><?= $row["verified"] ?></td>
                        <td><?= $row["uses"] ?></td>
                        <td><?= $row["use_limit"] ?></td>
                        <td><?= $row["created"] ?></td>
                        <td>
                            <button onclick="deleteKey(<?= $row['id'] ?>)" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <button onclick="deactiveKey(<?= $row['id'] ?>)" class="btn btn-warning btn-sm">
                                <i class="fas fa-ban"></i>
                            </button>
                            <button onclick="activeKey(<?= $row['id'] ?>)" class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i>
                            </button>
                            <button onclick="resetKey(<?= $row['id'] ?>)" class="btn btn-warning btn-sm">
                                <i class="fas fa-undo"></i>
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
            </tbody>
        </table>
        <script src="cdn/jquery.min.js"></script>
        <script>
            function deleteKey(id) {
                var x = confirm("Bu anahtarı silmek istediğinize emin misiniz?");
                if (x) {
                    $.ajax({
                        url: 'adminTools.php?remove=' + id,
                        type: 'GET',
                        success: function(response) {
                            if (response == "success") {
                                alert("Anahtar silindi!");
                                location.reload();
                            } else {
                                alert("Anahtar silinemedi!");
                            }
                        }
                    });
                }
            }

            function deactiveKey(id) {
                var x = confirm("Bu anahtarı devre dışı bırakmak istediğinize emin misiniz?");
                if (x) {
                    $.ajax({
                        url: 'adminTools.php?deactive=' + id,
                        type: 'GET',
                        success: function(response) {
                            if (response == "success") {
                                alert("Anahtar devre dışı bırakıldı!");
                                location.reload();
                            } else {
                                alert("Anahtar devre dışı bırakılamadı!");
                            }
                        }
                    });
                }
            }

            function activeKey(id) {
                var x = confirm("Bu anahtarı aktif etmek istediğinize emin misiniz?");
                if (x) {
                    $.ajax({
                        url: 'adminTools.php?active=' + id,
                        type: 'GET',
                        success: function(response) {
                            if (response == "success") {
                                alert("Anahtar aktif edildi!");
                                location.reload();
                            } else {
                                alert("Anahtar aktif edilemedi!");
                            }
                        }
                    });
                }
            }

            function resetKey(id) {
                var x = confirm("Bu anahtarı sıfırlamak istediğinize emin misiniz?");
                if (x) {
                    $.ajax({
                        url: 'adminTools.php?reset=' + id,
                        type: 'GET',
                        success: function(response) {
                            if (response == "success") {
                                alert("Anahtar sıfırlandı!");
                                location.reload();
                            } else {
                                alert("Anahtar sıfırlanamadı!");
                            }
                        }
                    });
                }
            }
        </script>
    </div>
</div>