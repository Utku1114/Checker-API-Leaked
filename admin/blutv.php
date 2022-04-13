<?php
include_once "../server/rolecontrol.php";

$customCSS = array();
$customJAVA = array(
    '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.0/dist/sweetalert2.all.min.js"></script>'
);

$page_title = 'BluTV';
include('inc/header_main.php');
include('inc/header_sidebar.php');
include('inc/header_native.php');
?>
<!--BAŞLANGIC-->
<div class="card-body">
    <div class="md-form">
        <div class="col-md-12">
            <center>
                <div class="md-form">
                    <h4 class="card-title mb-4"><i class="fas fa-user-circle"></i> Kronik BluTV Checker</h4>
                    <p>Bu bölümden BluTV hesaplarınızı kolaylıkla checkleyebilirsiniz!</p>
                    <div style="margin-bottom: 10px;">
                        <strong>Örnek format: </strong> <a>test@gmail.com:sifre</a>
                    </div>
                    <textarea type="text" style="text-align: center; background-color: rgba(255, 255, 255, .1);color:white ;" placeholder="Hesaplarınızı buraya giriniz." id="lista" class="md-textarea form-control" rows="4"></textarea>
                    <div class="mb-3 mt-3"><label class="form-label"></label>
                        <input type="hidden" id="wizort" data-status="0">
                        <button id="testar" onclick="enviar()" type="button" class="btn waves-effect waves-light btn-rounded btn-primary" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"><i class="fas fa-play"></i> Başlat</button>
                        <button id="stoper" onclick="wizort()" type="button" class="btn waves-effect waves-light btn-rounded btn-danger" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"><i class="fas fa-stop"></i> Durdur</button>
                        <button id="temizleButon" type="button" class="btn waves-effect waves-light btn-rounded btn-warning" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"><i class="fas fa-trash-alt"></i> Temizle</button>
                    </div>
                </div>
        </div>
        </center>
    </div>

    <div class="card-body" style="text-align: center;">
        <div class="alert alert-success" role="alert">AKTIF HESAP <span id="cCharge2"></span></h6>
        </div>
        <div id="bode1"><span id=".aprovadas" class="aprovadas"></span>
        </div>
        <div class="alert alert-danger" role="alert">KAPALI HESAP <span id="cDie2"></span></h6>
        </div>
        <div id="bode2"><span id=".reprovadas" class="reprovadas"></span>
        </div>
    </div>
</div>
</div>

<script>
    var audio = new Audio('admin/success.mp3');
    function wizort() {
        $("#wizort").data("status", "1");
    }

    function enviar() {
        $("#wizort").data("status", "0");
        var roleNumber = "<?= $k_rol ?>";
        if (parseInt(roleNumber) == 1 || parseInt(roleNumber) == 2) {
            var linha = $("#lista").val();
            var linhaenviar = linha.split("\n");
            var ap = 0;
            var rp = 0;
            var request = null;
            var requests = [];
            var rows = [];

            if (linhaenviar[0].length < 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Uyarı...',
                    text: 'Lütfen kontrol edilecek bir hesap listesi girin.',
                });
                return;
            }

            for (var i = 0; i <= linhaenviar.length; i++) {
                if (String(linhaenviar[i]).length > 0 && linhaenviar[i] != undefined && linhaenviar[i] != null) {
                    rows.push(linhaenviar[i]);
                }
            }

            console.log(rows)

            if (rows.length > 1000) {
                Swal.fire({
                    icon: 'error',
                    title: 'Uyarı...',
                    text: 'Tek seferde en fazla 10 hesap kontrol edilebilir! Lütfen sayfayı yenileyin.',
                });
                return;
            }

            rows.forEach(function(value, index) {
                if (value !== "") {
                    setTimeout(() => {
                        if (parseInt($("#wizort").data("status")) === 1) {
                            $.ajax().abort();
                            requests.map(x => {
                                x.abort();
                                x = null;
                            })
                            return;
                        } else {
                            request = $.ajax({
                                url: '../api/blutv/api.php',
                                data: {
                                    lista: value
                                },
                                type: 'POST',
                                async: true,
                                success: function(resultado) {
                                    if (resultado.indexOf("Aktif") != -1) {
                                        removelinha();
                                        audio.play();
                                        ap++;
                                        aprovadas(resultado + "");
                                    } else if (resultado.indexOf("Kapalı") != -1) {
                                        removelinha();
                                        rp++;
                                        reprovadas(resultado + "");
                                    }
                                }
                            });
                            requests.push(request);
                        }
                    }, 10000 * index)
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

    function aprovadas(str) {
        $(".aprovadas").append(str + "<br>");
    }

    function reprovadas(str) {
        $(".reprovadas").append(str + "<br>");
    }

    function edrovadas(str) {
        $(".edrovadas").append(str + "<br>");
    }

    function removelinha() {
        var lines = $("#lista").val().split('\n');
        lines.splice(0, 1);
        $("#lista").val(lines.join("\n"));
    }

    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>
<br>
<!--BİTİŞ-->
<?php
include('inc/footer_native.php');
include('inc/footer_main.php');
?>