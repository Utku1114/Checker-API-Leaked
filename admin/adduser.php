<?php
$customCSS = array();
$customJAVA = array();

require '../server/baglan.php';
require '../server/admincontrol.php';

$page_title = 'Kullanıcı Ekle';

include('inc/header_main.php');
include('inc/header_sidebar.php');
include('inc/header_native.php');

date_default_timezone_set('Europe/Istanbul');

?>
<div class="row">
    <div class="col-xl-12 col-md-6">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Kullanıcı Ekle</h4>
                    <div class="block-content tab-content">
                        <div class="tab-pane active" role="tabpanel">
                            <center>
                                <input class="form-control" type="text" name="username" id="username" placeholder="Oluşturulacak anahtar için bir kullanıcı adı belirleyin"><br>
                                <div class="result">
                                </div>
                                <button onclick="addKey()" class="btn waves-effect waves-light btn-rounded btn-primary" style="width: 100px; height: 36px; outline: none;"><i class="fas fa-plus"></i>&nbsp;Ekle</button>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function addKey() {
            var username = $('#username').val();
            if (username == '') {
                alert('Lütfen bir kullanıcı adı belirleyin.');
            } else {
                $.ajax({
                    url: '/admin/func/adduser.php',
                    type: 'POST',
                    data: {
                        username: username
                    },
                    success: function(data) {
                        data = JSON.parse(data);
                        $('#username').val('');
                        if (data.success == true) {
                            $('.result').html('<div class="alert alert-success" role="alert"><strong>Başarılı!</strong> Anahtar oluşturuldu: ' + data.key + ' / Kullanıcı Adı: ' + data.username + '</div>');
                        } else {
                            $('.result').html('<div class="alert alert-danger" role="alert"><strong>Başarısız!</strong> Anahtar oluşturulamadı.</div>');
                        }
                    }
                });
            }
        }
    </script>
</div>
<?php
include('inc/footer_native.php');
include('inc/footer_main.php');
?>