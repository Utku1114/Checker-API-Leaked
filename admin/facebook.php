<?php
include_once "../server/rolecontrol.php";

$customCSS = array('<link href="../assets/plugins/DataTables/datatables.min.css" rel="stylesheet">');
$customJAVA = array(
    '<script src="../assets/plugins/DataTables/datatables.min.js"></script>',
    '<script src="../assets/plugins/printer/main.js"></script>',
    '<script src="../assets/js/pages/datatables.js"></script>'

);

$page_title = 'Facebook';
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
                    <h4 class="card-title mb-4">Facebook</h4>
                    <p class="mb-1">
                    <p>
                        Sorgulanacak Numarayı Giriniz.</br>
                    </p>
                    </p>
                    <div class="block-content tab-content">
                        <div class="tab-pane active" id="tc" role="tabpanel">
                            <input maxlength="10" minlength="10" type="text" class="form-control" id="numara" placeholder="Telefon Numarası: 5375890898"><br>
                        </div>

                        <center>
                            <button onclick="checkNumber()" id="sorgula" name="yolla" class="btn waves-effect waves-light btn-rounded btn-primary" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"><i class="fas fa-search"></i> Sorgula
                                <button onclick="clearResults()" id="durdurButon" type="button" class="btn waves-effect waves-light btn-rounded btn-danger" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"><i class="fas fa-trash-alt"></i> Sıfırla</button>
                                <button onclick="printTable()" id="yazdirTable" type="button" class="btn waves-effect waves-light btn-rounded btn-warning" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"><i class="fas fa-print"></i> Yazdır Detay</button><br><br>
                        </center>
                        <div class="table-responsive">

                            <table id="zero-conf" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Telefon</th>
                                        <th>Ad</th>
                                        <th>Soyad</th>
                                        <th>Bağlantı</th>
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
            $("#jojjoojj").html("");
            $("#numara").val("");
        }

        function checkNumber() {
            var roleNumber = "<?= $k_rol ?>";
            if (parseInt(roleNumber) == 1 || parseInt(roleNumber) == 2) {
                var number = $("#numara").val();
                $.Toast.showToast({
                    "title": "Sorgulanıyor...",
                    "icon": "loading",
                    "duration": 60000
                });
                $.ajax({
                    url: "../api/facebook/api.php",
                    type: "POST",
                    data: {
                        phone: number
                    },
                    success: (res) => {
                        var json = res;
                        if (json.success === "true") {
                            $.Toast.hideToast();
                            var id = json.message[0].fb_id;
                            var phone = json.message[0].fb_phone;
                            var name = json.message[0].fb_name;
                            var surname = json.message[0].fb_surname;
                            var link = json.message[0].fb_link;

                            $("#jojjoojj").html(
                                "<tr>" +
                                "<th>" +
                                id +
                                "</th>" +
                                "<th>" +
                                phone +
                                "</th>" +
                                "<th>" +
                                name +
                                "</th>" +
                                "<th>" +
                                surname +
                                "</th>" +
                                "<th>" +
                                link +
                                "</th>" +
                                "</tr>"
                            )
                        } else {
                            $.Toast.hideToast();
                            Swal.fire({
                                icon: 'error',
                                title: 'Bulunamadı!',
                                text: 'Girdiğiniz telefon numarası ile eşleşen bir bilgi bulunamadı.',
                            })
                        }
                    }
                });
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