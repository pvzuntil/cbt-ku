<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Import Data Peserta
            <small>Penambahan data melalui Import data dari file Excel</small>
        </h1>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="callout callout-info">
                    <h4>Informasi</h4>
                    <p>Data siswa yang di import adalah data yang akan digunakan siswa untuk memulai tes atau ujian. Form data siswa dapat di Download di menu Download yang ada di pojok kanan kotak dialog.</p>
                    <p>Pastikan terlebih dahulu data Kelas dan Pelajaran sudah dipilih dengan baik dan benar, sebelum melakukan Import Data.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Pilih Opsi</div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="form-group">
                            <label>Pilih kelas</label>
                            <select name="kelas" id="kelas" class="form-control input-sm" form="form-importsiswa">
                                <?php if (!empty($select_kelas)) : ?>
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php foreach ($select_kelas as $i) : ?>
                                        <option value="<?= $i ?>">Kelas <?= $i ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Pilih Pelajaran</label>
                            <select name="pelajaran[]" id="pelajaran" multiple class="form-control select2 custom-select" autocomplete="off" placeholder="Pilih Pelajaran" style="width: 100%;" form="form-importsiswa">
                                <?= $select_lomba ?>
                            </select>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="all-pelajaran">
                                <label class="form-check-label" for="all-pelajaran">
                                    Pilih Semua Pelajaran
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <?php echo form_open_multipart($url . '/import', 'id="form-importsiswa"'); ?>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Import Peserta</div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <label>
                            <?php if (!empty($error_upload)) {
                                echo $error_upload;
                            } ?>
                            <?php if (!empty($filename)) {
                                echo $filename;
                            } ?>
                        </label>
                        <span id="form-pesan">
                            <?php if (!empty($error)) {
                                echo $error;
                            } ?>
                        </span>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="userfile" aria-describedby="userfile" name="userfile">
                                    <label class="custom-file-label" for="userfile" id="userfileLabel">Choose file</label>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($hasil)) {
                            echo $hasil;
                        } ?>
                    </div>

                    <div class="card-footer">
                        <div class="row d-flex" style="justify-content: space-between;">
                            <a href="<?php echo base_url(); ?>public/form/form-data-siswa.xls" class="btn btn-sm btn-default">Download Form Import Siswa</a>
                            <button type="submit" class="btn btn-primary btn-sm" id="import">Import</button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section><!-- /.content -->



<script lang="javascript">
    $(function() {
        $('#userfile').change((e) => {
            let fileName = e.target.files[0].name
            $('#userfileLabel').html(fileName)
        })

        $("#all-pelajaran").change(function() {
            if ($("#all-pelajaran").is(':checked')) {
                $('#pelajaran').select2('destroy').find('option').prop('selected', 'selected').end().select2();
            } else {
                $('#pelajaran').select2('destroy').find('option').prop('selected', false).end().select2();
            }
        });

        $('#form-importsiswa').submit(function() {
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/import",
                type: "POST",
                timeout: 300000,
                data: new FormData(this),
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        SW.close()
                        SW.show({
                            title: 'Informasi !',
                            html: obj.pesan,
                            icon: 'success'
                        }).then(() => {
                            window.location.reload()
                        })
                    } else {
                        SW.toast({
                            title: obj.pesan,
                            icon: 'error'
                        })
                    }
                },
                statusCode: {
                    500: function(respon) {
                        SW.toast({
                            title: 'Terjadi kesalahan pada File yang di Upload. Silahkan cek terlebih dahulu file yang anda upload.',
                            icon: 'error'
                        })
                    }
                },
                error: function(xmlhttprequest, textstatus, message) {
                    if (textstatus === "timeout") {
                        SW.toast({
                            title: "Gagal mengimport Soal, Silahkan Refresh Halaman",
                            icon: 'error'
                        })
                    } else {
                        SW.toast({
                            title: textstatus,
                            icon: 'info'
                        })
                    }
                }
            });
            return false;
        })
    });
</script>