<!-- Main content -->
<?php echo form_open('welcome/do_reset', 'id="form-reset" class="form-horizontal"') ?>
<div class="login-box" style="margin-top: 30px;">
    <div class="login-logo">
        <a href="#"><?php if (!empty($site_name)) {
                        echo $site_name;
                    } ?> </a>
    </div>
    <div class="card">
        <?php if ($exp) : ?>
            <div class="text-center card-body">
                <h3>Link Kadaluarsa</h3>
            </div>
        <?php else : ?>
            <div class="card-body">
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
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Ubah</button>
                    </div>
                </div>
            </div>
        <?php endif ?>
        </form>
    </div><!-- /.login-box -->
</div>

<script>
    $('#form-reset').submit(function() {
        SW.loading()
        $.ajax({
            url: "<?php echo site_url() . '/' . $url; ?>/do_reset",
            type: "POST",
            data: $('#form-reset').serialize(),
            cache: false,
            success: function(respon) {
                var obj = $.parseJSON(respon);
                if (obj.status == 1) {
                    Swal.fire({
                        title: 'Berhasil !',
                        text: obj.pesan,
                        icon: 'success'
                    }).then((res) => {
                        window.location.href = "<?php echo base_url() ?>"
                    })
                } else {
                    SW.toast({
                        title: obj.pesan,
                        icon: 'error'
                    })
                }
            }
        });
        return false;
    });
</script>