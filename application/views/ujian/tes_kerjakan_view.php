<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <h1>
                    Tes : <?php if (!empty($tes_name)) {
                                echo $tes_name;
                            } ?>
                </h1>
            </div>
            <div class="col-6 d-flex" style="justify-content: flex-end;">
                <div class="breadcrumb">
                    <img src="<?php echo base_url(); ?>public/images/zoom.png" style="cursor: pointer;" height="20" onclick="zoomnormal()" title="Klik ukuran font normal" />&nbsp;&nbsp;
                    <img src="<?php echo base_url(); ?>public/images/zoom.png" style="cursor: pointer;" height="26" onclick="zoombesar()" title="Klik ukuran font lebih besar" />
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <?php echo form_open('tes_kerjakan/simpan_jawaban', 'id="form-kerjakan" style="width: 100%"') ?>
            <input type="hidden" name="tes-id" id="tes-id" value="<?php if (!empty($tes_id)) {
                                                                        echo $tes_id;
                                                                    } ?>">
            <input type="hidden" name="tes-user-id" id="tes-user-id" value="<?php if (!empty($tes_user_id)) {
                                                                                echo $tes_user_id;
                                                                            } ?>">
            <input type="hidden" name="tes-soal-id" id="tes-soal-id" value="<?php if (!empty($tes_soal_id)) {
                                                                                echo $tes_soal_id;
                                                                            } ?>">
            <input type="hidden" name="tes-soal-nomor" id="tes-soal-nomor" value="<?php if (!empty($tes_soal_nomor)) {
                                                                                        echo $tes_soal_nomor;
                                                                                    } ?>">
            <input type="hidden" name="tes-soal-jml" id="tes-soal-jml" value="<?php if (!empty($tes_soal_jml)) {
                                                                                    echo $tes_soal_jml;
                                                                                } ?>">
            <input type="hidden" name="tes-soal-ragu" id="tes-soal-ragu" value="<?php if (!empty($tes_ragu)) {
                                                                                    echo $tes_ragu;
                                                                                } ?>">
            <div class="col-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title">Soal <span id="judul-soal"><?php if (!empty($tes_soal_nomor)) {
                                                                                echo 'ke ' . $tes_soal_nomor;
                                                                            } ?></span></h3>
                        <div class="card-tools pull-right">
                            <div class="pull-right">
                                <div id="sisa-waktu" class="blink_text"></div>
                            </div>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div id="isi-tes-soal" style="font-size: 15px;">
                            <?php if (!empty($tes_soal)) {
                                echo $tes_soal;
                            } ?>
                        </div>
                    </div><!-- /.card-body -->
                    <div class="card-footer">
                        <button type="button" class="btn btn-default hide" id="btn-sebelumnya">Soal Sebelumnya</button>&nbsp;&nbsp;&nbsp;
                        <div class="btn btn-warning" id="btn-ragu" onclick="ragu()">
                            <input type="checkbox" style="width:10px;height:10px;" name="btn-ragu-checkbox" id="btn-ragu-checkbox" <?php if (!empty($tes_ragu)) {
                                                                                                                                        echo "checked";
                                                                                                                                    } ?> /> Ragu-ragu
                        </div>&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-default" id="btn-selanjutnya">Soal Selanjutnya</button>
                    </div>
                </div><!-- /.card -->
            </div>
            <?= form_close() ?>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Soal</h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <?php if (!empty($tes_daftar_soal)) {
                            echo $tes_daftar_soal;
                        } ?>
                        <p class="help-block">Soal yang sudah dijawab akan berwarna Biru.</p>
                    </div><!-- /.card-body -->
                    <div class="card-footer d-flex" style="justify-content: flex-end;">
                        <button class="btn btn-danger" id="btn-hentikan">Selesai mengerjakan</button>
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
    </div>
</section><!-- /.content -->

<div class="modal fade" style="max-height: 100%;overflow-y: auto;" id="modal-hentikan" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url . '/hentikan_tes', 'id="form-hentikan"'); ?>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Konfirmasi Selesai mengerjakan</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="form-pesan"></div>
                <div class="callout callout-info">
                    <p>Apakah anda yakin selesai mengerjakan ?
                        <br />Jawaban yang sudah selesai tidak dapat diubah.
                    </p>

                </div>
                <div class="form-group">
                    <label>Nama Tes</label>
                    <input type="hidden" name="hentikan-tes-id" id="hentikan-tes-id">
                    <input type="hidden" name="hentikan-tes-user-id" id="hentikan-tes-user-id">
                    <input type="text" class="form-control" id="hentikan-tes-nama" name="hentikan-tes-nama" readonly>
                </div>

                <div class="form-group">
                    <label>Keterangan Soal</label>
                    <input type="text" class="form-control" id="hentikan-dijawab" name="hentikan-dijawab" readonly>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="hentikan-centang" name="hentikan-centang" value="1"> Centang dan klik tombol Selesai mengerjakan.
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row d-flex" style="justify-content: space-between;">
                    <button type="submit" id="tambah-simpan" class="btn btn-primary">Selesai mengerjakan</button>
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>

    </form>
</div>

<script type="text/javascript">
    function zoombesar() {
        $('#isi-tes-soal').css("font-size", "140%");
        $('#isi-tes-soal').css("line-height", "140%");
    }

    function zoomnormal() {
        $('#isi-tes-soal').css("font-size", "15px");
        $('#isi-tes-soal').css("line-height", "110%");
    }

    function ragu() {
        NP.s()

        $.ajax({
            url: '<?php echo site_url() . '/' . $url; ?>/get_tes_soal_by_tessoal/' + $('#tes-soal-id').val(),
            type: "POST",
            cache: false,
            timeout: 10000,
            success: function(respon) {
                var data = $.parseJSON(respon);
                if (data.data == 1) {
                    // Mengubah nilai ragu-ragu di database
                    if ($('#tes-soal-ragu').val() == 0) {
                        var ragu = 1;
                    } else {
                        var ragu = 0;
                    }
                    $.ajax({
                        url: '<?php echo site_url() . '/' . $url; ?>/update_tes_soal_ragu/' + $('#tes-soal-id').val() + '/' + ragu,
                        type: "POST",
                        cache: false,
                        timeout: 5000,
                        success: function(respon) {
                            var data = $.parseJSON(respon);
                            if (data.data == 1) {
                                SW.toast({
                                    title: 'Jawaban Ragu-ragu berhasil diubah',
                                    icon: 'success'
                                });
                            }
                        },
                        error: function(xmlhttprequest, textstatus, message) {
                            if (textstatus === "timeout") {
                                NP.d()
                                SW.toast({
                                    title: "Gagal mengubah Soal, Silahkan Refresh Halaman",
                                    icon: 'error'
                                });
                            } else {
                                NP.d()
                                SW.toast({
                                    title: textstatus,
                                    icon: 'error'
                                });
                            }
                        }
                    });

                    // Mengubah warna daftar soal dan checkbox pada tombol ragu-ragu
                    if (data.tessoal_dikerjakan == 1) {
                        if ($('#tes-soal-ragu').val() == 0) {
                            // Membuat menjadi ragu-ragu
                            $('#btn-soal-' + $('#tes-soal-nomor').val()).removeClass('btn-primary');
                            $('#btn-soal-' + $('#tes-soal-nomor').val()).addClass('btn-warning');
                            $('#btn-ragu-checkbox').prop("checked", true);
                            $('#tes-soal-ragu').val(1);
                        } else {
                            $('#btn-soal-' + $('#tes-soal-nomor').val()).removeClass('btn-warning');
                            $('#btn-soal-' + $('#tes-soal-nomor').val()).addClass('btn-primary');
                            $('#btn-ragu-checkbox').prop("checked", false);
                            $('#tes-soal-ragu').val(0);
                        }
                    } else {
                        if ($('#tes-soal-ragu').val() == 0) {
                            // Membuat menjadi ragu-ragu
                            $('#btn-soal-' + $('#tes-soal-nomor').val()).removeClass('btn-default');
                            $('#btn-soal-' + $('#tes-soal-nomor').val()).addClass('btn-warning');
                            $('#btn-ragu-checkbox').prop("checked", true);
                            $('#tes-soal-ragu').val(1);
                        } else {
                            $('#btn-soal-' + $('#tes-soal-nomor').val()).removeClass('btn-warning');
                            $('#btn-soal-' + $('#tes-soal-nomor').val()).addClass('btn-default');
                            $('#btn-ragu-checkbox').prop("checked", false);
                            $('#tes-soal-ragu').val(0);
                        }
                    }
                }
                NP.d()
            },
            error: function(xmlhttprequest, textstatus, message) {
                if (textstatus === "timeout") {
                    NP.d()
                    SW.toast({
                        title: "Gagal mengubah soal, Silahkan Refresh Halaman",
                        icon: 'error'
                    });
                } else {
                    NP.d()
                    SW.toast({
                        title: textstatus,
                        icon: 'error'
                    });
                }
            }
        });
    }

    function soal(tessoal_id) {
        NP.s()
        $.ajax({
            url: '<?php echo site_url() . '/' . $url; ?>/get_soal_by_tessoal/' + tessoal_id + '/' + $('#tes-user-id').val(),
            type: "POST",
            cache: false,
            timeout: 10000,
            success: function(respon) {
                var data = $.parseJSON(respon);
                if (data.data == 1) {
                    $('#tes-soal-id').val(data.tes_soal_id);
                    $('#tes-soal-nomor').val(data.tes_soal_nomor);
                    $('#isi-tes-soal').html(data.tes_soal);
                    $('#tes-soal-ragu').val(data.tes_ragu);
                    $('#judul-soal').html('ke ' + data.tes_soal_nomor);

                    if (data.tes_ragu == 0) {
                        // Menghilangkan checkbox ragu-ragu
                        $('#btn-ragu-checkbox').prop("checked", false);
                    } else {
                        // Menambah checkbox ragu-ragu
                        $('#btn-ragu-checkbox').prop("checked", true);
                    }

                    // menghilangkan tombol sebelum jika soal di nomor1
                    // dan menghilangkan tombol selanjutnya jika disoal terakhir
                    var tes_soal_nomor = parseInt($('#tes-soal-nomor').val());
                    var tes_soal_jml = parseInt($('#tes-soal-jml').val());
                    var tes_soal_tujuan = data.tes_soal_nomor;
                    if (tes_soal_tujuan == 1) {
                        $('#btn-sebelumnya').addClass('hide');
                        $('#btn-selanjutnya').removeClass('hide');
                    } else if (tes_soal_tujuan == tes_soal_jml) {
                        $('#btn-sebelumnya').removeClass('hide');
                        $('#btn-selanjutnya').addClass('hide');
                    } else {
                        $('#btn-sebelumnya').removeClass('hide');
                        $('#btn-selanjutnya').removeClass('hide');
                    }

                } else if (data.data == 2) {
                    window.location.reload();
                }
                NP.d()
            },
            error: function(xmlhttprequest, textstatus, message) {
                if (textstatus === "timeout") {
                    NP.d()
                    SW.toast({
                        title: "Gagal mengambil Soal, Silahkan Refresh Halaman",
                        icon: 'error'
                    });
                } else {
                    NP.d()
                    SW.toast({
                        title: textstatus,
                        icon: 'error'
                    });
                }
            }
        });
    }

    function audio(status) {
        var audio_player_status = $('#audio-player-status').val();
        var audio_player_update = $('#audio-player-update').val();
        if (status == 1) {
            if (audio_player_update == 0) {
                $('#audio-player-update').val('1');
                /**
                 * Update status audio jika pemutaran audio dibatasi
                 */
                $.getJSON('<?php echo site_url() . '/' . $url; ?>/update_status_audio/' + $('#tes-soal-id').val(), function(data) {
                    if (data.data == 1) {
                        SW.toast({
                            title: data.pesan,
                            icon: 'success'
                        });
                    }
                });
            }
        }

        if (audio_player_status == 0) {
            $('#audio-player-status').val('1');
            $('#audio-player').trigger('play');
            $('#audio-player-judul').html('Pause');
            $('#audio-player-judul-logo').removeClass('fa-play');
            $('#audio-player-judul-logo').addClass('fa-pause');
        } else {
            $('#audio-player-status').val('0');
            $('#audio-player').trigger('pause');
            $('#audio-player-judul').html('Play');
            $('#audio-player-judul-logo').removeClass('fa-pause');
            $('#audio-player-judul-logo').addClass('fa-play');
        }
    }

    function audio_ended(status) {
        if (status == 1) {
            $('#audio-control').addClass('hide');
        } else {
            $('#audio-player-status').val('0');
            $('#audio-player-judul').html('Play');
            $('#audio-player-judul-logo').removeClass('fa-pause');
            $('#audio-player-judul-logo').addClass('fa-play');
        }
    }

    function jawab() {
        $('#form-kerjakan').submit();
    }

    function hentikan_tes() {
        NP.s()
        $('#hentikan-centang').prop("checked", false);
        $.getJSON('<?php echo site_url() . '/' . $url; ?>/get_tes_info/' + $('#tes-id').val(), function(data) {
            if (data.data == 1) {
                $('#hentikan-tes-id').val(data.tes_id);
                $('#hentikan-tes-user-id').val(data.tes_user_id);
                $('#hentikan-tes-nama').val(data.tes_nama);
                $('#hentikan-dijawab').val(data.tes_dijawab + " dijawab. " + data.tes_blum_dijawab + " belum dijawab.");
                $('#hentikan-belum-dijawab').val(data.tes_blum_dijawab);


                $("#modal-hentikan").modal('show');
            } else {
                window.location.reload();
            }
            NP.d()
        });
    }

    function soal_navigasi(navigasi) {
        var tes_soal_nomor = parseInt($('#tes-soal-nomor').val());
        var tes_soal_jml = parseInt($('#tes-soal-jml').val());
        var tes_soal_tujuan = tes_soal_nomor + navigasi;

        if ((tes_soal_tujuan >= 1 && tes_soal_tujuan <= tes_soal_jml)) {
            $('#btn-soal-' + tes_soal_tujuan).trigger('click');
        }
    }

    $(function() {
        var sisa_detik = <?php if (!empty($detik_sisa)) {
                                echo $detik_sisa;
                            } ?>;
        setInterval(function() {
            var sisa_menit = Math.round(sisa_detik / 60);
            sisa_detik = sisa_detik - 1;
            $("#sisa-waktu").html("Sisa Waktu : " + sisa_menit + " menit");

            if (sisa_detik < 1) {
                window.location.reload();
            }
        }, 1000);

        $('#btn-sebelumnya').click(function() {
            soal_navigasi(-1);
        });

        $('#btn-selanjutnya').click(function() {
            soal_navigasi(1);
        });

        $('#btn-hentikan').click(function() {
            hentikan_tes();
        });
        /**
         * Submit form soal saat sudah menjawab
         */
        $('#form-kerjakan').submit(function() {
            NP.s()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/simpan_jawaban",
                type: "POST",
                data: $('#form-kerjakan').serialize(),
                cache: false,
                timeout: 10000,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        NP.d()
                        SW.toast({
                            title: obj.pesan,
                            icon: 'success'
                        });
                        $('#btn-soal-' + obj.nomor_soal).removeClass('btn-default');
                        $('#btn-soal-' + obj.nomor_soal).removeClass('btn-warning');
                        $('#btn-soal-' + obj.nomor_soal).addClass('btn-primary');
                    } else if (obj.status == 2) {
                        window.location.reload();
                    } else {
                        NP.d()
                        SW.toast({
                            title: obj.pesan,
                            icon: 'error'
                        });
                    }
                },
                error: function(xmlhttprequest, textstatus, message) {
                    if (textstatus === "timeout") {
                        NP.d()
                        SW.toast({
                            title: "Gagal menyimpan jawaban, Silahkan Refresh Halaman",
                            icon: 'error'
                        });
                    } else {
                        NP.d()
                        SW.toast({
                            title: textstatus,
                            icon: 'error'
                        });
                    }
                }
            });
            return false;
        });

        /**
         * Submit form hentikan tes
         */
        $('#form-hentikan').submit(function() {
            NP.s()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/hentikan_tes",
                type: "POST",
                data: $('#form-hentikan').serialize(),
                cache: false,
                timeout: 10000,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        window.location.reload();
                    } else {
                        NP.d()
                        SW.toast({
                            title: obj.pesan,
                            icon: 'error'
                        });
                    }
                },
                error: function(xmlhttprequest, textstatus, message) {
                    if (textstatus === "timeout") {
                        NP.d()
                        SW.toast({
                            title: "Gagal menghentikan Tes, Silahkan Refresh Halaman",
                            icon: 'error'
                        });
                    } else {
                        NP.d()
                        SW.toast({
                            title: textstatus,
                            icon: 'error'
                        });
                    }
                }
            });
            return false;
        });

        $(document).ready(function() {

        });
    });
</script>