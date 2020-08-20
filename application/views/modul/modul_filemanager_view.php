<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            File Manager
        </h1>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <?php echo form_open_multipart($url . '/upload_file', 'id="form-upload" class="form-horizontal"'); ?>
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Upload File</div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div id="form-pesan-upload"></div>
                        <div class="form-group">
                            <label class="control-label">File</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" aria-describedby="inputGroupFileAddon01" id="upload-file" name="upload-file">
                                    <label class="custom-file-label" for="upload-file">Choose file</label>
                                </div>
                            </div>
                            <small class="text-muted">File yang didukung adalah jpg, jpeg, png, mp3</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn-upload" class="btn btn-primary btn-sm">Upload File</button>
                    </div>
                </div>
                </form>
            </div>

            <div class="col-6">
                <?php echo form_open_multipart($url . '/tambah_dir', 'id="form-tambah" class="form-horizontal"'); ?>
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Create Directory</div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div id="form-pesan-tambah"></div>
                        <div class="form-group">
                            <label class="control-label">Direktori</label>
                            <input type="hidden" name="tambah-posisi" id="tambah-posisi">
                            <input type="text" class="form-control input-sm" id="tambah-dir" name="tambah-dir">
                            <small class="text-muted">Membuat direktori pada direktori yang aktif.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn-tambah" class="btn btn-sm btn-primary">Buat Direktori</button>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Data File : <a style="cursor:pointer;" onclick="open_home_dir()">Uploads</a><span id="posisi-file-judul"></span></div>
                        <div class="card-tools pull-right">
                            <div class="dropdown pull-right">
                                <a style="cursor: pointer;" onclick="refresh_table()" class="btn btn-sm btn-default">Refresh Data</a>
                            </div>
                        </div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <input type="hidden" name="posisi-file" id="posisi-file">
                        <table id="table-file" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama File</th>
                                    <th>Preview</th>
                                    <th>Tanggal</th>
                                    <th>Ukuran File</th>
                                    <th> </th>
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
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-preview" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Preview</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="preview-image" style="text-align: center;"></div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-hapus" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url . '/hapus_file', 'id="form-hapus"'); ?>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Hapus File / Direktori</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="form-pesan-hapus"></div>
                <div class="form-group">
                    <label>Nama File / Direktori</label>
                    <input type="hidden" name="hapus-posisi" id="hapus-posisi">
                    <input type="text" class="form-control" id="hapus-file" name="hapus-file" readonly>
                </div>
                <p>Perhatian, file atau direktori yang dihapus dapat mempengaruhi Soal yang telah dibuat.</p>
            </div>
            <div class="modal-footer d-flex" style="justify-content: space-between;">
                <button type="submit" id="btn-hapus" class="btn btn-danger">Hapus</button>
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>

    </form>
</div>

<script lang="javascript">
    function refresh_table() {
        $('#table-file').dataTable().fnReloadAjax();
    }

    function open_home_dir() {
        $("#posisi-file").val('')
        $("#posisi-file-judul").html($("#posisi-file").val());
        refresh_table();
    }

    function open_dir(dir) {
        var posisi = $("#posisi-file").val();
        $("#posisi-file").val(posisi + '/' + dir);
        $("#posisi-file-judul").html($("#posisi-file").val());
        refresh_table();
    }

    function open_image(image) {
        var posisi = $('#posisi-file').val();
        var gambar = '<img style="max-width:500px;" src="<?php echo base_url() . $upload_path; ?>/' + posisi + '/' + image + '" />'
        $('#preview-image').html(gambar);

        $("#modal-preview").modal("show");
    }

    function hapus_file(file) {
        var posisi = $('#posisi-file').val();
        $('#hapus-posisi').val(posisi);
        $('#hapus-file').val(file);
        $('#form-pesan-hapus').html('');

        $("#modal-hapus").modal("show");
    }

    $(function() {
        $('#form-upload').submit(function() {
            var posisi = $('#posisi-file').val();
            $('#upload-posisi').val(posisi);
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/upload_file",
                type: "POST",
                data: new FormData(this),
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        refresh_table();
                        $("#upload-file").val('');
                        $("#upload-posisi").val('');
                        $('#form-pesan-upload').html('');
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
            var posisi = $('#posisi-file').val();
            $('#tambah-posisi').val(posisi);
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/tambah_dir",
                type: "POST",
                data: $('#form-tambah').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        refresh_table();
                        $("#tambah-posisi").val('');
                        $("#tambah-dir").val('');
                        $("#tambah-dir").focus();
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

        $('#form-hapus').submit(function() {
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/hapus_file",
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

        $('#table-file').DataTable({
            "bPaginate": false,
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
                    "sWidth": "150px"
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "90px"
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "50px"
                }
            ],
            "sAjaxSource": "<?php echo site_url() . '/' . $url; ?>/get_datatable/",
            "autoWidth": false,
            "fnServerParams": function(aoData) {
                aoData.push({
                    "name": "posisi",
                    "value": $('#posisi-file').val()
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