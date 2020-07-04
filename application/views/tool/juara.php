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
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="margin-bottom: 10px;">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Juara</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Sertifikat</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="row">
                <div class="col-sm-12">
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
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <div class="col-xs-12">
                                    <label>Nama Peserta</label>
                                </div>
                                <div class="col-xs-12">
                                    <div>
                                        <select name="generate-cert-peserta" id="generate-cert-peserta" class="form-control input-sm" style="width: 100%;">
                                            <!-- < value="">-- Pilih Peserta --</option> -->
                                            <optgroup label="Pilih peserta"> <?php if (!empty($select_group)) {
                                                                                    echo $select_group;
                                                                                } ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Opsi</label>
                                <select name="tambah-opsi" id="tambah-opsi" class="form-control input-sm">
                                    <option value="">-- Pilih Opsi --</option>
                                    <option value="medali emas">Medali Emas</option>
                                    <option value="medali perak">Medali Perak</option>
                                    <option value="medali perunggu">Medali Perunggu</option>
                                    <option value="peserta">Peserta</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Lomba</label>
                                <select name="tambah-lomba" id="tambah-lomba" class="form-control input-sm">
                                    <option value="">-- Pilih Lomba --</option>
                                    <option value="matematika">Matematika</option>
                                    <option value="sains">Sains</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2" style="margin-top: 23px;">
                            <button id="generate-cert" class="btn btn-primary btn-sm btn-block">Download Setifikat</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
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
                                                <th>Aksi</th>
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
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-sm btn-default" id="btn-cert-mtk">Cetak semua sertifikat</button>
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
                                                <th>Aksi</th>
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
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-sm btn-default" id="btn-cert-sains">Cetak semua sertifikat</button>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script src="<?php echo site_url() . '/'; ?>/public/images/cert/Nickainley-Normal-normal.js"></script>
<script src="<?php echo site_url() . '/'; ?>/public/images/cert/OpenSans-Regular-normal.js"></script>
<script src="<?php echo site_url() . '/'; ?>/public/images/cert/OpenSans-Bold-bold.js"></script>

<script lang="javascript">
    function refresh_table() {
        $('#table-juara-mtk').dataTable().fnReloadAjax();
        $('#table-juara-sains').dataTable().fnReloadAjax();
    }

    const toTitleCase = (phrase) => {
        return phrase
            .toLowerCase()
            .split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
    };

    $(function() {
        $('#generate-cert-peserta').select2();

        $('#pills-home-tab').click()

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
                {
                    "bSearchable": false,
                    "bSortable": false
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
                }, {
                    "bSearchable": false,
                    "bSortable": false
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
            salinData('matematika').then((data) => {
                insertData(data, 'matematika')
                Swal.fire({
                    toast: true,
                    timer: 2000,
                    title: 'Berhasil menyalin data',
                    icon: 'success',
                    showConfirmButton: false,
                    position: 'top-right'
                })
            })
        })

        $('#btn-salin-sains').on('click', function() {
            salinData('sains').then((data) => {
                insertData(data, 'sains')
                Swal.fire({
                    toast: true,
                    timer: 2000,
                    title: 'Berhasil menyalin data',
                    icon: 'success',
                    showConfirmButton: false,
                    position: 'top-right'
                })
            })
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

        $('#btn-cert-mtk').on('click', function() {
            salinData('matematika').then(data => {
                generate_cert(JSON.parse(data), 'juara', 'Matematika')
            })
        })

        $('#btn-cert-sains').on('click', function() {
            salinData('sains').then(data => {
                generate_cert(JSON.parse(data), 'juara', 'Sains')
            })
        })

        $('#generate-cert').on('click', function() {
            let id = $('#generate-cert-peserta').val()
            let juara = $('#tambah-opsi').val()
            let lomba = $('#tambah-lomba').val()

            if (id == '' || juara == '' || lomba == '') {
                return Swal.fire({
                    title: 'Wajib diisi semua !',
                    toast: true,
                    timer: 2000,
                    position: 'top-right',
                    icon: 'error',
                    showConfirmButton: false
                })
            }

            $.ajax({
                url: '<?= site_url() ?>/manager/peserta_daftar/get_by_id/' + id,
                beforeSend: function() {
                    $('#modal-proses').modal('show')
                },
                success: function(data) {
                    $('#modal-proses').modal('hide')

                    let res = JSON.parse(data)

                    if (juara == 'peserta') {
                        generate_cert([{
                            nama: res.nama,
                            sekolah: res.detail
                        }], 'peserta')
                    } else {
                        generate_cert([{
                            nama: res.nama,
                            sekolah: res.detail,
                            juara: toTitleCase(juara)
                        }], 'juara', lomba.capitalize())
                    }
                }
            })

        })
    });

    const salinData = (lomba) => {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/salin_data/",
                data: {
                    kelas: $('#form-kelas').val(),
                    lomba: lomba
                },
                method: 'POST',
                success: function(data) {
                    resolve(data)
                    // insertData(data, lomba)
                }
            })
        })
    }

    function cert(id, lomba, medali) {
        $('#pills-profile-tab').click()
        $('#generate-cert-peserta').val(id)
        $('#generate-cert-peserta').trigger('change');
        $('#tambah-lomba').val(lomba)
        $('#tambah-opsi').val(medali.toLowerCase())
        $('html, body').animate({
            scrollTop: 0
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
        $('#pills-home-tab').click()

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

    function generate_cert(data = {}, type = '', lomba = '') {
        Swal.fire({
            title: 'Harap tunggu tuan !',
            text: 'Sedang mengerjakan sesuai yang anda minta.',
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        })

        let doc = new jsPDF({
            orientation: "l",
            unit: "mm",
            format: "a4",
            putOnlyUsedFonts: true,
            floatPrecision: 16, // or "smart", default is 16
        });

        function loadImage(url) {
            return new Promise((resolve) => {
                let img = new Image();
                img.onload = () => resolve(img);
                img.src = url;
            });
        }

        let linkImage = type == 'peserta' ? "<?php echo site_url() . '/'; ?>/public/images/cert/EDIT-CERT-TEMPLATE.png" : "<?php echo site_url() . '/'; ?>/public/images/cert/CERT-KOSONG-II.png"

        loadImage(linkImage).then((logo) => {
            // const doc = new jsPDF("p", "mm", "a4");
            let width = doc.internal.pageSize.getWidth();
            let height = doc.internal.pageSize.getHeight();

            let halfWidth = width / 2
            let halfHeight = height / 2

            data.forEach((node, i) => {
                doc.addImage(logo, "PNG", 0, 0, width, height);

                doc.setFontStyle('normal');
                doc.setFont('Nickainley-Normal');
                doc.setFontSize(55)
                let textNama = node.nama;
                splitedNama = textNama.split(' ')

                if (splitedNama.length > 3) {
                    textNama = ''
                    splitedNama.forEach((el, i) => {
                        if (i > 2) {
                            let abjadWordAkhir = el.charAt(0)
                            textNama += abjadWordAkhir + '. '
                        } else {
                            textNama += el + ' '
                        }
                    })
                }

                textNama = toTitleCase(textNama)

                let textSekolah = node.sekolah;

                doc.text(textNama, halfWidth, halfHeight + 5, 'center')

                doc.setFont('OpenSans-Regular');
                doc.setFontSize(19)
                doc.text(textSekolah, halfWidth, halfHeight + 20, 'center')

                if (type == 'juara') {
                    let textJuara = node.juara;
                    doc.setFontSize(16)

                    doc.setFontStyle('bold');
                    doc.setFont('OpenSans-Bold');
                    doc.text('Juara ' + textJuara, halfWidth, halfHeight + 35, 'center')


                    doc.setFontSize(14)
                    doc.text(lomba.toUpperCase(), halfWidth - 3, halfHeight + 52, 'center')
                }

                doc.addPage()
            })


            doc.save('QEC Certificate ' + type.capitalize() + '-' + lomba + ' Kelas ' + $('#form-kelas').val(), {
                returnPromise: true
            }).then(() => {
                // window.location.reload()
                Swal.fire({
                    title: 'Berhasil !',
                    text: 'Berhasil membuat dokumen sertifikat',
                    icon: 'success'
                })
            })

        });
    }
</script>