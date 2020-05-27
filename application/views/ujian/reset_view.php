<div class="container">
    <?php if ($url != 'welcome') : ?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php if (!empty($site_name)) {
                    echo $site_name;
                } ?>
                <small>Ujian Online Berbasis Komputer</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Selamat Datang</li>
            </ol>
        </section>
    <?php endif ?>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php echo form_open('welcome/do_reset', 'id="form-reset" class="form-horizontal"') ?>
        </div>
        <div class="row">
            <div class="login-box">
                <div class="login-box-body shadow-box">
                    <div class="login-logo">
                        <b>Reset Password</b>
                    </div><!-- /.login-logo -->
                    <p class="login-box-msg">Masukkan Password Baru</p>
                    <?php if ($this->session->flashdata('verif')) : ?>
                        <div class="alert alert-info">
                            <?= $this->session->flashdata('verif'); ?>
                        </div>
                    <?php endif ?>
                    <div id="form-pesan"></div>
                    <div class="form-group has-feedback">
                        <label>Email</label>
                        <input id="username" autocomplete="off" name="email" class="form-control" placeholder="Email" type="email" readonly value="<?= $email ?>" />
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label>Password baru</label>
                        <input type="password" id="password" autocomplete="off" name="password" class="form-control" placeholder="Masukkan password baru anda" />
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <label>Konfirmasi password</label>
                        <input type="password" id="password-konfirmasi" autocomplete="off" name="password-konfirmasi" class="form-control" placeholder="Ketik ulang password baru anda" />
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12" style="margin-bottom: 10px">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Ubah</button>

                        </div><!-- /.col -->
                    </div>
                </div><!-- /.login-box -->
            </div>
            </form>
    </section><!-- /.content -->
</div><!-- /.container -->

<script>
    $('#form-reset').submit(function() {
        $("#modal-proses").modal('show');
        $.ajax({
            url: "<?php echo site_url() . '/' . $url; ?>/do_reset",
            type: "POST",
            data: $('#form-reset').serialize(),
            cache: false,
            success: function(respon) {
                var obj = $.parseJSON(respon);
                if (obj.status == 1) {
                    $("#modal-proses").modal('hide');
                    Swal.fire({
                        title: 'Berhasil !',
                        text: obj.pesan,
                        icon: 'success'
                    }).then((res) => {
                        if (res.value) {
                            window.location.href = "<?php echo base_url() ?>"
                        }
                    })
                } else {
                    $("#modal-proses").modal('hide');
                    $('#form-pesan').html(pesan_err(obj.pesan));
                }
            }
        });
        return false;
    });

    function notify_success(pesan) {
        new PNotify({
            title: 'Berhasil',
            text: pesan,
            type: 'success',
            history: false,
            delay: 4000,
        });
    }
</script>