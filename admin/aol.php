<?php
include_once "../server/rolecontrol.php";

$customCSS = array('<link href="../assets/plugins/DataTables/datatables.min.css" rel="stylesheet">');
$customJAVA = array(
    '<script src="../assets/plugins/DataTables/datatables.min.js"></script>',
    '<script src="../assets/plugins/printer/main.js"></script>',
    '<script src="../assets/js/pages/datatables.js"></script>',
    '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.0/dist/sweetalert2.all.min.js"></script>'
);

$page_title = 'A.Ö.L Sorgu';
include('inc/header_main.php');
include('inc/header_sidebar.php');
include('inc/header_native.php');

?>
<!--<div class="page-content">-->
<!--BAŞLANGIC-->
<div class="row">
    <div class="col-xl-12 col-md-6">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">A.Ö.L</h4>
                    <p class="mb-1">
                    <p>Sorgulanacak Kişinin T.C. Nosunu Giriniz.</p>
                    <div class="block-content tab-content">
                        <div class="tab-pane active" id="tc" role="tabpanel">

                            <input require maxlength="11" class="form-control" type="text" name="tcno" id="tcno" placeholder="TC"><br>
                            <center>
                                <button onclick="checkNumber()" id="sorgula" name="yolla" class="btn waves-effect waves-light btn-rounded btn-primary" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"><i class="fas fa-search"></i> Sorgula </button>
                                <button onclick="clearResults()" id="durdurButon" type="button" class="btn waves-effect waves-light btn-rounded btn-danger" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"><i class="fas fa-trash-alt"></i> Sıfırla </button>
                                <button onclick="printTable()" id="yazdirTable" type="button" class="btn waves-effect waves-light btn-rounded btn-warning" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"><i class="fas fa-print"></i> Yazdır Detay </button><br><br>
                            </center>
                            <center>
                                <div class="col-xl-2 col-md-6">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 &nbsp;="" class="card-title mb-4"><i class="fas fa-camera"></i> Vesikalık F.</h4>
                                                <img id="KimlikFotograf" src="../upload/profile/default.gif" style="border-radius: 12px;" width="140" height="140" class="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </center>
                            <div class="table-responsive">
                                <table id="zero-conf" class="table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Öğrenci No</th>
                                            <th>Ad</th>
                                            <th>Soyad</th>
                                            <th>Anne Adı</th>
                                            <th>Baba Adı</th>
                                            <th>Okul/Alan</th>
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
    </div>
</div>

<script>
    function clearResults() {
        $("#jojjoojj").html('<tr class="odd"><td valign="top" colspan="21" class="dataTables_empty">No data available in table</td></tr>');
        $("#tcno").val("");
		$("#KimlikFotograf").attr("src", "../upload/profile/default.gif")
    }

    function checkNumber() {
        return Swal.fire({
            icon: "warning",
            title: "Oooooopss...",
            text: "Bu çözüm şu an bakımdadır!"
        });

        var roleNumber = "<?= $k_rol ?>";

        if (parseInt(roleNumber) == 1 || parseInt(roleNumber) == 2) {
            var tc = $("#tcno").val();
            var captcha = $("#captcha").val();
            $.Toast.showToast({
                "title": "Sorgulanıyor...",
                "icon": "loading",
                "duration": 60000
            });
            $.ajax({
                url: "../api/aol/api.php",
                type: "POST",
                data: {
                    tc: tc,
                },
                success: (res) => {
                    var json = JSON.parse(res);
                    if (json.success === "false") {
                        $.Toast.hideToast();
                        Swal.fire({
                            icon: 'error',
                            title: 'Bulunamadı!',
                            text: 'Girdiğiniz TC kimlik numarası ile eşleşen bir bilgi bulunamadı.',
                        })
                        return;
                    } else if (json.success === "true") {
                        $.Toast.hideToast();
                        var ogrencino = json.ogrencino;
                        var ad = json.name;
                        var soyad = json.surname;
                        var babaadi = json.fathername
                        var anneadi = json.mothername;
                        var okulalan = json.school;

                        $("#KimlikFotograf").attr("src", json.image);
                        $("#jojjoojj").html(
                            "<tr>" +
                            "<td>" + ogrencino + "</td>" +
                            "<td>" + ad + "</td>" +
                            "<td>" + soyad + "</td>" +
                            "<td>" + anneadi + "</td>" +
                            "<td>" + babaadi + "</td>" +
                            "<td>" + okulalan + "</td>" +
                            "</tr>"
                        )
                    } else {
                        $.Toast.hideToast();
                        Swal.fire({
                            icon: 'error',
                            title: 'Bulunamadı!',
                            text: 'Girdiğiniz TC kimlik numarası ile eşleşen bir bilgi bulunamadı.',
                        })
                        return;
                    }
                },
                error: () => {
                    $.Toast.hideToast();
                    Swal.fire({
                        icon: 'error',
                        title: "Sunucu hatası!",
                        text: 'Lütfen yönetici ile iletişime geçin.'
                    })
                    return;
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