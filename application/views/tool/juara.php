<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Juara
        <small>Membuat laporan kejuaraan dan menampilkan ke para peserta.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Juara</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php if ($isPublic == 1) : ?>
                <div class="callout callout-info">
                    <h4>Informasi</h4>
                    <p>Data juara telah dirilis dan telah dipublikasikan ke para peserta.</p>
                </div>
            <?php else : ?>
                <div class="callout callout-warning">
                    <h4>Informasi</h4>
                    <p>Data juara telah belum dibuat, silahkan buat data juara kemudian klik tombol "PUBLIKASIKAN" untuk menampilkannya ke para peserta.</p>
                </div>
            <?php endif ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-title">Buat Laporan Kejuaraan</div>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <span id="form-pesan-database"></span>
                    <p>Klik tombol <b>Publikasikan</b> untuk menampilkan laporan data kejuaran para peserta, dan diurutkan menurut peringkat nilai tertinggi.</p>
                    <p>Laporan kejuaraan akan ditampilkan kepada para peserta.</p>
                    <div class="row">
                        <div class="col-xs-12">
                            <b>Tulis Laporan</b>
                        </div>
                        <div class="col-xs-12">
                            <textarea class="textarea" id="tulis_laporan" name="tulis_laporan" style="width: 100%; height: 150px; font-size: 13px; line-height: 25px; border: 1px solid #dddddd; padding: 10px;"><?= $isiLaporan ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="button" class="btn btn-primary" id="juara-save">Simpan</button>
                    <div class="pull-right">
                        <!-- <button type="submit" class="btn btn-primary" id="backup-database">Buat Laporan</button> -->
                        <button type="button" class="btn <?= $isPublic == 0 ? 'btn-success' : 'btn-danger' ?>" id="juara-publikasi" value="<?= $isPublic == 0 ? '1' : '0' ?>"><?= $isPublic == 0 ? 'Publikasikan !' : 'Batalkan Publikasi' ?></button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-warning box-solid">
                        <div class="box-header with-border">
                            <div class="box-title">Data kejuaraan kelas <span id="kelas">1</span></div>
                        </div><!-- /.box-header -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="">Pilih kelas</label>
                                <select name="keals" id="form-kelas" class="form-control">
                                    <?php
                                    for ($i = 1; $i < 10; $i++) :
                                    ?>
                                        <option value="<?= $i ?>">Kelas <?= $i ?></option>
                                    <?php
                                    endfor ?>
                                </select>
                            </div>
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <div class="box-title"><b>Matematika</b></div>
                                </div>
                                <div class="box-body">
                                    <table id="table-juara-mtk" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nama Peserta</th>
                                                <th>Asal Sekolah</th>
                                                <th>Score</th>
                                                <th>Waktu mengerjakan</th>
                                                <th>Juara</th>
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
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-sm btn-primary" id="btn-salin-mtk">Salin Data</button>
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <div class="box-title"><b>Sains</b></div>
                                </div>
                                <div class="box-body">
                                    <table id="table-juara-sains" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nama Peserta</th>
                                                <th>Asal Sekolah</th>
                                                <th>Score</th>
                                                <th>Waktu mengerjakan</th>
                                                <th>Juara</th>
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
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-sm btn-primary" id="btn-salin-sains">Salin Data</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="modal-image" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog" style="width: 950px">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Insert Image</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <?php echo form_open_multipart($url . '/upload_file', 'id="form-upload-image" class="form-horizontal"'); ?>
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <div class="box-title">Upload File</div>
                                        </div><!-- /.box-header -->

                                        <div class="box-body">
                                            <div class="row-fluid">
                                                <div class="box-body">
                                                    <div id="form-pesan-upload-image"></div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">File</label>
                                                        <div class="col-sm-10">
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
                                <div class="col-xs-6">
                                    <div class="box hide" id="box-preview">
                                        <div class="box-body">
                                            <div class="row-fluid">
                                                <div class="box-body" style="height: 132px;">
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
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-body" style="max-height: 230px;overflow: auto;">
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


</section><!-- /.content -->



<script lang="javascript">
    function refresh_table() {
        $('#table-juara-mtk').dataTable().fnReloadAjax();
        $('#table-juara-sains').dataTable().fnReloadAjax();
    }

    $(function() {
        $('#form-kelas').on('change', function() {
            $('#kelas').html($(this).val())
            refresh_table()

        })

        CKEDITOR.replace('tulis_laporan');

        $('#btn-image-insert').click(function() {
            var image = $('#image-isi').val();
            CKEDITOR.instances.tulis_laporan.insertHtml(image);
            $("#modal-image").modal("hide");
        });

        $('#form-upload-image').submit(function() {
            $("#modal-proses").modal('show');
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
                        $('#image-preview').html(obj.image);
                        $('#image-isi').val(obj.image_isi);
                        $('#box-preview').removeClass('hide');
                        $("#modal-proses").modal('hide');
                        $("#form-pesan-upload-image").html('');
                        $('#image-file').val('');
                        refresh_table_image();
                        notify_success(obj.pesan);
                    } else {
                        $("#modal-proses").modal('hide');
                        $('#form-pesan-upload-image').html(pesan_err(obj.pesan));
                    }
                }
            });
            return false;
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
        });

        $('#table-juara-mtk').DataTable({
            "bPaginate": false,
            "bProcessing": false,
            "bServerSide": true,
            "searching": false,
            "aoColumns": [{
                    "bSearchable": false,
                    "bSortable": false,
                    // "sWidth": "20px"
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
                    "sWidth": "100px"
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "90px"
                },

            ],
            "sAjaxSource": "<?php echo site_url() . '/' . $url; ?>/get_datatable_juara/",
            "autoWidth": false,
            "responsive": true,
            "fnServerParams": function(aoData) {
                aoData.push({
                    "name": "kelas",
                    "value": $('#form-kelas').val()
                });
                aoData.push({
                    "name": "lomba",
                    "value": 'matematika'
                });
            }
        });

        $('#table-juara-sains').DataTable({
            "bPaginate": false,
            "bProcessing": false,
            "bServerSide": true,
            "searching": false,
            "aoColumns": [{
                    "bSearchable": false,
                    "bSortable": false,
                    // "sWidth": "20px"
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
                    "sWidth": "100px"
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "90px"
                },

            ],
            "sAjaxSource": "<?php echo site_url() . '/' . $url; ?>/get_datatable_juara/",
            "autoWidth": false,
            "responsive": true,
            "fnServerParams": function(aoData) {
                aoData.push({
                    "name": "kelas",
                    "value": $('#form-kelas').val()
                });
                aoData.push({
                    "name": "lomba",
                    "value": 'sains'
                });
            }
        });

        $('#btn-salin-mtk').on('click', function() {
            salinData('matematika')
        })
        $('#btn-salin-sains').on('click', function() {
            salinData('sains')
        })

        $('#juara-save').on('click', function() {
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/save_juara/",
                data: {
                    isi: CKEDITOR.instances.tulis_laporan.getData()
                },
                method: 'POST',
                beforeSend: function() {
                    $('#modal-proses').modal('show')
                },
                success: function() {
                    $('#modal-proses').modal('hide')
                    return Swal.fire({
                        title: 'Berhasil menyimpan data laporan',
                        toast: true,
                        timer: 2000,
                        position: 'top-right',
                        icon: 'success',
                        showConfirmButton: false
                    })
                }
            })
        })

        $('#juara-publikasi').on('click', function() {
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/publikasi_juara/",
                data: {
                    isPublic: $('#juara-publikasi').val()
                },
                method: 'POST',
                beforeSend: function() {
                    $('#modal-proses').modal('show')
                },
                success: function(data) {
                    $('#modal-proses').modal('hide')
                    return Swal.fire({
                        title: 'Berhasil',
                        text: data == 1 ? 'Berhasil mempublikasikan laporan' : 'Berhasil membatalkan publikasi laporan',
                        icon: 'success',
                    }).then(() => {
                        window.location.reload()
                    })
                }
            })
        })
    });

    function salinData(lomba) {
        $.ajax({
            url: "<?php echo site_url() . '/' . $url; ?>/salin_data/",
            data: {
                kelas: $('#form-kelas').val(),
                lomba: lomba
            },
            method: 'POST',
            success: function(data) {
                insertData(data, lomba)
            }
        })
    }

    function insertData(data, lomba) {
        let dataJuara = '<h2><b>Juara Lomba ' + lomba.capitalize() + ' Kelas ' + $('#form-kelas').val() + '</b></h2>';
        if (data == false) {
            return Swal.fire({
                toast: true,
                timer: 2000,
                position: 'top-right',
                title: 'Data kosong',
                icon: 'error',
                showConfirmButton: false
            })
        }
        data = JSON.parse(data)


        data.forEach((el, i) => {
            dataJuara += '🏆 Juara ' + el.juara + '<br>'
            dataJuara += '<b>' + el.nama + '</b><br>'
            dataJuara += '🏫 ' + el.sekolah + '<br>'
            dataJuara += '🅿 ' + el.nilai + ' ⏱ ' + el.durasi + '<br>'
            dataJuara += '<br>'
        });

        CKEDITOR.instances.tulis_laporan.insertHtml(dataJuara);

    }

    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }

    function imageUpload() {
        $('#box-preview').addClass('hide');
        $('#image-preview').html('');
        $('#form-pesan-upload-image').html('');
        $('#image-isi').val('');
        $('#image-file').val('');

        refresh_table_image();

        $("#modal-image").modal("show");
    }

    function refresh_table_image() {
        $('#table-image').dataTable().fnReloadAjax();
    }

    function image_preview(posisi, image) {
        $('#image-preview').html('<img src="<?php echo base_url(); ?>' + posisi + '/' + image + '" style="max-height: 110px;" />');
        $('#image-isi').val('<img src="<?php echo base_url(); ?>' + posisi + '/' + image + '" style="max-width: 600px;" />');
        $('#box-preview').removeClass('hide');
    }

    String.prototype.capitalize = function() {
        return this.charAt(0).toUpperCase() + this.slice(1);
    }
</script>