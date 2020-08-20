<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Tes
        </h1>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <?php echo form_open($url . '/tambah_tes', 'id="form-tambah-tes"  class="form-horizontal"'); ?>
                    <div class="card-header with-border">
                        <div class="card-title">Mengelola Tes</div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div id="form-pesan-tes"></div>
                                <div class="form-group">
                                    <label class="control-label">Nama</label>
                                    <input type="hidden" name="tambah-id" id="tambah-id" />
                                    <input type="hidden" name="tambah-nama-lama" id="tambah-nama-lama" />
                                    <input type="text" name="tambah-nama" id="tambah-nama" class="form-control input-sm" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Deskripsi</label>
                                    <textarea name="tambah-deskripsi" id="tambah-deskripsi" class="form-control input-sm"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Rentang Waktu</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-default">
                                                <i class="fas fa-clock"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="tambah-rentang-waktu" id="tambah-rentang-waktu" class="form-control input-sm" value="<?php if (!empty($rentang_waktu)) {
                                                                                                                                                            echo $rentang_waktu;
                                                                                                                                                        } ?>" readonly />
                                    </div>
                                    <small class="help-block text-muted">Rentang waktu tes dilaksanakan</small>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Group</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <select class="form-control input-sm" id="tambah-group" name="tambah-group[]">
                                                <?php if (!empty($select_group)) {
                                                    echo $select_group;
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <select class="form-control input-sm" id="tambah-lomba" name="tambah-lomba">
                                                <option value="matematika">Matematika</option>
                                                <option value="sains">Sains</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Waktu Tes</label>
                                    <input type="text" name="tambah-waktu" id="tambah-waktu" class="form-control input-sm" value="30" />
                                    <small class="help-block text-muted">Waktu tes dalam satuan menit</small>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Poin Dasar</label>
                                    <div>
                                        <input type="text" name="tambah-poin" id="tambah-poin" class="form-control input-sm" value="1.00" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Jawaban Salah</label>
                                    <div>
                                        <input type="text" name="tambah-poin-salah" id="tambah-poin-salah" class="form-control input-sm" value="0.00" />
                                        <small class="help-block text-muted">Poin untuk jawaban salah</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Jawaban Kosong</label>
                                    <div>
                                        <input type="text" name="tambah-poin-kosong" id="tambah-poin-kosong" class="form-control input-sm" value="0.00" />
                                        <small class="help-block text-muted">Poin untuk jawaban kosong</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="form-group col-12 col-md-4">
                                        <label class="control-label">Tunjukkan Hasil</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" aria-label="Checkbox for following text input" name="tambah-tunjukkan-hasil" id="tambah-tunjukkan-hasil" value="1" checked>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" aria-label="Text input with checkbox" value="Tunjukkan nilai tes" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="control-label">Detail Hasil</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" aria-label="Checkbox for following text input" name="tambah-detail-hasil" id="tambah-detail-hasil" value="1">
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" aria-label="Text input with checkbox" value="Tunjukkan detail hasil tes" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group col-12 col-md-4">
                                        <label class="control-label">Token</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" aria-label="Checkbox for following text input" name="tambah-token" id="tambah-token" value="1">
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" aria-label="Text input with checkbox" value="Membutuhkan token" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="btn-tambah-simpan" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row hide" id="kolom-soal">
            <div class="col-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Tambah Soal <div id="judul-tambah-soal"></div>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <?php echo form_open($url . '/tambah_soal', 'id="form-tambah-soal"  class="form-horizontal"'); ?>
                                <div id="form-pesan-soal"></div>
                                <div class="form-group">
                                    <label class="control-label">Modul</label>
                                    <div>
                                        <input type="hidden" name="soal-tes-id" id="soal-tes-id">
                                        <select class="form-control input-sm" id="soal-modul" name="soal-modul">
                                            <?php if (!empty($select_modul)) {
                                                echo $select_modul;
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Topik</label>
                                    <div>
                                        <select style="width: 100%" class="form-control input-sm" id="soal-topik" name="soal-topik">
                                            <div id="soal-topik-option">
                                                <option value="kosong">Pilih Topik</option>
                                            </div>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Tipe Soal</label>
                                    <div>
                                        <select class="form-control input-sm" id="soal-tipe" name="soal-tipe">
                                            <option value="0">Semua</option>
                                            <option value="1">Pilihan Ganda</option>
                                            <option value="2">Essay</option>
                                            <option value="3">Jawaban Singkat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Tingkat Kesulitan</label>
                                    <div>
                                        <select class="form-control input-sm" id="soal-kesulitan" name="soal-kesulitan">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Jml Soal</label>
                                    <div>
                                        <input type="text" name="soal-jml" id="soal-jml" class="form-control input-sm" value="2">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Jml Jawaban</label>
                                    <div>
                                        <input type="text" name="soal-jml-jawaban" id="soal-jml-jawaban" class="form-control input-sm" value="3">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12 col-md-6">
                                        <label class="control-label">Acak Soal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" aria-label="Checkbox for following text input" name="soal-acak-soal" id="soal-acak-soal" class="input-sm" value="1" checked>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" aria-label="Text input with checkbox" value="Acak soal tes" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label class="control-label">Acak Jawaban</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" aria-label="Checkbox for following text input" name="soal-acak-jawaban" id="soal-acak-jawaban" class="input-sm" value="1" checked>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" aria-label="Text input with checkbox" value="Acak jawaban" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group d-flex" style="justify-content: flex-end;">
                                    <button type="submit" id="btn-tambah-soal" class="btn btn-primary pull-right mt-3">Tambah Soal</button>
                                </div>
                                </form>
                            </div>
                            <div class="col-12">
                                <table id="table-soal" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Topik</th>
                                            <th>Detail</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row d-flex" style="justify-content: space-between;">
                            <button type="button" id="btn-tambah-daftar" class="btn btn-default">Daftar Tes</button>
                            <button type="button" id="btn-tambah-selesai" class="btn btn-primary pull-right">Selesai</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->



<script lang="javascript">
    function refresh_table() {
        $('#table-soal').dataTable().fnReloadAjax();
    }

    function refresh_topik() {
        SW.loading()
        var modul = $('#soal-modul').val();
        $.getJSON('<?php echo site_url() . '/' . $url; ?>/get_topik_by_modul/' + modul, function(data) {
            if (data.data == 1) {
                $('#soal-topik').html(data.select_topik);
            }
        });
    }

    function edit(id) {
        SW.loading()
        $.getJSON('<?php echo site_url() . '/' . $url; ?>/get_by_id/' + id + '', function(data) {
            if (data.data == 1) {
                $('#tambah-id').val(data.id);
                $('#soal-tes-id').val(data.id);

                $('#tambah-nama').val(data.nama);
                $('#tambah-nama-lama').val(data.nama);
                $('#tambah-deskripsi').val(data.deskripsi);
                $('#tambah-waktu').val(data.waktu);
                $('#tambah-poin').val(data.poin);
                $('#tambah-poin-kosong').val(data.poin_kosong);
                $('#tambah-poin-salah').val(data.poin_salah);
                $('#tambah-rentang-waktu').val(data.rentang_waktu);
                $('#tambah-lomba').val(data.lomba);
                if (data.tunjukkan_hasil == 1) {
                    $('#tambah-tunjukkan-hasil').prop("checked", true);
                } else {
                    $('#tambah-tunjukkan-hasil').prop("checked", false);
                }
                if (data.detail_hasil == 1) {
                    $('#tambah-detail-hasil').prop("checked", true);
                } else {
                    $('#tambah-detail-hasil').prop("checked", false);
                }
                if (data.token == 1) {
                    $('#tambah-token').prop("checked", true);
                } else {
                    $('#tambah-token').prop("checked", false);
                }

                refresh_topik();
                refresh_table();
                SW.close()

                $('#kolom-soal').removeClass('hide');
            }
        });
    }

    function hapus_soal(id) {
        SW.loading()
        $.getJSON('<?php echo site_url() . '/' . $url; ?>/hapus_soal_by_id/' + id + '', function(data) {
            if (data.data == 1) {
                SW.toast({
                    title: data.pesan,
                    icon: 'success'
                })

                refresh_table();
            } else {
                SW.toast({
                    title: data.pesan,
                    icon: 'error'
                })
            }
        });
    }

    function selesai() {
        $('#tambah-id').val('');
        $('#tambah-nama').val('');
        $('#tambah-nama-lama').val('');
        $('#tambah-deskripsi').val('');
        $('#tambah-waktu').val('30');
        $('#tambah-poin').val('1.00');
        $('#tambah-poin-kosong').val('0.00');
        $('#tambah-poin-salah').val('0.00');
        $('#tambah-rentang-waktu').val(`<?php if (!empty($rentang_waktu)) {
                                            echo $rentang_waktu;
                                        } ?>`);
        $('#tambah-group option:selected').removeAttr('selected');
        $('#tambah-acak-jawaban').prop("checked", true);

        $('#soal-tes-id').val('');

        $('#kolom-soal').addClass('hide');
        $('#tambah-nama'), focus();
    }

    $(function() {
        $('#tambah-rentang-waktu').daterangepicker({
            timePicker: true,
            timePickerIncrement: 10,
            format: 'YYYY-MM-DD H:mm'
        });
        $('#btn-tambah-selesai').click(function() {
            window.open("<?php echo site_url(); ?>/manager/tes_tambah", "_self");
        });

        $('#btn-tambah-daftar').click(function() {
            window.open("<?php echo site_url(); ?>/manager/tes_daftar", "_self");
        });

        $("#soal-modul").change(function() {
            refresh_topik();
        });

        $('#form-tambah-tes').submit(function() {
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/tambah_tes",
                type: "POST",
                data: $('#form-tambah-tes').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        $('#form-pesan-tes').html('');
                        $("#tambah-id").val(obj.tes_id);
                        $("#tambah-nama-lama").val(obj.tes_nama);
                        // menampilkan tambah soal
                        refresh_topik()
                        $("#soal-tes-id").val(obj.tes_id);
                        let kolomSoal = $('#kolom-soal')
                        kolomSoal.removeClass('hide');
                        let kolomSoalPos = kolomSoal.position().top

                        $('html').animate({
                            scrollTop: kolomSoalPos
                        }, 500)

                        SW.toast({
                            title: obj.pesan,
                            icon: 'success'
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

        $('#form-tambah-soal').submit(function() {
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/tambah_soal",
                type: "POST",
                data: $('#form-tambah-soal').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        $('#form-pesan-soal').html('');
                        refresh_table();
                        SW.toast({
                            title: obj.pesan,
                            icon: 'success'
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

        $('#table-soal').DataTable({
            "paging": false,
            "iDisplayLength": 10,
            "bProcessing": false,
            "bServerSide": true,
            "searching": false,
            "aoColumns": [{
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "20px"
                },
                {
                    "bSearchable": false,
                    "bSortable": false
                },
                {
                    "bSearchable": false,
                    "bSortable": false
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "30px"
                }
            ],
            "sAjaxSource": "<?php echo site_url() . '/' . $url; ?>/get_datatable_soal/",
            "autoWidth": false,
            "fnServerParams": function(aoData) {
                aoData.push({
                    "name": "tes-id",
                    "value": $('#soal-tes-id').val()
                });
            },
            'fnDrawCallback': function(oSettings) {
                NP.d()
                callBackDatatable(oSettings)
            },
            fnPreDrawCallback: function() {
                NP.s()
            }
        });

        <?php if (!empty($data_tes)) {
            echo $data_tes;
        } ?>
    });
</script>