<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Mengimport Soal
        </h1>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?php echo form_open_multipart($url . '/import', 'id="form-importsoal"'); ?>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Pilih Topik</div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="form-group">
                            <label>Pilih Topik</label>
                            <select name="topik" id="topik" class="form-control input-sm">
                                <?php if (!empty($select_topik)) {
                                    echo $select_topik;
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Pilih terlebih dahulu Topik yang akan digunakan sebelum melakukan import soal</small>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Import Soal</div>
                    </div>

                    <div class="card-body">
                        <span id="form-pesan"></span>
                        <div class="form-group">
                            <label>Pilih File</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" id="userfile" name="userfile">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>

                            <p class="help-block">Soal yang dapat import adalah soal jenis Pilihan ganda. Tidak dapat melakukan import soal yang terdapat gambar atau audio.</p>
                            <p class="help-block">File Excel yang didukung adalah Microsoft Excel 2003 dan Microsoft Excel 2007</p>
                            <p class="help-block">SAVE AS ke Office 2007 jika gagal mengupload data dalam format Office 2003</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row d-flex" style="justify-content: space-between;">
                            <a href="<?php echo base_url(); ?>public/form/form-soal-ganda.xls" class="btn btn-sm btn-default">Form Excel Soal Pilihan Ganda</a>
                            <button type="submit" class="btn btn-primary pull-right" id="import">Import</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</section><!-- /.content -->

<script lang="javascript">
    function batal_tambah() {
        $("#form-pesan").html('');
        $('#userfile').val('');
    }

    $(function() {
        $('#topik').select2();

        /**
         * Submit form tambah soal
         */
        $('#form-importsoal').submit(function() {
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
                        batal_tambah();
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
        });

        $(document).ready(function() {

        });
    });
</script>