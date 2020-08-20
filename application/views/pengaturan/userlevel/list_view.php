<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Level User
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
                        <div class="card-title">Data Level</div>
                        <div class="card-tools">
                            <a class="btn btn-sm btn-primary" href="<?php echo current_url(); ?>/index/add">Tambah Level</a>
                        </div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <table id="table-level" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Level</th>
                                    <th>Keterangan</th>
                                    <th>Hak Akses</th>
                                    <th>Action</th>
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
</section><!-- /.content -->

<script lang="javascript">
    $(function() {
        $('#table-level').DataTable({
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
                    "sWidth": "40px"
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "130px"
                },
                {
                    "bSearchable": false,
                    "bSortable": false
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "30px"
                }
            ],
            "sAjaxSource": "<?php echo current_url(); ?>/get_all_level/",
            "autoWidth": false,
            'fnDrawCallback': function(oSettings) {
                SW.close()
                callBackDatatable(oSettings)
            },
            fnPreDrawCallback: function() {
                SW.loading()
            }
        });
    });
</script>