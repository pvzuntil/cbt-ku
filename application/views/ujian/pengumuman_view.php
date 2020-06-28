<div class="container">
    <?php if ($url != 'welcome') : ?>
        <!-- Content Header (Page header) -->
        <section class="content-header text-center">
            <h1>
                PENGUMUMAN JUARA KOMPETISI MATEMATIKA & SAINS ONLINE 2020
            </h1>
        </section>
    <?php endif ?>

    <!-- Main content -->
    <section class="content">
        <?php if ($pengumuman->isPublic == 0) : ?>
            <div class="callout callout-info">
                Belum ada pengumuman untuk saat ini, silahkan kembali dilain waktu !
            </div>
        <?php else : ?>
            <div class="box">
                <div class="box-body">
                    <div class="container">
                        <?= $pengumuman->isi ?>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </section><!-- /.content -->
</div><!-- /.container -->

<script type="text/javascript">
    let gchap, gchap2;
    var onloadCallback = function() {
        gchap =
            grecaptcha.render('gchap', {
                'sitekey': '6LfwH6YZAAAAAKJDW9B51NeACPfGXewFNtyFmlSR',
            });
        gchap2 =
            grecaptcha.render('gchap2', {
                'sitekey': '6LfwH6YZAAAAAKJDW9B51NeACPfGXewFNtyFmlSR',
            });
    };

    function showpassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    $(function() {
        $('#username').focus();

        $('#show-password').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        $('#show-password').on('ifChanged', function(event) {
            showpassword();
        });

        $('#form-login').submit(function() {
            if (grecaptcha.getResponse(gchap) == '' || grecaptcha.getResponse(gchap) == null) {
                Swal.fire({
                    toast: true,
                    timer: 2000,
                    showConfirmButton: false,
                    title: 'Captcha harus diisi.',
                    icon: 'warning'
                })
                return false;
            }
            $("#modal-proses").modal('show');
            $.ajax({
                url: "<?php echo site_url(); ?>/welcome/login",
                type: "POST",
                data: $('#form-login').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        window.open("<?php echo site_url(); ?>/tes_dashboard", "_self");
                    } else {
                        $('#form-pesan').html(pesan_err(obj.error));
                        $("#modal-proses").modal('hide');
                        $('#username').focus();
                    }
                }
            });

            return false;
        });
    });

    $('#btnModalTambah').on('click', function() {
        $('#modal-tambah').modal('show')
    })

    $('#form-tambah').submit(function() {
        if (grecaptcha.getResponse(gchap2) == '' || grecaptcha.getResponse(gchap2) == null) {
            Swal.fire({
                toast: true,
                timer: 2000,
                showConfirmButton: false,
                title: 'Captcha harus diisi.',
                icon: 'warning'
            })
            return false;
        }
        $("#modal-proses").modal('show');

        let check1 = $('#customCheck1').is(':checked')
        let check2 = $('#customCheck2').is(':checked')

        if (check1 && check2) {
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/tambah",
                type: "POST",
                data: $('#form-tambah').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        $("#modal-proses").modal('hide');
                        $("#modal-tambah").modal('hide');
                        notify_success(obj.pesan);
                    } else {
                        $("#modal-proses").modal('hide');
                        $('#form-pesan-tambah').html(pesan_err(obj.pesan));
                        $('#modal-tambah').animate({
                            scrollTop: 0
                        })
                    }
                }
            });
        } else {
            $("#modal-proses").modal('hide');
            Swal.fire({
                title: 'Uppss !',
                text: 'Anda belum mencentang semua persyaratan dan persetujuan.',
                icon: 'error'
            })
        }
        return false;
    });

    $('#form-lupa').submit(function() {
        $("#modal-proses").modal('show');
        $.ajax({
            url: "<?php echo site_url() . '/' . $url; ?>/request_lupa",
            type: "POST",
            data: $('#form-lupa').serialize(),
            cache: false,
            success: function(respon) {
                var obj = $.parseJSON(respon);
                if (obj.status == 1) {
                    $("#modal-proses").modal('hide');
                    $("#modal-lupa").modal('hide');
                    notify_success(obj.error);
                } else {
                    $("#modal-proses").modal('hide');
                    $('#form-pesan-lupa').html(pesan_err(obj.error));
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