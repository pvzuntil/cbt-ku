<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Hasil Tes
        </h1>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Filter Hasil</div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Tes</label>
                                    <input type="hidden" name="check" id="check" value="0">
                                    <select name="pilih-tes" id="pilih-tes" class="form-control input-sm">
                                        <?php if (!empty($select_tes)) {
                                            echo $select_tes;
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Status Peserta</label>
                                    <select name="pilih-status" id="pilih-status" class="form-control input-sm">
                                        <option value="mengerjakan">Peserta Mengerjakan Tes</option>
                                        <option value="tidak">Peserta Belum Mengerjakan Tes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Urutkan</label>
                                    <select name="pilih-urutkan" id="pilih-urutkan" class="form-control input-sm">
                                        <option value="tertinggi">Nilai Tertinggi</option>
                                        <option value="terendah">Nilai Terendah</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex" style="justify-content: flex-end;">
                        <button type="button" id="btn-pilih" class="btn btn-primary"><span>Cari</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php echo form_open($url . '/edit_tes', 'id="form-edit"'); ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Daftar Hasil Tes</div>
                        <div class="card-tools pull-right">
                            <div class="dropdown pull-right">
                                <a style="cursor: pointer;" onclick="export_excel()" class="btn btn-sm btn-default">Export ke Excel</a>
                            </div>
                        </div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <input type="hidden" name="edit-pilihan" id="edit-pilihan">
                        <table id="table-hasil" class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="all">No.</th>
                                    <th>Waktu Mulai</th>
                                    <th>Waktu Selesai (Lama mengerjakan)</th>
                                    <th>Waktu</th>
                                    <th>Nama Tes</th>
                                    <th>Group</th>
                                    <th class="all">Nama User</th>
                                    <th>Poin</th>
                                    <th>Status</th>
                                    <th class="all"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row d-flex" style="justify-content: space-between;">
                            <div>
                                <button type="button" id="btn-edit-hapus" title="Hapus Hasil" class="btn btn-danger">Hapus</button>
                                <button type="button" id="btn-edit-hentikan" class="btn btn-warning">Hentikan</button>
                                <button type="button" id="btn-edit-buka-tes" class="btn btn-success">Buka Tes</button>
                                <button type="button" id="btn-edit-waktu" class="btn btn-success">Tambah Waktu</button>
                            </div>
                            <div>
                                <button type="button" id="btn-edit-pilih" title="Pilih Hasil Tes" class="btn btn-default pull-right">Pilih Semua</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->

<div class="modal fade" id="modal-waktu" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Tambah Waktu</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="form-pesan-waktu"></div>
                <div class="form-group">
                    <label>Jumlah Waktu</label>
                    <input type="text" class="form-control" id="waktu-menit" name="waktu-menit" value="10">
                    <small class="text-muted">Waktu dalam satuan MENIT</small>
                </div>
                <p class="">Menambah Waktu Tes melalui Penambahan "Waktu Mulai" pada user tes yang sudah dicentang sebelumnya.</p>
                <p class="">Waktu Mulai pengerjaan Tes hasil penambahan tidak boleh melebihi waktu saat ini.</p>
            </div>
            <div class="modal-footer d-flex" style="justify-content: space-between;">
                <button type="button" id="btn-edit-waktu-simpan" class="btn btn-primary">Simpan</button>
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

</form>
</div>
</div>



<script lang="javascript">
    function refresh_table() {
        // TODO promise ini
        return $('#table-hasil').dataTable().fnReloadAjax();
    }

    function detail_tes(tesuser_id) {
        window.open("<?php echo site_url() . '/manager/tes_hasil_detail'; ?>/index/" + tesuser_id);
    }

    function export_excel() {
        var tes = $('#pilih-tes').val();
        var group = $('#pilih-group').val();
        var waktu = $('#pilih-rentang-waktu').val();
        var urutkan = $('#pilih-urutkan').val();
        var status = $('#pilih-status').val();
        var keterangan = $('#pilih-keterangan').val();

        window.open("<?php echo site_url() . '/' . $url; ?>/export/" + tes + "/" + group + "/" + waktu + "/" + urutkan + "/" + status + "/" + keterangan, "_self");
    }

    $(function() {
        $('#pilih-rentang-waktu').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            format: 'YYYY-MM-DD H:mm'
        });

        $("#pilih-status").change(function() {
            if ($('#pilih-status').val() == 'mengerjakan') {
                $('#info-waktu').html('Rentang waktu peserta saat memulai Tes');
            } else {
                $('#info-waktu').html('Rentang waktu Tes dilaksanakan sesuai di Daftar Tes');
            }
        });

        $('#btn-pilih').click(function() {
            $('#check').val('0');
            refresh_table();
        });

        $('#btn-edit-hapus').click(function() {
            $('#edit-pilihan').val('hapus');
            $('#form-edit').submit();
        });

        $('#btn-edit-hentikan').click(function() {
            $('#edit-pilihan').val('hentikan');
            $('#form-edit').submit();
        });

        $('#btn-edit-buka-tes').click(function() {
            $('#edit-pilihan').val('buka');
            $('#form-edit').submit();
        });

        $('#btn-edit-waktu').click(function() {
            $('#edit-pilihan').val('waktu');
            $('#waktu-menit').val('10');
            $("#modal-waktu").modal('show');
        });

        $('#btn-edit-waktu-simpan').click(function() {
            $('#form-edit').submit();
        });

        $('#btn-edit-pilih').click(function(event) {
            if ($('#check').val() == 0) {
                $(':checkbox').each(function() {
                    this.checked = true;
                });
                $('#check').val('1');
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
                $('#check').val('0');
            }
        });

        $('#form-edit').submit(function() {
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/edit_tes",
                type: "POST",
                data: $('#form-edit').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        refresh_table();
                        $("#modal-waktu").modal('hide');
                        SW.toast({
                            title: obj.pesan,
                            icon: 'success'
                        });
                    } else {
                        SW.toast({
                            title: obj.pesan,
                            icon: 'error'
                        });
                    }
                }
            });
            return false;
        });

        $('#table-hasil').DataTable({
            "paging": true,
            "iDisplayLength": 50,
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
                    "bSortable": false,
                    "sWidth": "200px"
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
                    "bSortable": false
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
                    "sWidth": "60px"
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "20px"
                }
            ],
            "sAjaxSource": "<?php echo site_url() . '/' . $url; ?>/get_datatable/",
            "autoWidth": false,
            "responsive": true,
            "aLengthMenu": [
                [10, 25, 50, 100, 200, 500],
                [10, 25, 50, 100, 200, 500]
            ],
            "fnServerParams": function(aoData) {
                aoData.push({
                    "name": "tes",
                    "value": $('#pilih-tes').val()
                });
                aoData.push({
                    "name": "urutkan",
                    "value": $('#pilih-urutkan').val()
                });
                aoData.push({
                    "name": "status",
                    "value": $('#pilih-status').val()
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
    });
</script>