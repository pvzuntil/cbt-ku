<div class="container">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Selamat Datang
            <small class="text-muted"> di Halaman Login Administrator <?php if (!empty($site_name)) {
                                                                            echo $site_name;
                                                                        } ?></small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- <div class="callout callout-info">
            <h4>Informasi</h4>
            <p>
                Selamat datang di Halaman Login Aplikasi Computer Based-Test. Untuk memulai silahkan melakukan
                proses Login dengan menggunakan username dan password yang sudah dimiliki.
            </p>
        </div> -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Horizontal Form -->
                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title">Login Operator</h3>
                        </div><!-- /.card-header -->
                        <!-- form start -->
                        <?php echo form_open('welcome/login', 'id="form-login" class="form-horizontal"') ?>
                        <div class="card-body">
                            <div id="form-pesan">
                            </div>

                            <div class="form-group">
                                <label class="control-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                            </div>
                            <div class="row">
                                <div class="col-12" style="margin-bottom: 10px; display: flex; justify-content: flex-start;">
                                    <div id="gchap"></div>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" id="btn-login" class="btn btn-info pull-right">Login</button>
                        </div><!-- /.card-footer -->
                        </form>
                    </div><!-- /.card -->
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div>
<script type="text/javascript">
    let gchap;
    var onloadCallback = function() {
        gchap =
            grecaptcha.render('gchap', {
                'sitekey': '6LfwH6YZAAAAAKJDW9B51NeACPfGXewFNtyFmlSR',
            });
    };
    $(function() {

        $('#username').focus();

        $('#btn-login').click(function() {
            $('#form-login').submit();
        });

        $('#form-login').submit(function() {
            if (grecaptcha.getResponse(gchap) == '' || grecaptcha.getResponse(gchap) == null) {
                SW.toast({
                    title: 'Captcha harus diisi.',
                    icon: 'warning'
                })
                return false;
            }
            SW.loading()
            $.ajax({
                url: "<?php echo site_url(); ?>/manager/welcome/login",
                type: "POST",
                data: $('#form-login').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        window.open("<?php echo site_url(); ?>/manager/dashboard", "_self");
                    } else {
                        SW.toast({
                            title: obj.error,
                            icon: 'error'
                        })
                    }
                }
            });

            return false;
        });
    });
</script>