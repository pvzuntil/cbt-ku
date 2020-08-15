<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Edit User
        </h1>
    </div>
</section>

<!-- Main content -->
<section class="content">

    <div class="container-fluid">
        <?php echo form_open('manager/useratur/edit', 'id="form-edit-user" class="form-horizontal"') ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title">Edit User</h3>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div id="form-pesan"></div>
                                <div class="form-group">
                                    <label class="control-label">Username</label>
                                    <input type="hidden" id="aksi" name="aksi" />
                                    <input type="text" class="form-control input-sm" value="<?php if (!empty($username)) {
                                                                                                echo $username;
                                                                                            } ?>" id="username" name="username" placeholder="Username" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Password</label>
                                    <input type="password" class="form-control input-sm" value="kosongkosong" id="password" name="password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Level</label>
                                    <?php
                                    if (!empty($level_opsi)) {
                                        echo $level_opsi;
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">

                                <div class="form-group">
                                    <label class="control-label">Nama</label>
                                    <input type="text" class="form-control input-sm" value="<?php if (!empty($nama_lengkap)) {
                                                                                                echo $nama_lengkap;
                                                                                            } ?>" id="nama" name="nama" placeholder="Nama Pengguna">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Opsi 1</label>
                                    <!-- <div class="input-group input-group-sm">
                                        <input type="text" class="form-control input-sm" value="<?php if (!empty($opsi1)) {
                                                                                                    echo $opsi1;
                                                                                                } ?>" id="opsi1" name="opsi1" placeholder="Daftar Topik yang dikelola user" readonly>
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-flat" type="button" id="btn-topik">Daftar Topik</button>
                                            <button class="btn btn-default btn-flat" type="button" id="btn-topik-hapus">Hapus</button>
                                        </span>
                                    </div> -->


                                    <div class="input-group">
                                        <input type="text" class="form-control" id="opsi1" name="opsi1" placeholder="Daftar Topik yang dikelola user" readonly="" value="<?php if (!empty($opsi1)) {
                                                                                                                                                                                echo $opsi1;
                                                                                                                                                                            } ?>">
                                        <div class="input-group-append" id="button-addon4">
                                            <button class="btn btn-outline-primary" id="btn-topik" type="button">Daftar Topik</button>
                                            <button class="btn btn-outline-danger" type="button" id="btn-topik-hapus">Hapus</button>
                                        </div>
                                    </div>
                                    <small class="text-muted">Jika kosong, maka user dapat mengelola soal semua topik.</small>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Opsi 2</label>
                                    <input type="text" class="form-control input-sm" value="<?php if (!empty($opsi2)) {
                                                                                                echo $opsi2;
                                                                                            } ?>" id="opsi2" name="opsi2" placeholder="Opsi 2">
                                </div>
                            </div>
                            <div class="col-12">

                                <div class="form-group">
                                    <label class="control-label">Keterangan</label>
                                    <input type="text" class="form-control input-sm" value="<?php if (!empty($keterangan)) {
                                                                                                echo $keterangan;
                                                                                            } ?>" id="keterangan" name="keterangan" placeholder="Keterangan">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row d-flex" style="justify-content: space-between;">
                            <button type="button" id="hapus" class="btn btn-sm btn-danger">Hapus</button>
                            <button type="button" id="simpan" class="btn btn-sm btn-info">Simpan</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?= form_close() ?>
    </div>
</section>

<div class="modal fade" id="modal-topik" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Pilih Topik</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="form-pesan-topik"></div>
                <div class="form-group">
                    <label class="control-label">Pilih Modul</label>
                    <select class="form-control input-sm" name="topik-modul" id="topik-modul">
                        <?php
                        if (!empty($select_modul)) {
                            echo $select_modul;
                        }
                        ?>
                    </select>
                </div>
                <table id="table-topik" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th class="all">Topik</th>
                            <th>Deskripsi</th>
                            <th class="all"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

<script lang="javascript">
    function refresh_table() {
        $('#table-topik').dataTable().fnReloadAjax();
    }

    function tambah_topik(topik_id, topik_nama) {
        var daftar_topik = $('#opsi1').val();
        if (daftar_topik.length > 0) {
            var array_topik = daftar_topik.split(','),
                i;
            var counter = 0;
            for (i = 0; i < array_topik.length; i++) {
                if (topik_id == array_topik[i]) {
                    counter++;
                }
            }
            if (counter > 0) {
                SW.toast({
                    title: 'Topik ' + topik_nama + ' sudah berada di Opsi1',
                    icon: 'error'
                });
            } else {
                daftar_topik = daftar_topik + "," + topik_id;
                $('#opsi1').val(daftar_topik);
                SW.toast({
                    title: 'Topik ' + topik_nama + ' berhasil ditambahkan',
                    icon: 'success'
                });
            }
        } else {
            daftar_topik = topik_id;
            $('#opsi1').val(daftar_topik);
            SW.toast({
                title: 'Topik ' + topik_nama + ' berhasil ditambahkan',
                icon: 'success'
            });
        }
    }
    $(function() {
        $('#btn-topik-hapus').click(function() {
            $('#opsi1').val('');
        });
        $('#btn-topik').click(function() {
            $("#modal-topik").modal('show');
        });
        // memilih topik berdasarkan modul
        $("#topik-modul").change(function() {
            refresh_table();
        });

        $('#simpan').click(function() {
            SW.loading()
            $('#aksi').val('1');
            $('#form-edit-user').submit();
        });
        $('#hapus').click(function() {
            SW.loading()
            $('#aksi').val('0');
            $('#form-edit-user').submit();
        });

        $('#form-edit-user').submit(function() {
            $.ajax({
                url: "<?php echo site_url(); ?>/manager/useratur/edit",
                type: "POST",
                data: $('#form-edit-user').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        SW.toast({
                            title: obj.pesan,
                            icon: 'success'
                        })
                        setTimeout(function() {
                            window.open("<?php echo site_url(); ?>/manager/useratur", "_self");
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

        $('#table-topik').DataTable({
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
            "sAjaxSource": "<?php echo site_url() . '/' . $url; ?>/get_datatable_topik/",
            "autoWidth": false,
            "fnServerParams": function(aoData) {
                aoData.push({
                    "name": "modul",
                    "value": $('#topik-modul').val()
                });
            },
            'fnDrawCallback': function() {
                callBackDatatable('#table-topik')
            }
        });
    });
</script>