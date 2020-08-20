<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Daftar Menu User
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
                        <div class="card-title">Data Menu</div>
                        <div class="card-tools">
                            <a class="btn btn-sm btn-primary" href="<?php echo current_url(); ?>/index/add">Tambah Menu</a>
                        </div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <table id="table-menu" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tipe</th>
                                    <th>Parent</th>
                                    <th>Kode Menu</th>
                                    <th>Nama Menu</th>
                                    <th>URL</th>
                                    <th>Icon</th>
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
        $('#table-menu').DataTable({
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
                    "sWidth": "150px"
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
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "30px"
                }
            ],
            "sAjaxSource": "<?php echo current_url(); ?>/get_all_menu/",
            "autoWidth": false,
            'fnDrawCallback': function(oSettings) {
                NP.d()
                callBackDatatable(oSettings)
            },
            fnPreDrawCallback: function() {
                NP.s()
            }
        });
    });
</script>