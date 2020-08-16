<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Tambah Menu
        </h1>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?php echo form_open('manager/usermenu/add', 'id="form-tambah-menu" class="form-horizontal"') ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title">Tambah Menu</h3>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div id="form-pesan"></div>
                                <div class="form-group">
                                    <label class="control-label">Tipe Menu</label>
                                    <select name="tipe" id="tipe" class="form-control input-sm">
                                        <option value="1">Child</option>
                                        <option value="0">Parent</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Parent Menu</label>
                                    <?php
                                    if (!empty($parent)) {
                                        echo $parent;
                                    }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Kode Menu</label>
                                    <input type="text" class="form-control input-sm" id="kode" name="kode" placeholder="Kode Menu">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Nama Menu</label>
                                    <input type="text" class="form-control input-sm" id="nama" name="nama" placeholder="Nama Menu">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">URL Menu</label>
                                    <input type="text" class="form-control input-sm" id="url" name="url" value="#">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Icon Menu</label>
                                    <input type="text" class="form-control input-sm" id="icon" name="icon" value="fa fa-circle-o">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Urutan Menu</label>
                                    <input type="text" class="form-control input-sm" id="urutan" name="urutan" placeholder="Urutan Menu">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" id="btn-simpan" class="btn btn-info pull-right">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</section><!-- /.content -->

<script lang="javascript">
    $(function() {
        $('#tipe').change(function() {
            if ($('#tipe').val() == 0) {
                $('#parent').attr('disabled', 'disabled');
            } else {
                $('#parent').removeAttr('disabled');
            }
        });

        $('#form-tambah-menu').submit(function() {
            SW.loading()
            $.ajax({
                url: "<?php echo site_url(); ?>/manager/usermenu/add",
                type: "POST",
                data: $('#form-tambah-menu').serialize(),
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