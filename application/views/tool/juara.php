<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Juara
        </h1>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Juara</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Sertifikat</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-12">
                                        <?php if ($isPublic == 1) : ?>
                                            <div class="callout callout-info">
                                                <h4>Informasi</h4>
                                                <p>Data juara telah dirilis dan telah dipublikasikan ke para peserta.</p>
                                            </div>
                                        <?php else : ?>
                                            <div class="callout callout-warning">
                                                <h4>Informasi</h4>
                                                <p>Data juara telah belum dibuat, silahkan buat data juara kemudian klik tombol
                                                    <b>PUBLIKASIKAN</b> untuk menampilkannya ke para peserta.</p>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header with-border">
                                                <div class="card-title">Buat Laporan Kejuaraan</div>
                                            </div><!-- /.card-header -->

                                            <div class="card-body">
                                                <span id="form-pesan-database"></span>
                                                <p>Klik tombol <b>Publikasikan</b> untuk menampilkan laporan data kejuaran para
                                                    peserta, dan diurutkan menurut peringkat nilai tertinggi.</p>
                                                <p>Laporan kejuaraan akan ditampilkan kepada para peserta.</p>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Tulis Laporan</label>
                                                            <textarea class="textarea" id="tulis_laporan" name="tulis_laporan" style="width: 100%; height: 150px; font-size: 13px; line-height: 25px; border: 1px solid #dddddd; padding: 10px;"><?= $isiLaporan ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-footer">
                                                <div class="row d-flex" style="justify-content: space-between;">
                                                    <button type="button" class="btn btn-primary" id="juara-save">Simpan</button>
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
                    <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <label>Nama Peserta</label>
                                            </div>
                                            <div class="col-12">
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
                                    <div class="col-sm-3">
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
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Lomba</label>
                                            <select name="tambah-lomba" id="tambah-lomba" class="form-control input-sm">
                                                <option value="">-- Pilih Lomba --</option>
                                                <?= $select_modul ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button id="generate-cert" class="btn btn-primary btn-sm btn-block">Download
                                            Setifikat</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!--  -->
        <!-- TODO buat laporan juara nanti -->
        <div class="row" style="margin-top: 10px;">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-info card-solid">
                            <div class="card-header with-border">
                                <div class="card-title">Data kejuaraan kelas <span id="kelas">1</span></div>
                            </div><!-- /.card-header -->

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Pilih jenis tes</label>
                                            <select name="jenis" id="form-jenis" class="form-control">
                                                <option value="DESC">TryOut</option>
                                                <option value="ASC">Kompetisi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="">Pilih lomba</label>
                                            <select name="lomba" id="form-lomba" class="form-control">
                                                <?= $select_modul ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="">Pilih kelas</label>
                                            <select name="keals" id="form-kelas" class="form-control">
                                                <?php foreach ($select_kelas as $kelas) : ?>
                                                    <option value="<?= $kelas ?>">Kelas <?= $kelas ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-success">
                                    <div class="card-header with-border">
                                        <div class="card-title"><b id="label-lomba">Matematika</b></div>
                                    </div>
                                    <div class="card-body">
                                        <table id="table-juara" class="table table-bordered table-hover">
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
                                    <div class="card-footer">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-sm btn-default" id="btn-cert">Cetak
                                                semua sertifikat</button>
                                            <button type="button" class="btn btn-sm btn-primary" id="btn-salin">Salin
                                                Data</button>
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
</section>

<div class="modal" id="modal-image" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 950px">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Insert Image</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
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
                                                <div class="form-group">
                                                    <label class="control-label">File</label>
                                                    <input type="file" id="image-file" name="image-file">
                                                    <small class="help-block text-muted">File yang didukung adalah jpg, jpeg,
                                                        png</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="image-upload" class="btn btn-primary">Upload
                                            File</button>
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
                                        <button type="button" id="btn-image-insert" class="btn btn-primary">Masukkan
                                            Gambar</button>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous">
</script>
<script src="<?php echo site_url() . '/'; ?>/public/images/cert/font.js"></script>
<!-- <script src="<?php echo site_url() . '/'; ?>/public/images/cert/Nickainley-Normal-normal.js"></script>
<script src="<?php echo site_url() . '/'; ?>/public/images/cert/OpenSans-Bold-bold.js"></script> -->

<script lang="javascript">
    function refresh_table() {
        $('#table-juara').dataTable().fnReloadAjax();
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

        $('#form-jenis').on('change', function() {
            refresh_table()
        })

        $('#form-lomba').on('change', function() {
            $('#label-lomba').html(
                $('#form-lomba option:selected').data('label')
            )
            refresh_table()
        })

        $('#label-lomba').html(
            $('#form-lomba option:selected').data('label')
        )

        CKEDITOR.replace('tulis_laporan');

        $('#btn-image-insert').click(function() {
            var image = $('#image-isi').val();
            CKEDITOR.instances.tulis_laporan.insertHtml(image);
            $("#modal-image").modal("hide");
        });

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
                        $('#image-preview').html(obj.image);
                        $('#image-isi').val(obj.image_isi);
                        $('#card-preview').removeClass('hide');
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
            'fnDrawCallback': function(oSettings) {
                NP.d()
                callBackDatatable(oSettings)
            },
            fnPreDrawCallback: function() {
                NP.s()
            }
        });

        $('#table-juara').DataTable({
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
                    "value": $('#form-lomba').val()
                });
                aoData.push({
                    "name": "jenis",
                    "value": $('#form-jenis').val()
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

        $('#btn-salin').on('click', function() {
            salinData('matematika').then((data) => {
                insertData(data, $('#form-lomba option:selected').data('label'))
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

        $('#btn-cert').on('click', function() {
            salinData('matematika').then(data => {
                generate_cert(JSON.parse(data), 'juara', 'Matematika')
            })
        })

        $('#generate-cert').on('click', function() {
            let id = $('#generate-cert-peserta').val()
            let juara = $('#tambah-opsi').val()
            let lomba = $("#tambah-lomba option:selected").data('label')

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
                            juaraRaw: toTitleCase(juara),
                            kelas: res.kelas
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
                    lomba: $('#form-lomba').val(),
                    jenis: $('#form-jenis').val(),
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
        $('#custom-tabs-three-profile-tab').click()
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
        $('#card-preview').addClass('hide');
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
        $('#image-preview').html('<img src="<?php echo base_url(); ?>' + posisi + '/' + image +
            '" style="max-height: 110px;" />');
        $('#image-isi').val('<img src="<?php echo base_url(); ?>' + posisi + '/' + image +
            '" style="max-width: 600px;" />');
        $('#card-preview').removeClass('hide');
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

        doc = initFont(doc);

        function loadImage(url) {
            return new Promise((resolve) => {
                let img = new Image();
                img.onload = () => resolve(img);
                img.src = url;
            });
        }

        let linkImage = type == 'peserta' ?
            "<?php echo site_url() . '/'; ?>/public/images/cert/main.png" :
            "<?php echo site_url() . '/'; ?>/public/images/cert/main.png"

        loadImage(linkImage).then((logo) => {
            // const doc = new jsPDF("p", "mm", "a4");
            let width = doc.internal.pageSize.getWidth();
            let height = doc.internal.pageSize.getHeight();

            let halfWidth = width / 2
            let halfHeight = height / 2

            let dataLength = data.length;

            data.forEach((node, i) => {
                doc.addImage(logo, "PNG", 0, 0, width, height);

                doc.setFontStyle('normal');
                doc.setFont('vibes');
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

                if (type == 'juara') {
                    doc.setTextColor(25, 33, 40);
                    doc.text(textNama, halfWidth, halfHeight - 7, 'center')

                    doc.setFont('pop-normal');
                    doc.setFontSize(20)
                    doc.text(textSekolah, halfWidth, halfHeight + 5, 'center')

                    doc.setFontSize(14)
                    doc.setFont('pop-normal');
                    doc.text('Sebagai peraih', halfWidth, halfHeight + 19, 'center')

                    let textJuara = node.juaraRaw.toUpperCase();
                    doc.setFont('pop-semibold');
                    doc.setFontSize(30)
                    doc.setTextColor(0, 149, 172);
                    doc.text(textJuara, halfWidth, halfHeight + 32, 'center')

                    doc.setFontSize(14)
                    doc.setFont('pop-normal');
                    doc.text('LOMBA ' + lomba.toUpperCase() + ' - KELAS ' + node.kelas,
                        halfWidth,
                        halfHeight + 37,
                        'center')
                } else {
                    doc.setTextColor(25, 33, 40);
                    doc.text(textNama, halfWidth, halfHeight - 7, 'center')

                    doc.setFont('pop-normal');
                    doc.setFontSize(20)
                    doc.text(textSekolah, halfWidth, halfHeight + 5, 'center')

                    doc.setFontSize(14)
                    doc.setFont('pop-normal');
                    doc.text('Atas partisipasinya sebagai', halfWidth, halfHeight + 19, 'center')

                    doc.setFont('pop-semibold');
                    doc.setFontSize(30)
                    doc.setTextColor(0, 149, 172);
                    doc.text('PESERTA', halfWidth, halfHeight + 32, 'center')
                }

                if (i + 1 < dataLength) {
                    doc.addPage()
                }
            })


            doc.save('QEC Certificate ' + type.capitalize() + '-' + lomba + ' Kelas ' + $('#form-kelas')
                .val(), {
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