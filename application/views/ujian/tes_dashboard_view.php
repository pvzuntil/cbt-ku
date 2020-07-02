<div class="container">
    <!-- Content Header (Page header) -->
    <div class="box shadow-box" style="margin-top: 20px;">
        <section class="content-header">
            <h1>
                <?php if (!empty($nama)) {
                    echo $nama;
                } ?>
            </h1>
            <div class="badge">Kelas <?= $currentUser->kelas ?></div>
            <div class="badge">Lomba : <?= $currentUser->lomba == 'all' ? 'Matematika & Sains' : ucfirst($currentUser->lomba) ?></div>
            <div class="badge"><?= explode('-', $group)[0] ?></div>
            <!-- <div class="btn btn-link btn-xs">Lihat profil</div> -->
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php if ($showPay) : ?>
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Konfirmasi pembayaran</h3>
                    </div><!-- /.box-header -->
                    <?php echo form_open($url . '/pay', 'id="form-pay" enctype="multipart/form-data"'); ?>
                    <div class="box-body">
                        <?php if ($userPay_status == 'wait') : ?>
                            <div class="callout callout-info">
                                <p>Anda telah mengirimkan bukti pembayaran pada <?= $date_pay ?>, tunggu pihak panitia untuk mengkonfirmasi pembayaran anda</p>
                            </div>
                        <?php elseif ($userPay_status == 'deny') : ?>
                            <div class="callout callout-danger">
                                <p>Bukti pembayaran anda pada <?= $date_pay ?> ditolak panitia karena "<?= $userPay->message ?>"</p>
                                <p>Silahkan unggah kembali bukti pembayaran dengan tepat.</p>
                            </div>
                        <?php else : ?>
                            <div class="callout callout-warning">
                                <p>Silahkan Transfer biaya pendaftaran dan kirim bukti transfer. Rekening BCA no 3270 3964 87 an Moch Abdur Rokhim, kemudian unggah bukti pembayaran dibawah</p>
                            </div>
                        <?php endif ?>
                        <div id="form-pesan-pay"></div>
                        <hr>
                        <div class="row" style="display: flex; justify-content: center; flex-direction: column; align-items: center; flex-wrap: wrap;">
                            <div class="col-sm-6" style="margin-bottom: 15px; display: flex; justify-content: center;">
                                <img src="<?= $userPay_status == 'none'  ? site_url() . 'public/images/placeholder.png' : site_url() . $userPay->img_pay ?>" alt="" class="img-responsive <?= $userPay_status == 'wait' ? 'zoom' : '' ?>" style="border-radius: 5px; cursor: pointer; box-shadow: 0px 4px 8px 0px #00000026;" id="imagePay">
                            </div>
                            <?php if ($userPay_status != 'wait') : ?>
                                <p>Klik gambar untuk memilih foto</p>
                                <input type="file" name="uplaodImgPay" id="uplaodImgPay" accept="image/*" style="display: none;">
                                <input type="hidden" name="uploadImgPayText" id="uploadImgPayText" style="display: none;">
                            <?php endif ?>
                        </div>
                    </div><!-- /.box-body -->
                    <?php if ($userPay_status != 'wait') : ?>
                        <div class="box-footer">
                            <div class="pull-right">
                                <button class="btn btn-success btn-sm">Kirim</button>
                            </div>
                        </div>
                    <?php endif ?>
                    </form>
                </div><!-- /.box -->
            <?php else : ?>
                <div class="callout callout-info">
                    <h4>Informasi</h4>
                    <?php if ($isShow  == 0) : ?>
                        <p>Bukti pembayaran anda sudah kami konfirmasi, terima kasih :)</p>
                    <?php endif ?>

                    <p>Silahkan pilih Mapel yang diikuti dari daftar lomba yang tersedia dibawah ini. Apabila tidak muncul, silahkan menghubungi Panitia.</p>
                    <?php if ($pengumuman->isPublic  == 1) : ?>
                        <!-- <p>Pengumuman juara telah tersedia, klik <a href="pengumuman" target="_blank">disini</a> untuk melihat.</p> -->
                        <a href="../pengumuman" class="btn btn-success" target="_blank" style="text-decoration: none;">Lihat Pengumuman</a>
                        <button class="btn btn-success" <?= $currentUser->downloadCert == 0 ? 'data-toggle="modal" data-target="#modal-finalisasi"' : 'id="cert-download"' ?>>Download Sertifikat</button>
                    <?php endif ?>
                </div>
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Daftar Lomba</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="table-tes" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="all">Lomba</th>
                                    <th>Waktu Mulai Tes</th>
                                    <th>Waktu Selesai Tes</th>
                                    <!-- <th>Waktu Mulai mengerjakan - Waktu Selesai mengerjakan</th> -->
                                    <th>Lama Mengerjakan</th>
                                    <th>Score</th>
                                    <th class="all">Action</th>
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

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            <?php endif ?>
        </section><!-- /.content -->
    </div>
</div><!-- /.container -->


<div style="max-height: 100%;overflow-y:auto;" class="modal" id="modal-profile" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">&times;</button>
                <div id="trx-judul">Profil</div>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <div class="box-body">
                        <div id="form-pesan"></div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Email Peserta" value="<?= $currentUser->user_email ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" placeholder="Nama Lengkap Peserta" value="<?= $currentUser->user_firstname ?>" readonly>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12 col-md-6">
                                <label>Asal Sekolah</label>
                                <input type="text" class="form-control" placeholder="Asal Sekolah" value="<?= $currentUser->user_detail ?>" readonly>
                            </div>

                            <div class="form-group col-xs-12 col-md-6">
                                <label>Kelas</label>
                                <input type="text" class="form-control" placeholder="Kelas" value="<?= $currentUser->kelas ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Nomer Telepon (WhatsApp)</label>
                            <input type="text" class="form-control" placeholder="Nomer Telepon" value="<?= $currentUser->telepon ?>" readonly>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Pilihan Lomba</label>
                                <input type="text" class="form-control" placeholder="Lomba" value="<?= $currentUser->lomba == 'all'  ? 'Matematika & Sains' : ucfirst($currentUser->lomba) ?>" readonly>
                            </div>

                            <div class="form-group col-sm-6">
                                <label>Level</label>
                                <input type="text" class="form-control" placeholder="Level" value="<?= $group ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

<?php if (count($willCheck) > 0) : ?>
    <div style="max-height: 100%;overflow-y:auto; display: block;" class="modal" id="modal-optional" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <?php echo form_open($url . '/', 'id="form-optional"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="trx-judul text-center text-bold" style="font-weight: bold; text-align: center">Uppsss ! ada yang lupa</h3>
                    <p class="text-center">Ada yang ketinggalan saat proses pendaftaran, silahkan lengkapi form dibawah untuk melanjutkan</p>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div id="form-pesan-optional"></div>
                            <?php foreach ($willCheck as $check) : ?>
                                <div class="form-group">
                                    <label><?= $check['displayName'] ?></label>
                                    <?php if ($check['type'] == 'kelas') : ?>
                                        <select name="<?= $check['tableName'] ?>" class="form-control input-sm">
                                            <option value="">-- Pilih Kelas (TA. 2019/2020) --</option>
                                            <?php for ($i = 1; $i < 10; $i++) : ?>
                                                <option value="<?= $i ?>" 0>Kelas <?= $i ?></option>
                                            <?php endfor ?>
                                        </select>
                                    <?php elseif ($check['type'] == 'lomba') : ?>
                                        <select name="<?= $check['tableName'] ?>" class="form-control input-sm">
                                            <option value="">-- Pilih Lomba --</option>
                                            <option value="matematika">Matematika</option>
                                            <option value="sains">Sains</option>
                                            <option value="all">Matematika & Sains</option>
                                        </select>
                                    <?php else :  ?>
                                        <input type="text" class="form-control" name="<?= $check['tableName'] ?>" placeholder="<?= $check['displayName'] ?>" autocomplete="off">
                                    <?php endif ?>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php
                    $securedCheck = base64_encode(json_encode($willCheck));
                    ?>
                    <input type="hidden" name="item" value="<?= $item ?>">
                    <textArea name="secureCheck" style="display: none;">
                        <?= $securedCheck ?>
                    </textArea>
                    <button type="submit" id="tambah-simpan" class="btn btn-success">Kirim</button>
                </div>
            </div>
        </div>
        </form>
    </div>
<?php endif ?>

<?php if ($currentUser->downloadCert == 0) : ?>
    <div style="max-height: 100%;overflow-y:auto;" class="modal" id="modal-finalisasi" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <?php echo form_open($url . '/', 'id="form-cert"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <h3 id="trx-judul text-center text-bold" style="font-weight: bold; text-align: center">Finalisasi Data</h3>
                    <p class="text-center">Periksa data dibawah ini, apakah penulisannya sudah benar atau tidak. Jika belum, silahkan koreksi kembali dan jika dikira sudah benar, langsung klik <b>Download</b></p>
                    <p class="text-center">Data dibawah akan mempengaruhi sertifikat nanti.</p>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div id="form-pesan-cert"></div>
                            <div class="row">
                                <div class="form-group col-xs-12 col-md-6">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" placeholder="Nama Lengkap Peserta" value="<?= $currentUser->user_firstname ?>" name="cert-nama" id="cert-nama">
                                </div>

                                <div class="form-group col-xs-12 col-md-6">
                                    <label>Asal Sekolah</label>
                                    <input type="text" class="form-control" placeholder="Asal Sekolah" value="<?= $currentUser->user_detail ?>" name="cert-sekolah" id="cert-sekolah">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <small>Aksi ini hanya berlaku satu kali, tidak bisa diulangi lagi.</small>
                    <!-- <div class="pull-right"> -->
                    <button type="submit" class="btn btn-success">Download</button>
                    <!-- </div> -->
                </div>
            </div>
        </div>
        </form>
    </div>
<?php endif ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script src="<?php echo site_url() . '/'; ?>/public/images/cert/Nickainley-Normal-normal.js"></script>
<script src="<?php echo site_url() . '/'; ?>/public/images/cert/OpenSans-Regular-normal.js"></script>

<script type="text/javascript">
    $(function() {

        $('#table-tes').DataTable({
            'dom': 'ftipr',
            "paging": true,
            "iDisplayLength": 10,
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
                    "bSortable": false,
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
                    "bSortable": false,
                    "sWidth": "130px"
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "50px"
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "30px"
                }
            ],
            "sAjaxSource": "<?php echo site_url() . '/' . $url; ?>/get_datatable/",
            "autoWidth": false,
            "responsive": true
        });

        $('#imagePay').on('click', function() {
            $('#uplaodImgPay').click()
        })

        $('#form-optional').submit(function() {
            $("#modal-proses").modal('show');
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/optional",
                type: "POST",
                data: $('#form-optional').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        $("#modal-proses").modal('hide');
                        $("#modal-optional").modal('hide');
                        $("#modal-optional").remove();
                        Swal.fire({
                            title: 'Berhasil !',
                            text: obj.error,
                            icon: 'success'
                        }).then(() => {
                            window.location.reload()
                        })
                    } else {
                        $("#modal-proses").modal('hide');
                        $('#form-pesan-optional').html(pesan_err(obj.error));
                    }
                }
            });
            return false;
        });

        $('#form-pay').submit(function() {
            $("#modal-proses").modal('show');
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/pay",
                type: "POST",
                data: $('#form-pay').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        $("#modal-proses").modal('hide');
                        Swal.fire({
                            title: 'Berhasil !',
                            text: obj.pesan,
                            icon: 'success'
                        }).then(() => {
                            window.location.reload()
                        })
                    } else {
                        $("#modal-proses").modal('hide');
                        $('#form-pesan-pay').html(pesan_err(obj.pesan));
                        $('html, body').animate({
                            scrollTop: 0
                        })
                    }
                }
            });
            return false;
        });

        $('#form-cert').submit(function() {
            $("#modal-proses").modal('show');
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/cert_save",
                type: "POST",
                data: $('#form-cert').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        let nama = $('#cert-nama').val()
                        let sekolah = $('#cert-sekolah').val()
                        $("#modal-proses").modal('hide');
                        $("#modal-finalisasi").modal('hide');
                        $("#modal-finalisasi").remove();
                        Swal.fire({
                            title: 'Berhasil !',
                            text: obj.pesan,
                            icon: 'success'
                        }).then(() => {
                            generate_cert({
                                nama,
                                sekolah
                            })
                        })
                    } else {
                        $("#modal-proses").modal('hide');
                        $('#form-pesan-cert').html(pesan_err(obj.error));
                    }
                }
            });
            return false;
        });

        $('#cert-download').on('click', function() {
            generate_cert({
                nama: '<?= $currentUser->user_firstname ?>',
                sekolah: '<?= $currentUser->user_detail ?>',
            })
        })
    });


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imagePay').attr('src', e.target.result);
                $('#uploadImgPayText').val(e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#uplaodImgPay").change(function() {
        loadImageFile()
    });

    var fileReader = new FileReader();
    var filterType = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;

    fileReader.onload = function(event) {
        var image = new Image();

        image.onload = function() {
            // document.getElementById("original-Img").src = image.src;
            var canvas = document.createElement("canvas");
            var context = canvas.getContext("2d");
            canvas.width = image.width / 2;
            canvas.height = image.height / 2;
            context.drawImage(image,
                0,
                0,
                image.width,
                image.height,
                0,
                0,
                canvas.width,
                canvas.height
            );

            document.getElementById("imagePay").src = canvas.toDataURL();
            $('#uploadImgPayText').val(canvas.toDataURL());

        }
        image.src = event.target.result;
    };

    var loadImageFile = function() {
        var uploadImage = document.getElementById("uplaodImgPay");

        //check and retuns the length of uploded file.
        if (uploadImage.files.length === 0) {
            return;
        }

        //Is Used for validate a valid file.
        var uploadFile = document.getElementById("uplaodImgPay").files[0];
        if (!filterType.test(uploadFile.type)) {
            Swal.fire({
                title: 'Peringatan !',
                text: 'Pilih gambar dengan format JPG atau PNG',
                icon: 'error'
            });
            return;
        }

        fileReader.readAsDataURL(uploadFile);
    }

    function generate_cert(data = {}) {

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

        const toTitleCase = (phrase) => {
            return phrase
                .toLowerCase()
                .split(' ')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');
        };

        loadImage("<?php echo site_url() . '/'; ?>/public/images/cert/EDIT-CERT-TEMPLATE.png").then((logo) => {
            // const doc = new jsPDF("p", "mm", "a4");
            let width = doc.internal.pageSize.getWidth();
            let height = doc.internal.pageSize.getHeight();

            let halfWidth = width / 2
            let halfHeight = height / 2

            doc.addImage(logo, "PNG", 0, 0, width, height);

            doc.setFont('Nickainley-Normal');
            doc.setFontSize(55)
            let textNama = data.nama;
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

            let textSekolah = data.sekolah;

            doc.text(textNama, halfWidth, halfHeight + 5, 'center')

            doc.setFont('OpenSans-Regular');
            doc.setFontSize(19)
            doc.text(textSekolah, halfWidth, halfHeight + 20, 'center')

            doc.save('QEC Certificate', {
                returnPromise: true
            }).then(() => {
                window.location.reload()

            })

        });
    }
</script>