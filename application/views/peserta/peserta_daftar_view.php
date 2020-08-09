<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Peserta
        </h1>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Pilih Group</div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-xs-12">
                                <label>Level</label>
                                <div id="data-level">
                                    <select name="level" id="level" class="form-control input-sm">
                                        <option value="semua">Semua level</option>
                                        <?php if (!empty($select_group)) {
                                            echo $select_group;
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-6 col-xs-12">
                                <label>Kelas</label>
                                <div id="data-kelas">
                                    <select name="kelas" id="kelas" class="form-control input-sm">
                                        <option value="semua">Semua kelas</option>
                                        <?php for ($i = 1; $i <= 9; $i++) : ?>
                                            <option value="<?= $i ?>">Kelas <?= $i ?></option>
                                        <?php endfor ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Daftar Peserta</div>
                        <div class="card-tools pull-right">
                            <a style="cursor: pointer;" onclick="export_excel()" class="btn btn-primary btn-sm text-white">Eksport Data</a>
                            <a style="cursor: pointer;" onclick="tambah()" class="btn btn-success btn-sm text-white">Tambah Peserta</a>
                        </div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <?php echo form_open($url . '/hapus_daftar_siswa', 'id="form-hapus"'); ?>
                        <input type="hidden" name="check" id="check" value="0">
                        <table id="table-peserta" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="all">Nama</th>
                                    <th>Kelompok</th>
                                    <th>Kelas</th>
                                    <th>Pilihan Lomba</th>
                                    <th>Asal Sekolah</th>
                                    <th>Status</th>
                                    <th class="all">Action</th>
                                    <th class="all"></th>
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
                                    <td> </td>
                                </tr>
                            </tbody>
                        </table>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="row d-flex" style="justify-content: space-between;">
                            <button type="button" id="btn-edit-hapus" class="btn btn-danger" title="Hapus Siswa yang dipilih">Hapus</button>
                            <button type="button" id="btn-edit-pilih" class="btn btn-default">Pilih Semua</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div style="overflow-y:auto;" class="modal fade" id="modal-hapus" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Hapus Peserta</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <strong>Peringatan</strong>
                Data Siswa yang sudah dipilih akan dihapus, Data Hasil Tes juga akan terhapus.
                <br /><br />
                Apakah anda yakin untuk menghapus data Siswa ?
            </div>
            <div class="modal-footer d-flex" style="justify-content: space-between;">
                <button type="button" id="btn-hapus" class="btn btn-danger">Hapus</button>
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

<div style="max-height: 100%;overflow-y:auto;" class="modal fade" id="modal-tambah" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url . '/tambah', 'id="form-tambah"'); ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Tambah Peserta</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="form-pesan"></div>
                <!-- <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" id="tambah-username" name="tambah-username" placeholder="Username Peserta">
                            </div> -->
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" id="tambah-email" name="tambah-email" placeholder="Email Peserta">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="tambah-password" name="tambah-password" placeholder="Password">
                </div>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" id="tambah-nama" name="tambah-nama" placeholder="Nama Lengkap Peserta">
                </div>
                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label>Asal Sekolah</label>
                        <input type="text" class="form-control" id="tambah-detail" name="tambah-detail" placeholder="Asal Sekolah">
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label>Kelas</label>
                        <select name="tambah-kelas" id="tambah-kelas" class="form-control input-sm">
                            <option value="">-- Pilih Kelas (TA. 2019/2020) --</option>
                            <?php for ($i = 1; $i < 10; $i++) : ?>
                                <option value="<?= $i ?>" 0>Kelas <?= $i ?></option>
                            <?php endfor ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nomer Telepon (WhatsApp)</label>
                    <input type="text" class="form-control" id="tambah-telepon" name="tambah-telepon" placeholder="Nomer Telepon">
                </div>

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Pilihan Mata Lomba</label>
                        <select name="tambah-lomba" id="tambah-lomba" class="form-control input-sm">
                            <option value="">-- Pilih Mata Lomba --</option>
                            <option value="matematika">Matematika</option>
                            <option value="sains">Sains</option>
                            <option value="all">Matematika & Sains</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label>Level</label>
                        <select name="tambah-group" id="tambah-group" class="form-control input-sm">
                            <option value="">-- Pilih Level --</option>
                            <?php if (!empty($select_group)) {
                                echo $select_group;
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="tambah-simpan" class="btn btn-primary btn-sm">Tambah</button>
                <a href="#" class="btn btn-default btn-sm" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>

    </form>
</div>

<div style="max-height: 100%;overflow-y:auto;" class="modal fade" id="modal-edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModalEdit" aria-hidden="true">
    <?php echo form_open($url . '/edit', 'id="form-edit"'); ?>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Edit Peserta</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="form-pesan-edit"></div>
                <input type="hidden" name="edit-id" id="edit-id">
                <input type="hidden" name="edit-pilihan" id="edit-pilihan">

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="edit-email" name="edit-email" placeholder="Email Peserta" readonly>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group mb-3">
                        <input type="password" id="edit-password" name="edit-password" class="form-control" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="btn-show-password">
                                <i id="icon-show-password" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" id="edit-nama" name="edit-nama" placeholder="Nama Lengkap Peserta">
                </div>

                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label>Asal Sekolah</label>
                        <input type="text" class="form-control" id="edit-detail" name="edit-detail" placeholder="Asal sekolah peserta">
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label>Kelas</label>
                        <select name="edit-kelas" id="edit-kelas" class="form-control input-sm">
                            <option value="">-- Pilih Kelas (TA. 2019/2020) --</option>
                            <?php for ($i = 1; $i < 10; $i++) : ?>
                                <option value="<?= $i ?>" 0>Kelas <?= $i ?></option>
                            <?php endfor ?>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label>Nomer Telepon (WhatsApp)</label>
                    <input type="text" class="form-control" id="edit-telepon" name="edit-telepon" placeholder="Nomer Telepon">
                </div>

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Pilihan Lomba</label>
                        <select name="edit-lomba" id="edit-lomba" class="form-control input-sm">
                            <option value="">-- Pilih Lomba --</option>
                            <option value="matematika">Matematika</option>
                            <option value="sains">Sains</option>
                            <option value="all">Matematika & Sains</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <label>Level</label>
                        <select name="edit-group" id="edit-group" class="form-control input-sm">
                            <option value="">-- Pilih Level --</option>
                            <?php if (!empty($select_group)) {
                                echo $select_group;
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="edit-active" id="edit-active" class="form-control input-sm">
                        <option value="1">Aktif</option>
                        <option value="0">Belum aktif</option>
                    </select>
                </div>
                <p>NB : Peserta yang dihapus, maka semua hasil tes akan ikut terhapus !</p>
            </div>
            <div class="modal-footer d-flex" style="justify-content: space-between;">
                <div>
                    <button type="button" id="edit-hapus" class="btn btn-danger btn-sm">Hapus</button>
                </div>
                <div>
                    <button type="button" id="edit-simpan" class="btn btn-primary btn-sm">Simpan</button>
                    <a href="#" class="btn btn-default btn-sm" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>

    </form>
</div>

<script lang="javascript">
    function refresh_table() {
        $('#table-peserta').dataTable().fnReloadAjax();
    }

    function showpassword() {
        var x = document.getElementById("edit-password");
        if (x.type === "password") {
            x.type = "text";
            $("#icon-show-password").removeClass("fa-eye");
            $("#icon-show-password").addClass("fa-eye-slash");
        } else {
            x.type = "password";
            $("#icon-show-password").removeClass("fa-eye-slash");
            $("#icon-show-password").addClass("fa-eye");
        }
    }

    function tambah() {
        $('#form-pesan').html('');
        $('#tambah-username').val('');
        $('#tambah-password').val('');
        $('#tambah-nama').val('');
        $('#tambah-email').val('');
        $('#tambah-detail').val('');

        $("#modal-tambah").modal("show");
        $('#tambah-username').focus();
    }

    function edit(id) {
        SW.loading()
        $.getJSON('<?php echo site_url() . '/' . $url; ?>/get_by_id/' + id + '', function(data) {
            if (data.data == 1) {
                $('#edit-id').val(data.id);
                $('#edit-username').val(data.username);
                $('#edit-password').val(data.password);
                $('#edit-nama').val(data.nama);
                $('#edit-email').val(data.email);
                $('#edit-detail').val(data.detail);
                $('#edit-telepon').val(data.telepon);
                $('#edit-group').val(data.group);
                $('#edit-active').val(data.active);
                $('#edit-kelas').val(data.kelas);
                $('#edit-lomba').val(data.lomba);

                $("#modal-edit").modal("show");
                SW.close()
            }
            $('#form-pesan-edit').html('');

        });
    }

    $(function() {
        $("#btn-show-password").click(function() {
            showpassword();
        });

        $("#level").change(function() {
            refresh_table()
        });

        $('#kelas').change(function() {
            refresh_table()
        })

        $('#edit-simpan').click(function() {
            $('#edit-pilihan').val('simpan');
            $('#form-edit').submit();
        });
        $('#edit-hapus').click(function() {
            $('#edit-pilihan').val('hapus');
            $('#form-edit').submit();
        });
        $('#btn-edit-pilih').click(function(event) {
            if ($('#check').val() == 0) {
                $(':checkbox').each(function() {
                    this.checked = true;
                });
                $('#check').val('1');
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
                $('#check').val('0');
            }
        });
        $('#btn-edit-hapus').click(function() {
            $("#modal-hapus").modal('show');
        });
        $('#btn-hapus').click(function() {
            $("#form-hapus").submit();
        });

        $('#form-hapus').submit(function() {
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/hapus_daftar_siswa",
                type: "POST",
                data: $('#form-hapus').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        refresh_table();
                        $("#modal-hapus").modal('hide');
                        SW.toast({
                            title: obj.pesan,
                            icon: 'success'
                        })
                        $('#check').val('0');
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

        $('#form-edit').submit(function() {
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/edit",
                type: "POST",
                data: $('#form-edit').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        refresh_table();
                        $("#modal-edit").modal('hide');
                        SW.toast({
                            title: obj.pesan,
                            icon: 'success'
                        })
                    } else {
                        SW.toast({
                            title: obj.pesan,
                            icon: 'error'
                        })
                        $('#modal-edit').animate({
                            scrollTop: 0
                        })
                    }
                }
            });
            return false;
        });

        $('#form-tambah').submit(function() {
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/tambah",
                type: "POST",
                data: $('#form-tambah').serialize(),
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        refresh_table();
                        $("#modal-tambah").modal('hide');
                        SW.toast({
                            title: obj.pesan,
                            icon: 'success'
                        })
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

        $('#table-peserta').DataTable({
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
                    'sAlign': 'center'
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "30px"
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sWidth": "20px"
                }
            ],
            "sAjaxSource": "<?php echo site_url() . '/' . $url; ?>/get_datatable/",
            "autoWidth": false,
            "responsive": true,
            "fnServerParams": function(aoData) {
                aoData.push({
                    "name": "group",
                    "value": $('#level').val()
                });

                aoData.push({
                    "name": "kelas",
                    "value": $('#kelas').val()
                });
            },
            'fnDrawCallback': function() {
                callBackDatatable('#table-peserta')
            }
        });

    });

    function export_excel() {
        // TODO
        let level = $('#level').val()
        let kelas = $('#kelas').val()

        window.open("<?php echo site_url() . '/' . $url; ?>/export/" + level + '/' + kelas, "_self");
    }
</script>