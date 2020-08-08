<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Topik
        </h1>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Pilih Modul</div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="form-group">
                            <label>Modul</label>
                            <div id="data-kelas">
                                <select name="modul" id="modul" class="form-control input-sm">
                                    <?php if (!empty($select_modul)) {
                                        echo $select_modul;
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <span>Pilih modul terlebih dahulu untuk menampilkan dan menambah topik</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Daftar Topik</div>
                        <div class="card-tools pull-right">
                            <a style="cursor: pointer;" onclick="tambah()" class="btn btn-success btn-sm text-white">Tambah Topik</a>
                        </div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <?php echo form_open($url . '/hapus_daftar_topik', 'id="form-hapus"'); ?>
                        <input type="hidden" name="check" id="check" value="0">
                        <table id="table-topik" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="all">Nama Topik</th>
                                    <th>Deskripsi</th>
                                    <th>Jml. Soal</th>
                                    <th>Status</th>
                                    <th class="all">Action</th>
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
                                </tr>
                            </tbody>
                        </table>
                        <?= form_close() ?>
                    </div>
                    <div class="card-footer">
                        <div class="row d-flex" style="justify-content: space-between;">
                            <button type="button" id="btn-edit-pilih" class="btn btn-default">Pilih Semua</button>
                            <button type="button" id="btn-edit-hapus" class="btn btn-primary" title="Hapus Siswa yang dipilih">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-tambah" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url . '/tambah', 'id="form-tambah"'); ?>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Tambah Topik</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="form-pesan"></div>
                <div class="form-group">
                    <label>Nama Topik</label>
                    <input type="hidden" name="tambah-modul-id" id="tambah-modul-id">
                    <input type="text" class="form-control" id="tambah-topik" name="tambah-topik" placeholder="Nama Topik">
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <input type="text" class="form-control" id="tambah-deskripsi" name="tambah-deskripsi" placeholder="Deskripsi Topik">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" id="tambah-status" name="tambah-status" value="AKTIF" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="tambah-simpan" class="btn btn-primary">Tambah</button>
                <a href="#" class="btn btn-danger" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>

    </form>
</div>

<div class="modal fade" id="modal-edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url . '/edit', 'id="form-edit"'); ?>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Edit Topik</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="form-pesan-edit"></div>
                <div class="form-group">
                    <label>Nama Topik</label>
                    <input type="hidden" name="edit-id" id="edit-id">
                    <input type="hidden" name="edit-modul-id" id="edit-modul-id">
                    <input type="hidden" name="edit-pilihan" id="edit-pilihan">
                    <input type="hidden" name="edit-topik-asli" id="edit-topik-asli">
                    <input type="text" class="form-control" id="edit-topik" name="edit-topik" placeholder="Nama Topik">
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <input type="text" class="form-control" id="edit-deskripsi" name="edit-deskripsi" placeholder="Deskripsi Topik">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" id="edit-status" name="edit-status" value="AKTIF" readonly>
                </div>
                <p>NB : Topik yang dihapus, maka semua bank soal akan ikut terhapus !</p>
            </div>
            <div class="modal-footer">
                <div class="row d-flex w-100" style="justify-content: space-between;">
                    <button type="button" id="edit-hapus" class="btn btn-danger">Hapus</button>
                    <div>
                        <button type="button" id="edit-simpan" class="btn btn-success">Simpan</button>
                        <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </form>
</div>

<div class="modal fade" id="modal-hapus" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Hapus Topik</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <strong>Peringatan</strong>
                Data Topik yang sudah dipilih akan dihapus beserta isi soal didalamnya.
                <br /><br />
                Apakah anda yakin untuk menghapus data Topik ?
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-hapus" class="btn btn-danger">Hapus</button>
                <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>


<script lang="javascript">
    function refresh_table() {
        $('#table-topik').dataTable().fnReloadAjax();
    }

    function tambah() {
        $('#form-pesan').html('');
        $('#tambah-topik').val('');
        $('#tambah-modul-id').val('');
        $('#tambah-deskripsi').val('');

        $("#modal-tambah").modal("show");
        $('#tambah-topik').focus();
    }

    function edit(id) {
        SW.loading();
        $.getJSON('<?php echo site_url() . '/' . $url; ?>/get_by_id/' + id + '', function(data) {
            if (data.data == 1) {
                SW.close()
                $('#edit-id').val(data.id);
                $('#edit-topik').val(data.topik);
                $('#edit-topik-asli').val(data.topik);
                $('#edit-deskripsi').val(data.deskripsi);
                $('#edit-modul-id').val('');

                $("#modal-edit").modal("show");
            }
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

        $("#modul").change(function() {
            refresh_table();
        });

        $('#edit-simpan').click(function() {
            $('#edit-pilihan').val('simpan');
            $('#form-edit').submit();
        });
        $('#edit-hapus').click(function() {
            $('#edit-pilihan').val('hapus');
            $('#form-edit').submit();
        });
        $('#btn-edit-hapus').click(function() {
            $("#modal-hapus").modal('show');
        });
        $('#btn-hapus').click(function() {
            $("#form-hapus").submit();
        });

        $('#form-hapus').submit(function() {
            SW.loading();
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/hapus_daftar_topik",
                type: "POST",
                data: $('#form-hapus').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        refresh_table();
                        $("#modal-hapus").modal('hide');
                        SW.toast({
                            title: obj.pesan,
                            icon: 'success'
                        })
                        $('#check').val('0');
                    } else if (obj.status == 2) {
                        $("#modal-hapus").modal('hide');
                        refresh_table();
                        SW.toast({
                            title: obj.pesan,
                            icon: 'warning'
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

        $('#form-edit').submit(function() {
            $('#edit-modul-id').val($('#modul').val());
            SW.loading();
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/edit",
                type: "POST",
                data: $('#form-edit').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        refresh_table();
                        $("#modal-edit").modal('hide');
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

        $('#form-tambah').submit(function() {
            $('#tambah-modul-id').val($('#modul').val());
            SW.loading();
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/tambah",
                type: "POST",
                data: $('#form-tambah').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        refresh_table();
                        $("#modal-tambah").modal('hide');
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

        $('#table-topik').DataTable({
            "paging": true,
            "iDisplayLength": 10,
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
                    "bSortable": false
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "30px"
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "30px"
                }
            ],
            "sAjaxSource": "<?php echo site_url() . '/' . $url; ?>/get_datatable/",
            "autoWidth": false,
            "responsive": true,
            "fnServerParams": function(aoData) {
                aoData.push({
                    "name": "modul",
                    "value": $('#modul').val()
                });
            },
            'fnDrawCallback': function() {
                callBackDatatable('#table-topik')
            }
        });
    });
</script>