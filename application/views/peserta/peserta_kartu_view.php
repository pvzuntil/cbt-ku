<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Cetak Kartu Peserta
        </h1>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info">
                    <h4>Informasi</h4>
                    <p>Lakukan Pengaturan nama pelaksana sebelum mencetak kartu peserta agar kartu sesuai dengan Organisasi tempat anda melaksanakan Tes.</p>
                    <p>Pastikan terlebih dahulu data Group dan data Peserta sudah ter-upload.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php echo form_open($url . '/kartu', 'id="form-kartu"'); ?>
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Cetak Kartu Peserta</div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="form-group col-sm-6">
                            <label>Pilih Kelas</label>
                            <div id="data-group">
                                <select name="group" id="group" class="form-control input-sm">
                                    <?php if (!empty($select_group)) {
                                        echo $select_group;
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <?php if (!empty($hasil)) {
                            echo $hasil;
                        } ?>
                    </div>

                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" id="kartu">Cetak kartu</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section><!-- /.content -->

<script lang="javascript">
    $(function() {
        $('#kartu').click(function() {
            var grup_id = $('#group').val();
            window.open("<?php echo site_url() . '/' . $url; ?>/cetak_kartu/" + grup_id);
        });
    });
</script>