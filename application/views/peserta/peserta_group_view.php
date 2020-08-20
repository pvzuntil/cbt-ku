<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Group
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
                        <div class="card-title">Daftar Group</div>
                        <div class="card-tools">
                            <a style="cursor: pointer;" onclick="tambah()" class="btn btn-sm btn-primary text-white">Tambah Group</a>
                        </div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <table id="table-group" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Group</th>
                                    <th>Action</th>
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
        </div>
    </div>
</section>

<div class="modal fade" id="modal-tambah" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url . '/tambah', 'id="form-tambah"'); ?>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Tambah Group</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="form-pesan"></div>
                <div class="form-group">
                    <label>Nama Group</label>
                    <input type="text" class="form-control" id="tambah-group" name="tambah-group" placeholder="Nama Group">
                </div>

                <p>NB : Group digunakan untuk mengelompokkan setiap user</p>
            </div>
            <div class="modal-footer">
                <button type="submit" id="tambah-simpan" class="btn btn-primary btn-sm">Tambah</button>
                <a href="#" class="btn btn-default btn-sm" data-dismiss="modal">Close</a>
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
                <div id="trx-judul">Edit Group</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="form-pesan-edit"></div>
                <div class="form-group">
                    <label>Nama Group</label>
                    <input type="hidden" name="edit-id" id="edit-id">
                    <input type="hidden" name="edit-pilihan" id="edit-pilihan">
                    <input type="hidden" name="edit-group-asli" id="edit-group-asli">
                    <input type="text" class="form-control" id="edit-group" name="edit-group" placeholder="Nama Group">
                </div>

                <p>NB : Group yang dihapus, maka semua data user akan ikut terhapus !</p>
            </div>
            <div class="modal-footer d-flex" style="justify-content: space-between;">
                <button type="button" id="edit-hapus" class="btn btn-danger">Hapus</button>
                <div>
                    <button type="button" id="edit-simpan" class="btn btn-primary">Simpan</button>
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>

    </form>
</div>

<script lang="javascript">
    function refresh_table() {
        $('#table-group').dataTable().fnReloadAjax();
    }

    function tambah() {
        $('#form-pesan').html('');
        $('#tambah-group').val('');

        $("#modal-tambah").modal("show");
        $('#tambah-group').focus();
    }

    function edit(id) {
        SW.loading()
        $.getJSON('<?php echo site_url() . '/' . $url; ?>/get_by_id/' + id + '', function(data) {
            if (data.data == 1) {
                $('#edit-id').val(data.id);
                $('#edit-group').val(data.group);
                $('#edit-group-asli').val(data.group);
                $("#modal-edit").modal("show");
                SW.close()
            }
        });
    }

    $(function() {
        $('#edit-simpan').click(function() {
            $('#edit-pilihan').val('simpan');
            $('#form-edit').submit();
        });
        $('#edit-hapus').click(function() {
            $('#edit-pilihan').val('hapus');
            $('#form-edit').submit();
        });

        $('#form-edit').submit(function() {
            SW.loading()
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
            SW.loading()
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

        $('#table-group').DataTable({
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
                    "bSortable": false,
                    "sWidth": "30px"
                }
            ],
            "sAjaxSource": "<?php echo site_url() . '/' . $url; ?>/get_datatable/",
            "autoWidth": false,
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