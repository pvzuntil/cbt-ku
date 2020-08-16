<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Edit Menu
        </h1>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?php echo form_open('manager/usermenu/edit', 'id="form-edit-menu" class="form-horizontal"') ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title">Edit Menu</h3>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="control-label">Tipe Menu</label>
                                    <input type="hidden" class="form-control input-sm" value="<?php if (!empty($id)) {
                                                                                                    echo $id;
                                                                                                } ?>" id="id" name="id" readonly>
                                    <input type="hidden" class="form-control input-sm" id="aksi" name="aksi" readonly>
                                    <input type="text" class="form-control input-sm" value="<?php if (!empty($tipe)) {
                                                                                                echo $tipe;
                                                                                            } ?>" id="tipe" name="tipe" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Parent Menu</label>
                                    <input type="text" class="form-control input-sm" value="<?php if (!empty($parent)) {
                                                                                                echo $parent;
                                                                                            } ?>" id="parent" name="parent" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Kode Menu</label>
                                    <input type="text" class="form-control input-sm" value="<?php if (!empty($kode)) {
                                                                                                echo $kode;
                                                                                            } ?>" id="kode" name="kode" placeholder="Kode Menu" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="control-label">Nama Menu</label>
                                    <input type="text" class="form-control input-sm" value="<?php if (!empty($nama_menu)) {
                                                                                                echo $nama_menu;
                                                                                            } ?>" id="nama" name="nama" placeholder="Nama Menu">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">URL Menu</label>
                                    <input type="text" class="form-control input-sm" id="url" name="url" value="<?php if (!empty($url)) {
                                                                                                                    echo $url;
                                                                                                                } ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Icon Menu</label>
                                    <input type="text" class="form-control input-sm" id="icon" name="icon" value="<?php if (!empty($icon)) {
                                                                                                                        echo $icon;
                                                                                                                    } ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Urutan Menu</label>
                                    <input type="text" class="form-control input-sm" id="urutan" name="urutan" value="<?php if (!empty($urutan)) {
                                                                                                                            echo $urutan;
                                                                                                                        } ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row d-flex" style="justify-content: space-between;">
                            <button type="button" id="hapus" class="btn btn-danger btn-sm">Hapus</button>
                            <button type="button" id="simpan" class="btn btn-info btn-sm">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</section><!-- /.content -->

<script lang="javascript">
    $(function() {
        $('#simpan').click(function() {
            SW.loading()
            $('#aksi').val('1');
            $('#form-edit-menu').submit();
        });
        $('#hapus').click(function() {
            SW.loading()
            $('#aksi').val('0');
            $('#form-edit-menu').submit();
        });

        $('#form-edit-menu').submit(function() {
            $.ajax({
                url: "<?php echo site_url(); ?>/manager/usermenu/edit",
                type: "POST",
                data: $('#form-edit-menu').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        SW.toast({
                            title: obj.pesan,
                            icon: 'success'
                        })
                        setTimeout(function() {
                            window.open("<?php echo site_url(); ?>/manager/usermenu", "_self");
                        }, 1000);
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
    });
</script>