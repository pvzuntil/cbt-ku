<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Daftar Tes
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
                        <div class="card-title">Daftar Tes</div>
                        <div class="card-tools pull-right">
                            <div class="dropdown pull-right">
                                <a href="<?php echo site_url(); ?>/manager/tes_tambah" class="btn btn-sm btn-primary">Tambah Tes</a>
                            </div>
                        </div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <?php echo form_open($url . '/hapus_daftar_tes', 'id="form-hapus-pilih"'); ?>
                        <input type="hidden" name="check" id="check" value="0">
                        <input type="hidden" name="centang" id="centang" value="0">
                        <div id="form-pesan"><?php if (!empty($pesan_hapus)) {
                                                    echo $pesan_hapus;
                                                } ?></div>
                        <table id="table-tes" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="all">Nama Tes</th>
                                    <th class="all">Group</th>
                                    <th>Max Score</th>
                                    <th class="all">Waktu Mulai</th>
                                    <th>Waktu Selesai</th>
                                    <th class="none">Waktu Tes</th>
                                    <th class="none">Poin Dasar</th>
                                    <th class="none">Tunjukkan Hasil</th>
                                    <th class="none">Token</th>
                                    <th class="all"></th>
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
                                    <td> </td>
                                    <td> </td>
                                </tr>
                            </tbody>
                        </table>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="row d-flex" style="justify-content: space-between;">
                            <button type="button" id="btn-edit-hapus" class="btn btn-danger" title="Hapus Siswa yang dipilih">Hapus</button>
                            <button type="button" id="btn-edit-pilih" class="btn btn-default pull-right">Pilih Semua</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-hapus" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url . '/hapus_tes', 'id="form-hapus"'); ?>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Hapus Tes</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="form-pesan-hapus"></div>
                <div class="form-group">
                    <label>Nama Tes</label>
                    <input type="hidden" name="hapus-id" id="hapus-id">
                    <input type="text" class="form-control" id="hapus-nama" name="hapus-nama" readonly>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <input type="text" class="form-control" id="hapus-deskripsi" name="hapus-deskripsi" readonly>
                </div>
                <p>Tes yang dihapus akan membuat data nilai user juga akan ikut terhapus</p>
            </div>
            <div class="modal-footer d-flex" style="justify-content: space-between;">
                <button type="submit" id="btn-hapus" class="btn btn-danger">Hapus</button>
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
    <?= form_close() ?>
</div>

<div class="modal fade" id="modal-hapus-pilih" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Hapus Tes</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <strong>Peringatan</strong>
                Data Tes yang sudah dipilih akan dihapus beserta hasil tes tersebut.
                <br /><br />
                Apakah anda yakin untuk menghapus data Topik ?
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="edit-hapus-centang" name="edit-hapus-centang" value="1"> Ya, saya yakin Menghapus Tes yang telah dipilih.
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex" style="justify-content: space-between;">
                <button type="button" id="btn-hapus-pilih" class="btn btn-danger pull-left">Hapus</button>
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

<script lang="javascript">
    function refresh_table() {
        $('#table-tes').dataTable().fnReloadAjax();
    }

    function edit(id) {
        window.open("<?php echo site_url(); ?>/manager/tes_tambah/index/" + id, "_self");
    }

    function hapus(id) {
        SW.loading()
        $.getJSON('<?php echo site_url() . '/' . $url; ?>/get_by_id/' + id + '', function(data) {
            if (data.data == 1) {
                $('#hapus-id').val(data.id);
                $('#hapus-nama').val(data.nama);
                $('#hapus-deskripsi').val(data.deskripsi);


                $("#modal-hapus").modal('show');
            }
            SW.close()
        });
    }

    $(function() {
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
        $('#btn-edit-hapus').click(function() {
            $('#centang').val('0');
            $('#edit-hapus-centang').removeAttr("checked");;
            $("#modal-hapus-pilih").modal('show');
        });
        $('#btn-hapus-pilih').click(function() {
            SW.loading()
            $("#form-hapus-pilih").submit();
        });
        $("#edit-hapus-centang").change(function() {
            if (this.checked) {
                $('#centang').val('1');
            } else {
                $('#centang').val('0');
            }
        });

        $('#form-hapus').submit(function() {
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/hapus_tes",
                type: "POST",
                data: $('#form-hapus').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        refresh_table()
                        $("#modal-hapus").modal('hide');
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

        $('#table-tes').DataTable({
            "paging": true,
            "iDisplayLength": 50,
            "bProcessing": false,
            "bServerSide": true,
            "searching": true,
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
                    "bSortable": false
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "150px"
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "150px"
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
                    "sWidth": "50px"
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
            'fnDrawCallback': function() {
                callBackDatatable('#table-tes')
            }
        });
    });
</script>