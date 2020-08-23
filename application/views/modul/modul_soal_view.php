<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Pengelola Soal
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
                        <div class="card-title">Pilih Topik</div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="control-label">Pilih Topik</label>
                                <select name="topik" id="topik" class="form-control input-sm">
                                    <?php if (!empty($select_topik)) {
                                        echo $select_topik;
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        Pilih terlebih dahulu Topik yang akan digunakan sebelum menambah atau mengubah soal
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <?php echo form_open_multipart($url . '/tambah', 'id="form-tambah" class="form-horizontal"'); ?>
                    <div class="card-header with-border">
                        <div class="card-title">Mengelola Soal <span id="judul-tambah-soal"></span></div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div id="form-pesan"></div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label class="control-label">Soal</label>
                                <input type="hidden" name="tambah-topik-id" id="tambah-topik-id">
                                <input type="hidden" name="tambah-soal-id" id="tambah-soal-id">
                                <input type="hidden" name="tambah-soal" id="tambah-soal">
                                <textarea class="textarea" id="tambah_soal" name="tambah_soal" style="width: 100%; height: 150px; font-size: 13px; line-height: 25px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                <small class="help-block mt-2 text-muted">File gambar dapat di copy langsung atau di upload terlebih dahulu. File gambar yang didukung adalah jpg dan png.</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label for="">Soal Audio</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">File Audio</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" aria-describedby="inputGroupFileAddon01" id="tambah-audio" name="tambah-audio">
                                        <label class="custom-file-label" for="tambah-audio" id="tambah-nama-audio">Choose file</label>
                                    </div>
                                    <small class="text-muted mt-2">File audio yang akan ditambah pada soal. ( mp3). Jika ingin menghapus audio pada soal, maka Soalnya harus dihapus dahulu, setelah itu membuat soal ulang.</small>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Putar Sekali</label>
                                    <select class="form-control input-sm" id="tambah-putar" name="tambah-putar">
                                        <option value="0">Tidak</option>
                                        <option value="1">Ya</option>
                                    </select>
                                    <small class="help-block text-muted">Memutar Audio sebanyak satu kali dalam satu Tes</small>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Tipe Soal</label>
                                            <select class="form-control input-sm" id="tambah-tipe" name="tambah-tipe">
                                                <option value="1">Pilihan Ganda</option>
                                                <option value="2">Esai</option>
                                                <option value="3">Jawaban Singkat</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Tingkat Kesulitan</label>
                                            <select class="form-control input-sm" id="tambah-kesulitan" name="tambah-kesulitan">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group hide" id="form-tambah-jawaban">
                                    <label class="control-label">Kunci Jawaban Singkat</label>
                                    <input type="text" class="form-control input-sm" id="tambah-kunci-jawaban-singkat" name="tambah-kunci-jawaban-singkat">
                                    <small class="help-block text-muted">
                                        Kunci Jawaban untuk Tipe Soal Jawaban Singkat.<br />
                                        Pastikan kunci jawaban hanya satu kata untuk menghindari kesalahan penulisan. Untuk angka desimal gunakan tanda koma.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row d-flex" style="justify-content: space-between;">
                            <button type="button" id="btn-tambah-batal" class="btn btn-default"><span>Batal</span></button>
                            <button type="submit" id="btn-tambah-simpan" class="btn btn-primary"><span id="judul-tambah-simpan">Simpan</span></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Daftar Soal <span id="judul-daftar-soal"></span></div>
                        <div class="card-tools">
                            <a style="cursor: pointer;" onclick="refresh_table()" class="btn btn-xs btn-default">Refresh Data Soal</a>
                        </div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <table id="table-soal" class="table table-striped">
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
</section><!-- /.content -->


<div class="modal fade" id="modal-image" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Insert Image</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <?php echo form_open_multipart($url . '/upload_file', 'id="form-upload-image" class="form-horizontal"'); ?>
                        <div class="card">
                            <div class="card-header with-border">
                                <div class="card-title">Upload File</div>
                            </div><!-- /.card-header -->

                            <div class="card-body">
                                <div id="form-pesan-upload-image"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupFileAddon02">File</span>
                                        </div>
                                        <div class="custom-file">
                                            <label class="custom-file-label" for="inputGroupFile01" id="tambah-image-file">Choose file</label>
                                            <input type="file" class="custom-file-input" aria-describedby="inputGroupFileAddon02" id="image-file" name="image-file">
                                            <input type="hidden" id="image-topik-id" name="image-topik-id">
                                        </div>
                                    </div>
                                    <small class="text-muted">File yang didukung adalah jpg, jpeg, png</small>
                                </div>
                                <!-- <div class="form-group">
                                    <label class="control-label">File</label>
                                    <input type="file" id="image-file" name="image-file">
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="image-upload" class="btn btn-sm btn-primary">Upload File</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="card" id="card-preview">
                            <div class="card-body">
                                <input type="hidden" name="image-isi" id="image-isi">
                                <div id="image-preview" style="text-align: center;vertical-align: middle;"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btn-image-insert" class="btn btn-sm btn-primary">Masukkan Gambar</button>
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

<div class="modal" id="modal-hapus-soal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url . '/hapus_soal', 'id="form-hapus-soal"'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">&times;</button>
                <div id="trx-judul">Hapus Soal</div>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <div class="card-body">
                        <div id="form-pesan-hapus"></div>
                        <div class="form-group">
                            <label>Soal</label>
                            <input type="hidden" name="hapus-id" id="hapus-id">
                            <div id="hapus-soal" style="max-height: 250px;overflow: auto;"></div>
                        </div>
                        <p>Perhatian, soal yang dihapus akan membuat daftar jawaban ikut terhapus.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btn-hapus-soal" class="btn btn-primary">Hapus</button>
                <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>

    </form>
</div>


<script lang="javascript">
    function refresh_table() {
        $('#table-soal').dataTable().fnReloadAjax();
    }

    function refresh_table_image() {
        $('#table-image').dataTable().fnReloadAjax();
    }

    function refresh_topik() {
        var judul = $('#topik option:selected').text();
        $('#judul-daftar-soal').html(judul);
        $('#judul-tambah-soal').html(judul);
        $('#image-topik-id').val($('#topik').val());
    }

    function edit(id) {
        SW.loading()
        $.getJSON('<?php echo site_url() . '/' . $url; ?>/get_by_id/' + id + '', function(data) {
            if (data.data == 1) {
                $("#form-pesan").html('');
                $('#tambah-soal').val('');
                CKEDITOR.instances.tambah_soal.setData(data.soal)
                $('#tambah-tipe').val(data.tipe);
                $('#tambah-topik-id').val(data.id_topik);
                $('#tambah-soal-id').val(data.id);
                $('#tambah-putar').val(data.putar);
                $('#tambah-audio').val('');
                $('#tambah-kesulitan').val(data.kesulitan);
                $('#tambah-nama-audio').val(data.audio);
                $('#topik').val(data.id_topik);
                if (data.tipe == 3) {
                    $('#form-tambah-jawaban').removeClass('hide');
                    $('#tambah-kunci-jawaban-singkat').val(data.kunci);
                }

                $('html, body').animate({
                    scrollTop: $("#form-tambah").offset().top
                }, 500);
            }
            SW.close()
        });
    }

    function hapus(id) {
        $('#hapus-id').val('');
        $('#hapus-soal').html('');
        $('#form-pesan-hapus').html('');
        SW.loading()
        $.getJSON('<?php echo site_url() . '/' . $url; ?>/get_by_id/' + id + '', function(data) {
            if (data.data == 1) {
                $('#hapus-id').val(data.id);
                $('#hapus-soal').html(data.soal);

                $("#modal-hapus-soal").modal("show");
            }
            SW.close()
        });
    }

    function jawaban(id) {
        window.open('<?php echo site_url(); ?>/manager/modul_jawaban/index/' + id);
    }

    /**
     * Fungsi untuk upload image dari editor text
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
        $('#tambah-topik-id').val('');
        $('#tambah-soal-id').val('');
        $('#tambah-soal').val('');
        $('#tambah-putar').val('0');
        $('#tambah-audio').val('');
        $('#tambah-nama-audio').html('Choose file');
        $('#tambah-tipe').val('1');
        $('#tambah-kesulitan').val('1');
        $('#tambah-kunci-jawaban-singkat').val('');
        $('#form-tambah-jawaban').removeClass('hide');
        $('#form-tambah-jawaban').addClass('hide');

        CKEDITOR.instances.tambah_soal.setData('');
    }

    $(function() {
        $('#topik').select2();

        $("#topik").change(function() {
            refresh_topik();
            refresh_table();
        });

        $('#tambah-audio').change(function(e) {
            var fileName = e.target.files[0].name;
            $('#tambah-nama-audio').html(fileName);
        });

        $('#image-file').change(function(e) {
            var fileName = e.target.files[0].name;
            $('#tambah-image-file').html(fileName);
        });

        $('#btn-image-insert').click(function() {
            var image = $('#image-isi').val();
            CKEDITOR.instances.tambah_soal.insertHtml(image);
            $("#modal-image").modal("hide");
        });

        $('#tambah-tipe').change(function(e) {
            var tipe = $('#tambah-tipe').val();

            if (tipe == 3) {
                $('#form-tambah-jawaban').removeClass('hide');
            } else {
                $('#form-tambah-jawaban').addClass('hide');
            }
        });

        $('#btn-tambah-batal').click(function() {
            batal_tambah();
        });

        /**
         * Submit form tambah soal
         */
        $('#form-tambah').submit(function() {
            $('#tambah-soal').val(CKEDITOR.instances.tambah_soal.getData());
            $('#tambah-topik-id').val($('#topik').val());
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/tambah",
                type: "POST",
                timeout: 60000,
                data: new FormData(this),
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        refresh_table();
                        SW.close()
                        batal_tambah();
                        SW.toast({
                            title: obj.pesan,
                            icon: 'success'
                        })
                    } else {
                        SW.close()
                        SW.toast({
                            title: obj.pesan,
                            icon: 'error'
                        })
                    }
                },
                error: function(xmlhttprequest, textstatus, message) {
                    if (textstatus === "timeout") {
                        SW.close()
                        notify_error("Gagal menyimpan Soal, Silahkan Refresh Halaman");
                    } else {
                        SW.close()
                        notify_error(textstatus);
                    }
                }
            });
            return false;
        });

        /**
         * Submit form hapus soal
         */
        $('#form-hapus-soal').submit(function() {
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/hapus_soal",
                type: "POST",
                data: $('#form-hapus-soal').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        refresh_table();
                        SW.close()
                        $("#form-pesan-hapus").html('');
                        $("#modal-hapus-soal").modal('hide');
                        SW.toast({
                            title: obj.pesan,
                            icon: 'success'
                        })
                    } else {
                        SW.close()
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
         $('#image-topik-id').val($('#topik').val());
         * Submit form upload pada image browser
         */
        $('#form-upload-image').submit(function() {
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
                        SW.close()
                        $("#form-pesan-upload-image").html('');
                        $('#image-file').val('');
                        refresh_table_image();
                        SW.toast({
                            title: obj.pesan,
                            icon: 'success'
                        })
                    } else {
                        SW.close()
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
            refresh_topik();
            $('#table-soal').DataTable({
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
                        "sWidth": "50px"
                    },
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "sWidth": "80px"
                    }
                ],
                "sAjaxSource": "<?php echo site_url() . '/' . $url; ?>/get_datatable/",
                "autoWidth": false,
                "fnServerParams": function(aoData) {
                    aoData.push({
                        "name": "topik",
                        "value": $('#topik').val()
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
                'fnDrawCallback': function(oSettings) {
                    NP.d()
                    callBackDatatable(oSettings)
                },
                fnPreDrawCallback: function() {
                    NP.s()
                }
            });

            CKEDITOR.replace('tambah_soal');

            <?php if (!empty($data_soal)) {
                echo $data_soal;
            } ?>
        });
    });
</script>