<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Mengelola Jawaban
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
                        <div class="card-title">Data Soal <?php if (!empty($topik)) {
                                                                echo $topik;
                                                            } ?></div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <input type="hidden" name="topik" id="topik" value="<?php if (!empty($id_topik)) {
                                                                                echo $id_topik;
                                                                            } ?>" />
                        <?php if (!empty($soal)) {
                            echo $soal;
                        } ?>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Mengelola jawaban berdasarkan soal yang dipilih. Jika sudah selesai, silahkan kembali ke halaman Soal dengan menutup jendela ini atau memilih menu Soal</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <?php echo form_open_multipart($url . '/tambah', 'id="form-tambah" class="form-horizontal"'); ?>
                    <div class="card-header with-border">
                        <div class="card-title">Mengelola Jawaban</div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div id="form-pesan"></div>
                        <div class="form-group">
                            <label class="control-label">Jawaban</label>
                            <select class="form-control input-sm" id="tambah-benar" name="tambah-benar">
                                <option value="0">Salah</option>
                                <option value="1">Benar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Jawaban</label>
                            <input type="hidden" name="tambah-soal-id" id="tambah-soal-id" value="<?php if (!empty($id_soal)) {
                                                                                                        echo $id_soal;
                                                                                                    } ?>">
                            <input type="hidden" name="tambah-jawaban-id" id="tambah-jawaban-id">
                            <input type="hidden" name="tambah-jawaban" id="tambah-jawaban">
                            <textarea class="textarea" id="tambah_jawaban" name="tambah_jawaban" style="width: 100%; height: 100px; font-size: 13px; line-height: 25px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            <small class="text-muted mt-2">File gambar dapat di copy langsung atau di upload terlebih dahulu. File gambar yang didukung adalah jpg dan png.</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row d-flex" style="justify-content: space-between;">
                            <button type="button" id="btn-tambah-batal" class="btn btn-sm btn-default"><span>Batal</span></button>
                            <button type="submit" id="btn-tambah-simpan" class="btn btn-sm btn-primary"><span id="judul-tambah-simpan">Simpan</span></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Daftar Jawaban</div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <table id="table-jawaban" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Soal</th>
                                    <th>Jawaban</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
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

<div class="modal" id="modal-image" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 950px">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">&times;</button>
                <div id="trx-judul">Insert Image</div>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <?php echo form_open_multipart($url . '/upload_file', 'id="form-upload-image" class="form-horizontal"'); ?>
                                <div class="card">
                                    <div class="card-header with-border">
                                        <div class="card-title">Upload File</div>
                                    </div><!-- /.card-header -->

                                    <div class="card-body">
                                        <div class="row-fluid">
                                            <div class="card-body">
                                                <div id="form-pesan-upload-image"></div>
                                                <div class="form-group">
                                                    <label class="control-label">File</label>
                                                    <div class="col-sm-10">
                                                        <input type="hidden" id="image-topik-id" name="image-topik-id">
                                                        <input type="file" id="image-file" name="image-file">
                                                        <p class="help-block">File yang didukung adalah jpg, jpeg, png</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="image-upload" class="btn btn-primary">Upload File</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="col-6">
                                <div class="card hide" id="card-preview">
                                    <div class="card-body">
                                        <div class="row-fluid">
                                            <div class="card-body" style="height: 132px;">
                                                <input type="hidden" name="image-isi" id="image-isi">
                                                <div id="image-preview" style="text-align: center;vertical-align: middle;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="btn-image-insert" class="btn btn-primary">Masukkan Gambar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body" style="max-height: 230px;overflow: auto;">
                                        <table id="table-image" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama File</th>
                                                    <th>Preview</th>
                                                    <th>Tanggal</th>
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
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-hapus-jawaban" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url . '/hapus_jawaban', 'id="form-hapus-jawaban"'); ?>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Hapus Jawaban</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="form-pesan-hapus"></div>
                <div class="form-group">
                    <label>Jawaban</label>
                    <input type="hidden" name="hapus-id" id="hapus-id">
                    <div id="hapus-jawaban" style="max-height: 250px;overflow: auto;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btn-hapus-jawaban" class="btn btn-danger">Hapus</button>
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>

    </form>
</div>

<script lang="javascript">
    function refresh_table() {
        $('#table-jawaban').dataTable().fnReloadAjax();
    }

    function refresh_table_image() {
        $('#table-image').dataTable().fnReloadAjax();
    }

    function edit(id) {
        SW.loading()
        $.getJSON('<?php echo site_url() . '/' . $url; ?>/get_by_id/' + id + '', function(data) {
            if (data.data == 1) {
                $("#form-pesan").html('');
                $("#tambah-jawaban").val('');
                CKEDITOR.instances.tambah_jawaban.setData(data.jawaban)
                $('#tambah-benar').val(data.benar);
                $('#tambah-jawaban-id').val(data.id);
                SW.close()
                $('html, body').animate({
                    scrollTop: $("#form-tambah").offset().top
                }, 500);
            }
        });
    }

    function hapus(id) {
        $('#hapus-id').val('');
        $('#hapus-jawaban').html('');
        SW.loading()
        $.getJSON('<?php echo site_url() . '/' . $url; ?>/get_by_id/' + id + '', function(data) {
            if (data.data == 1) {
                $('#hapus-id').val(data.id);
                $('#hapus-jawaban').html(data.jawaban);
                SW.close()
                $("#modal-hapus-jawaban").modal("show");
            }
        });
    }

    /**
     * Fungsi untuk upload image dari editor
     */
    function imageUpload() {
        $('#box-preview').addClass('hide');
        $('#image-preview').html('');
        $('#form-pesan-upload-image').html('');
        $('#image-isi').val('');
        $('#image-file').val('');

        refresh_table_image();

        $("#modal-image").modal("show");
    }

    function image_preview(posisi, image) {
        $('#image-preview').html('<img src="<?php echo base_url(); ?>' + posisi + '/' + image + '" style="max-height: 110px;" />');
        $('#image-isi').val('<img src="<?php echo base_url(); ?>' + posisi + '/' + image + '" style="max-width: 600px;" />');
        $('#box-preview').removeClass('hide');
    }

    function batal_tambah() {
        $("#form-pesan").html('');
        $("#tambah-jawaban").val('');
        CKEDITOR.instances.tambah_jawaban.setData('')
        $('#tambah-benar').val('0');
        $('#tambah-jawaban-id').val('');
        $('#tambah-putar').val('1');
    }

    $(function() {
        $('#btn-image-insert').click(function() {
            var image = $('#image-isi').val();
            CKEDITOR.instances.tambah_jawaban.insertHtml(image);
            $("#modal-image").modal("hide");
        });

        $('#btn-tambah-batal').click(function() {
            batal_tambah();
        });

        /**
         * Submit form tambah soal
         */
        $('#form-tambah').submit(function() {
            $('#tambah-jawaban').val(CKEDITOR.instances.tambah_jawaban.getData());
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/tambah",
                type: "POST",
                timeout: 60000,
                data: $('#form-tambah').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        refresh_table();
                        batal_tambah();
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
                },
                error: function(xmlhttprequest, textstatus, message) {
                    if (textstatus === "timeout") {
                        SW.toast({
                            title: "Gagal menyimpan Jawaban, Silahkan Refresh Halaman",
                            icon: 'error'
                        })
                    } else {
                        SW.toast({
                            title: textstatus,
                            icon: 'error'
                        })
                    }
                }
            });
            return false;
        });

        /**
         * Submit form hapus soal
         */
        $('#form-hapus-jawaban').submit(function() {
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/hapus_jawaban",
                type: "POST",
                data: $('#form-hapus-jawaban').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        refresh_table();
                        $("#form-pesan-hapus").html('');
                        $("#modal-hapus-jawaban").modal('hide');
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

        /**
         * Submit form upload pada image browser
         */
        $('#form-upload-image').submit(function() {
            $('#image-topik-id').val($('#topik').val());
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
                        $('#image-preview').html(obj.image);
                        $('#image-isi').val(obj.image_isi);
                        $('#box-preview').removeClass('hide');
                        $("#form-pesan-upload-image").html('');
                        $('#image-file').val('');
                        refresh_table_image();
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

        $(document).ready(function() {
            $('#table-jawaban').DataTable({
                "bPaginate": false,
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
                        "name": "soal",
                        "value": $('#tambah-soal-id').val()
                    });
                },
                'fnDrawCallback': function() {
                    callBackDatatable('#table-jawaban')
                }
            });
            $('#table-image').DataTable({
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
                        "bSortable": false,
                        "sWidth": "100px"
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
                "sAjaxSource": "<?php echo site_url() . '/' . $url; ?>/get_datatable_image/",
                "autoWidth": false,
                "fnServerParams": function(aoData) {
                    aoData.push({
                        "name": "topik",
                        "value": $('#topik').val()
                    });
                },
                'fnDrawCallback': function() {
                    callBackDatatable('#table-image')
                }
            });

            CKEDITOR.replace('tambah_jawaban');

            <?php if (!empty($data_jawaban)) {
                echo $data_jawaban;
            } ?>
        });
    });
</script>