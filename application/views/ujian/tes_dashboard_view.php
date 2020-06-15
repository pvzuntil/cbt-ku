<div class="container">
    <!-- Content Header (Page header) -->
    <div class="box shadow-box" style="margin-top: 20px;">
        <section class="content-header">
            <h1>
                <?php if (!empty($nama)) {
                    echo $nama;
                }
                if (!empty($group)) {
                    echo ' | ' . $group;
                } ?>
                <small></small>
            </h1>
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
                        notify_success(obj.error);
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
</script>