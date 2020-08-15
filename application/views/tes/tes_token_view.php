<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Token
        </h1>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php echo form_open($url . '/token', 'id="form-token"'); ?>
                <div class="callout callout-info">
                    <h4>Perhatian</h4>
                    <p>Silahkan klik Generate Token untuk mendapatkan token yang akan diberikan ke user. Masa aktif Token berlaku selama satu hari.</p>
                </div>
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Generate Token</div>
                        <div class="card-tools">
                            <a style="cursor: pointer;" onclick="manual()" class="btn btn-sm btn-default">Token Tes Manual</a>
                        </div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fas fa-barcode"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Token Tes</span>
                                        <h4 class="info-box-number" id="isi-token">0</h4>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="form-group">
                                    <label class="control-label">Masa Aktif</label>
                                    <select class="form-control input-sm" id="token-aktif" name="token-aktif">
                                        <option value="1">1 Hari</option>
                                        <option value="5">5 menit</option>
                                        <option value="15">15 menit</option>
                                        <option value="30">30 menit</option>
                                        <option value="60">1 Jam</option>
                                        <option value="120">2 Jam</option>
                                        <option value="240">4 Jam</option>
                                    </select>
                                    <small class="text-muted">Masa Aktif Token</small>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Daftar Tes</label>
                                    <select class="form-control input-sm" id="token-tes" name="token-tes">
                                        <?php if (!empty($select_tes)) {
                                            echo $select_tes;
                                        } ?>
                                    </select>
                                    <small class="text-muted">Token dapat digunakan secara spesifik untuk suatu TES atau semua TES.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex" style="justify-content: flex-end;">
                        <button type="submit" class="btn btn-primary btn-sm" id="import">Generate Token</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Daftar Token Hari Ini</div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <table id="table-token" class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="all">No.</th>
                                    <th class="all">Token</th>
                                    <th>Waktu Generate</th>
                                    <th>Masa Aktif</th>
                                    <th>Tes</th>
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
</section>

<div class="modal fade" id="modal-token-manual" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url . '/token_manual', 'id="form-token-manual"'); ?>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Token Tes Manual</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="form-pesan-manual"></div>
                <div class="form-group">
                    <label>Token Tes</label>
                    <input type="text" class="form-control" id="manual-token" name="manual-token" placeholder="Token Tes">
                    <small class="text-muted">Pastika Token Tes Manual belum pernah digunakan pada hari yang sama.</small>
                </div>

                <div class="form-group">
                    <label>Masa Aktif</label>
                    <select class="form-control input-sm" id="manual-aktif" name="manual-aktif">
                        <option value="1">1 Hari</option>
                        <option value="5">5 menit</option>
                        <option value="15">15 menit</option>
                        <option value="30">30 menit</option>
                        <option value="60">1 Jam</option>
                        <option value="120">2 Jam</option>
                        <option value="240">4 Jam</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Daftar Tes</label>
                    <select class="form-control input-sm" id="manual-tes" name="manual-tes">
                        <?php if (!empty($select_tes)) {
                            echo $select_tes;
                        } ?>
                    </select>
                    <small class="text-muted">Token dapat digunakan secara spesifik untuk suatu TES atau semua TES.</small>
                </div>
            </div>
            <div class="modal-footer d-flex" style="justify-content: space-between;">
                <button type="submit" id="tambah-simpan" class="btn btn-primary">Simpan</button>
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>

    </form>
</div>



<script lang="javascript">
    function refresh_table() {
        $('#table-token').dataTable().fnReloadAjax();
    }

    function manual() {
        $('#form-pesan-manual').html('');
        $('#manual-token').val('');

        $("#modal-token-manual").modal("show");
        $('#manual-token').focus();
    }

    $(function() {
        $('#form-token').submit(function() {
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/token",
                type: "POST",
                data: $('#form-token').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        $("#isi-token").html(obj.token);
                        SW.toast({
                            title: obj.pesan,
                            icon: 'success'
                        })
                        refresh_table();
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

        $('#form-token-manual').submit(function() {
            SW.loading()
            var isi_token = $('#manual-token').val();
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/token_manual",
                type: "POST",
                data: $('#form-token-manual').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        SW.toast({
                            title: obj.pesan,
                            icon: 'success'
                        })
                        refresh_table();
                        $("#isi-token").html(isi_token);
                        $("#modal-token-manual").modal('hide');
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

        $('#table-token').DataTable({
            "paging": true,
            "iDisplayLength": 10,
            "bProcessing": false,
            "bServerSide": true,
            "searching": true,
            "responsive": true,
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
                    "bSortable": false
                },
                {
                    "bSearchable": false,
                    "bSortable": false
                },
                {
                    "bSearchable": false,
                    "bSortable": false
                }
            ],
            "sAjaxSource": "<?php echo site_url() . '/' . $url; ?>/get_datatable/",
            "autoWidth": false,
            'fnDrawCallback': function() {
                callBackDatatable('#table-token')
            }
        });
    });
</script>