<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Daftar Soal
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
                        <div class="card-title">Pilih Topik</div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="form-group">
                            <label>Pilih Topik</label>
                            <div id="data-kelas">
                                <select name="topik" id="topik" class="form-control input-sm">
                                    <?php if (!empty($select_topik)) {
                                        echo $select_topik;
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Pilih terlebih dahulu Topik yang akan digunakan sebelum menambah atau mengubah soal</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Daftar Soal <span id="judul-daftar-soal"></span></div>
                        <div class="card-tools pull-right">
                            <div class="dropdown pull-right">
                                <a style="cursor: pointer;" onclick="cetak_soal()" class="btn btn-sm btn-primary text-white">Cetak Daftar Soal</a>
                            </div>
                        </div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <table id="table-soal" class="table">
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
</section>

<div class="modal" id="modal-tambah" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url . '/tambah', 'id="form-tambah"'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">&times;</button>
                <div id="trx-judul">Tambah Topik</div>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <div class="card-body">
                        <div id="form-pesan"></div>
                        <div class="form-group">
                            <label>Nama Topik</label>
                            <input type="hidden" name="tambah-modul-id" id="tambah-modul-id">
                            <input type="text" class="form-control" id="tambah-topik" name="tambah-topik" placeholder="Nama Topik">
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <input type="text" class="form-control" id="tambah-deskripsi" name="tambah-deskripsi" placeholder="Deskripsi Topik">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" class="form-control" id="tambah-status" name="tambah-status" value="AKTIF" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="tambah-simpan" class="btn btn-primary">Tambah</button>
                <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>

    </form>
</div>

<div class="modal" id="modal-edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url . '/edit', 'id="form-edit"'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">&times;</button>
                <div id="trx-judul">Edit Topik</div>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <div class="card-body">
                        <div id="form-pesan-edit"></div>
                        <div class="form-group">
                            <label>Nama Topik</label>
                            <input type="hidden" name="edit-id" id="edit-id">
                            <input type="hidden" name="edit-pilihan" id="edit-pilihan">
                            <input type="hidden" name="edit-topik-asli" id="edit-topik-asli">
                            <input type="text" class="form-control" id="edit-topik" name="edit-topik" placeholder="Nama Topik">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <input type="text" class="form-control" id="edit-deskripsi" name="edit-deskripsi" placeholder="Deskripsi Topik">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" class="form-control" id="edit-status" name="edit-status" value="AKTIF" readonly>
                        </div>
                        <p>NB : Topik yang dihapus, maka semua bank soal akan ikut terhapus !</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="edit-hapus" class="btn btn-default pull-left">Hapus</button>
                <button type="button" id="edit-simpan" class="btn btn-primary">Simpan</button>
                <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>

    </form>
</div>

<script lang="javascript">
    function refresh_table() {
        $('#table-soal').dataTable().fnReloadAjax();
    }

    function cetak_soal() {
        var topik_id = $('#topik').val();

        window.open('<?php site_url(); ?>modul_daftar/cetak_soal/' + topik_id, '_blank');
    }

    function refresh_topik() {
        var judul = $('#topik option:selected').text();
        $('#judul-daftar-soal').html(judul);
    }

    $(function() {
        $('#topik').select2();

        $("#topik").change(function() {
            refresh_table();
            refresh_topik();
        });

        $('#form-tambah').submit(function() {
            $('#tambah-modul-id').val($('#modul').val());
            $("#modal-proses").modal('show');
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/tambah",
                type: "POST",
                data: $('#form-tambah').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        refresh_table();
                        $("#modal-proses").modal('hide');
                        $("#modal-tambah").modal('hide');
                        notify_success(obj.pesan);
                    } else {
                        $("#modal-proses").modal('hide');
                        $('#form-pesan').html(pesan_err(obj.pesan));
                    }
                }
            });
            return false;
        });

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
                    "name": "topik",
                    "value": $('#topik').val()
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
            refresh_topik();
        });
    });
</script>