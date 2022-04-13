<?php
include_once "../server/rolecontrol.php";

$customCSS = array('<link href="../assets/plugins/DataTables/datatables.min.css" rel="stylesheet">');
$customJAVA = array(
    '<script src="../assets/plugins/DataTables/datatables.min.js"></script>',
    '<script src="../assets/plugins/printer/main.js"></script>',
    '<script src="../assets/js/pages/datatables.js"></script>',
    '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.0/dist/sweetalert2.all.min.js"></script>'

);

$page_title = 'TC Adres';
include('inc/header_main.php');
include('inc/header_sidebar.php');
include('inc/header_native.php');

error_reporting(0);

?>
<!--<div class="page-content">-->
<!--BAŞLANGIC-->
<div class="row">
    <div class="col-xl-12 col-md-6">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">TC Adres</h4>
                    <p class="mb-1">
                    <p>
                        Adresini öğrenmek istediğiniz TC kimlik numarasını girin.</br>
                    </p>
                    </p>
                    <div class="block-content tab-content">
                        <div class="tab-pane active" id="tc" role="tabpanel">

                            <input required maxlength="11" class="form-control" type="text" name="tcno" id="tcno" placeholder="TC"><br>

                            <center>
                                <button onclick="checkNumber()" id="sorgula" name="yolla" class="btn waves-effect waves-light btn-rounded btn-primary" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"><i class="fas fa-search"></i> Sorgula </button>
                                <button onclick="clearResults()" id="durdurButon" type="button" class="btn waves-effect waves-light btn-rounded btn-danger" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"><i class="fas fa-trash-alt"></i> Sıfırla </button>
                                <button onclick="printTable()" id="yazdirTable" type="button" class="btn waves-effect waves-light btn-rounded btn-warning" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"><i class="fas fa-print"></i> Yazdır Detay </button><br><br>
                            </center>
                            <div class="table-responsive">

                                <table id="zero-conf" class="table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Ad</th>
                                            <th>Soyad</th>
                                            <th>Açık Adres</th>
                                        </tr>
                                    </thead>
                                    <tbody id="jojjoojj">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function clearResults() {
                $("#jojjoojj").html('<tr class="odd"><td valign="top" colspan="21" class="dataTables_empty">No data available in table</td></tr>');
                $("#tcno").val("");
            }

            function checkNumber() {
                /*
                return Swal.fire({
                    icon: "warning",
                    title: "Oooooopss...",
                    text: "Bu çözüm şu an bakımdadır!"
                });
                */

                var roleNumber = "<?= $k_rol ?>";

                if (parseInt(roleNumber) == 1 || parseInt(roleNumber) == 2) {
                    var tc = $("#tcno").val();
                    $.Toast.showToast({
                        "title": "Sorgulanıyor...",
                        "icon": "loading",
                        "duration": 60000
                    });
                    $.ajax({
                        url: "../api/check/api.php",
                        type: "POST",
                        data: {
                            tc: tc,
                            method: "adres"
                        },
                        success: (res) => {
                            var json = res;
                            if (json.status === "success") {
                                $.Toast.hideToast();
                                var ad = json.person.ad;
                                var soyad = json.person.soyad;
                                var adres = json.person.acikAdres;

                                $("#jojjoojj").html(
                                    "<tr>" +
                                    "<th>" +
                                    ad +
                                    "</th>" +
                                    "<th>" +
                                    soyad +
                                    "</th>" +
                                    "<th>" +
                                    adres +
                                    "</th>" +
                                    "</tr>"
                                )
                            } else {
                                $.Toast.hideToast();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Bulunamadı!',
                                    text: 'Girdiğiniz TC kimlik numarası ile eşleşen bir bilgi bulunamadı.',
                                })
                            }
                        },
                        error: () => {
                            $.Toast.hideToast();
                            Swal.fire({
                                icon: 'error',
                                title: "Sunucu hatası!",
                                text: 'Lütfen yönetici ile iletişime geçin.'
                            })
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Bu çözümü kullanman için yeterli yetkin bulunmuyor!',
                    })
                }
            }
        </script>


    </div>
    <!--BİTİŞ-->
    <?php
    include('inc/footer_native.php');
    include('inc/footer_main.php');
    ?>