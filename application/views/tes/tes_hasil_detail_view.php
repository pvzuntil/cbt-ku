<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Hasil Tes Detail
        </h1>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Informasi</div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Nama User</label>
                                    <input type="text" name="user-nama" id="user-nama" class="form-control input-sm" value="<?php if (!empty($user_nama)) {
                                                                                                                                echo $user_nama;
                                                                                                                            } ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="control-label">Nama Tes</label>
                                    <input type="hidden" name="tes-user-id" id="tes-user-id" value="<?php if (!empty($tes_user_id)) {
                                                                                                        echo $tes_user_id;
                                                                                                    } ?>">
                                    <input type="text" name="tes-nama" id="tes-nama" class="form-control input-sm" value="<?php if (!empty($tes_nama)) {
                                                                                                                                echo $tes_nama;
                                                                                                                            } ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Nilai</label>
                                    <input type="text" name="tes-nilai" id="tes-nilai" class="form-control input-sm" value="<?php if (!empty($nilai)) {
                                                                                                                                echo $nilai;
                                                                                                                            } ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="control-label">Waktu Tes Mulai</label>
                                    <input type="text" name="tes-mulai" id="tes-mulai" class="form-control input-sm" value="<?php if (!empty($tes_mulai)) {
                                                                                                                                echo $tes_mulai;
                                                                                                                            } ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Benar</label>
                                    <input type="text" name="tes-benar" id="tes-benar" class="form-control input-sm" value="<?php if (!empty($benar)) {
                                                                                                                                echo $benar;
                                                                                                                            } ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Soal dan Jawaban</div>
                        <div class="card-tools pull-right">
                            <button class="btn bt-sm btn-default" href="#" onclick="refresh_table()">Refresh Detail Tes</span></button>
                        </div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <table id="table-soal" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tipe Soal</th>
                                    <th>Soal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
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

</section><!-- /.content -->



<script lang="javascript">
    function refresh_table() {
        $('#table-soal').dataTable().fnReloadAjax();
    }

    $(function() {
        $('#table-soal').DataTable({
            "paging": true,
            "iDisplayLength": 10,
            "bProcessing": false,
            "bServerSide": true,
            "searching": true,
            "aoColumns": [{
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "20px"
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "80px"
                },
                {
                    "bSearchable": false,
                    "bSortable": false
                }
            ],
            "sAjaxSource": "<?php echo site_url() . '/' . $url; ?>/get_datatable/",
            "autoWidth": false,
            "fnServerParams": function(aoData) {
                aoData.push({
                    "name": "tes_user_id",
                    "value": $('#tes-user-id').val()
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

        $(document).ready(function() {

        });
    });
</script>