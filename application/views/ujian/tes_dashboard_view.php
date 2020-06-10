<div class="container">
    <!-- Content Header (Page header) -->
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
        <div class="callout callout-info">
            <h4>Informasi</h4>
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
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
                            <th>Status</th>
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
    </section><!-- /.content -->
</div><!-- /.container -->

<?php if ($telepon == '' || $telepon == null) : ?>
    <div style="max-height: 100%;overflow-y:auto; display: block;" class="modal" id="modal-optional" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <?php echo form_open($url . '/', 'id="form-optional"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="trx-judul text-center text-bold" style="font-weight: bold; text-align: center">Uppsss ! ada yang lupa</h3>
                    <p class="text-center">Anda belum mencantumkan nomer telepon (WhatsApp) saat mendaftar</p>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div id="form-pesan-optional"></div>
                            <div class="form-group">
                                <label>Nomer Telepon (WhatsApp)</label>
                                <input type="text" class="form-control" name="telepon" placeholder="Nomer telepon" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
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
                    "bSortable": false
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
                    "sWidth": "100px"
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
    });
</script>