<section class="content-header">
    <div class="container-fluid">
        <h1>
            Konfirmasi Tes
        </h1>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <?php echo form_open($url . '/mulai_tes', 'id="form-konfirmasi-tes"  class="form-horizontal"'); ?>
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">Konfirmasi Data Tes</h3>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div id="form-pesan"></div>
                <input type="hidden" name="tes-id" id="tes-id" value="<?php if (!empty($tes_id)) {
                                                                            echo $tes_id;
                                                                        } ?>">
                <table class="table table-striped">
                    <tr style="height: 45px;">
                        <td style="vertical-align: middle;"></td>
                        <td style="vertical-align: middle;text-align: right;">Nama Peserta : </td>
                        <td style="vertical-align: middle;"><b><?php if (!empty($nama)) {
                                                                    echo $nama;
                                                                } ?></b></td>
                        <td></td>
                    </tr>
                    <tr style="height: 45px;">
                        <td style="vertical-align: middle;"></td>
                        <td style="vertical-align: middle;text-align: right;">Tes : </td>
                        <td style="vertical-align: middle;"><b><?php if (!empty($tes_nama)) {
                                                                    echo $tes_nama;
                                                                } ?></b></td>
                        <td></td>
                    </tr>
                    <tr style="height: 45px;">
                        <td style="vertical-align: middle;"></td>
                        <td style="vertical-align: middle;text-align: right;">Waktu : </td>
                        <td style="vertical-align: middle;"><?php if (!empty($tes_waktu)) {
                                                                echo $tes_waktu;
                                                            } ?></td>
                        <td></td>
                    </tr>
                    <tr style="height: 45px;">
                        <td></td>
                        <td style="vertical-align: middle;text-align: right;">Poin Dasar : </td>
                        <td style="vertical-align: middle;"><?php if (!empty($tes_poin)) {
                                                                echo $tes_poin;
                                                            } ?></td>
                        <td></td>
                    </tr>
                    <tr style="height: 45px;">
                        <td></td>
                        <td style="vertical-align: middle;text-align: right;">Poin Maksimal : </td>
                        <td style="vertical-align: middle;"><?php if (!empty($tes_max_score)) {
                                                                echo $tes_max_score;
                                                            } ?></td>
                        <td></td>
                    </tr>
                    <?php if (!empty($tes_token)) {
                        echo $tes_token;
                    } ?>
                </table>
            </div><!-- /.card-body -->
            <div class="card-body d-flex" style="justify-content: center;">
                <button type="submit" id="btn-tambah-simpan" class="btn btn-primary pull-right">Kerjakan</button>
            </div>
        </div><!-- /.card -->
        </form>
    </div>
</section><!-- /.content -->

<script type="text/javascript">
    $(function() {
        $('#form-konfirmasi-tes').submit(function() {
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/mulai_tes",
                type: "POST",
                data: $('#form-konfirmasi-tes').serialize(),
                cache: false,
                timeout: 60000,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        window.open("<?php echo site_url(); ?>/tes_kerjakan/index/" + obj.tes_id, "_self");
                    } else if (obj.status == 2) {
                        window.open("<?php echo site_url() . '/' . $url; ?>/", "_self");
                    } else {
                        SW.toast({
                            title: obj.pesan,
                            icon: 'error'
                        })
                    }
                },
                statusCode: {
                    500: function(respon) {
                        SW.toast({
                            title: 'Terjadi kesalahan pada persiapan Tes. Silahkan hubungi petugas.',
                            icon: 'error'
                        });
                    }
                },
                error: function(xmlhttprequest, textstatus, message) {
                    if (textstatus === "timeout") {
                        SW.show({
                            text: "Gagal menyiapkan Tes, Halaman akan di Refresh !",
                            icon: 'error',
                            title: 'Gagal !'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        SW.show({
                            text: textstatus,
                            icon: 'error',
                            title: 'Gagal !'
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                }
            });
            return false;
        });
    });
</script>