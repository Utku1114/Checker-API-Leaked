<?php
include_once "../server/rolecontrol.php";

$customCSS = array();
$customJAVA = array();

function rig_geoulke($ip)
{
    $details = json_decode(file_get_contents("https://extreme-ip-lookup.com/json/{$ip}"));
    return $details->country;
}

$page_title = 'Checker';
include('inc/header_main.php');
include('inc/header_sidebar.php');
include('inc/header_native.php');
?>
<!--<div class="page-content">-->
<!--BAŞLANGIC-->
<div class="card-body">
    <div class="md-form">
        <div class="col-md-12">
            <center>
                <div class="md-form">
                    <h4 class="card-title mb-4"><i class="fas fa-credit-card"></i> Kronik CC Checker</h4>
                    <strong>Aktif Kartlarınızdan 1$ Provizyon Kesilmektedir.</strong>
                    </p>
                        <textarea type="text" id="lista" name="lista" style="text-align: center; background-color: rgba(255, 255, 255, .1);color:black ;" placeholder="Datayı bu alana giriniz..
Örnek: 4444555566667777|01|21|001" class="md-textarea form-control" rows="4"></textarea>
                        <div class="mb-3 mt-3"><label class="form-label"></label>
                            <button id="testar" onclick="enviar()" type="submit" class="btn waves-effect waves-light btn-rounded btn-primary" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"><i class="fas fa-play"></i> Başlat</button>
                            <button id="stoper" type="submit" class="btn waves-effect waves-light btn-rounded btn-danger" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"><i class="fas fa-stop"></i> Durdur</button>
                            <button id="temizleButon" type="submit" class="btn waves-effect waves-light btn-rounded btn-warning" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"><i class="fas fa-trash-alt"></i> Temizle</button>
                        </div>
                </div>
            </center>
        </div>

        <div class="card-body">
            <div class="alert alert-success" role="alert">AKTIF KARTLAR <span id="cCharge2"></span></h6>
            </div>
            <div id="bode1"><span id=".aprovadas" class="aprovadas"></span>
            </div>
            <div class="alert alert-danger" role="alert">KAPALI KARTLAR <span id="cDie2"></span></h6>
            </div>
            <div id="bode2"><span id=".reprovadas" class="reprovadas"></span>
            </div>
        </div>
    </div>
</div>

<script>
    function enviar() {
        var roleNumber = "<?= $k_rol ?>";
        if (parseInt(roleNumber) == 1 || parseInt(roleNumber) == 2) {
            var linha = $("#lista").val();
            var linhaenviar = linha.split("\n");
            var total = linhaenviar.length;
            var ap = 0;
            var rp = 0;
            var rCredits;
            linhaenviar.forEach(function(value, index) {
                setTimeout(
                    function() {
                        Array.prototype.randomElement = function() {
                            return this[Math.floor(Math.random() * this.length)]
                        }
                        $.ajax({
                            url: '../api/card/checkauto.php?lista=' + value,
                            async: true,
                            success: function(resultado) {
                                if (resultado.match("#Aktif")) {
                                    removelinha();
                                    ap++;
                                    aprovadas(resultado + "");
                                } else {
                                    removelinha();
                                    rp++;
                                    reprovadas(resultado + "");
                                }

                                $('#carregadas').html(total);

                                var fila = parseInt(ap) + parseInt(rp);
                                $('#cCharge2').html(ap);
                                $('#cDie2').html(rp);
                                $('#total').html(fila);
                                $('#cCharge2').html(ap);
                                $('#cDie2').html(rp);
                            }
                        });
                    }, 100 * index);
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
        $(".aprovadas").append(str);
    }

    function reprovadas(str) {
        $(".reprovadas").append(str);
    }

    function removelinha() {
        var lines = $("#lista").val().split('\n');
        lines.splice(0, 1);
        $("#lista").val(lines.join("\n"));
    }

    function iloveyou() {
        alert('PEKPEK')
    }
</script>
<!--BİTİŞ-->
<?php
include('inc/footer_native.php');
include('inc/footer_main.php');
?>