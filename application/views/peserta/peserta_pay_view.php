<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Pembayaran Peserta
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
                        <div class="card-title">Pilih status</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Status</label>
                            <div id="data-kelas">
                                <select name="status" id="status" class="form-control input-sm">
                                    <option value="semua">Semua Status</option>
                                    <option value="wait">Menunggu Konfirmasi</option>
                                    <option value="allow">Diterima</option>
                                    <option value="deny">Ditolak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Bukti Pembayaran yang terkirim</div>
                        <div class="card-tools pull-right">
                            <div class="dropdown pull-right">
                                <a style="cursor: pointer;" onclick="export_excel()" class="btn btn-primary btn-xs text-white">Eksport Data</a>
                                <a style="cursor: pointer;" onclick="tambah()" class="btn btn-success btn-xs text-white">Tambah Pembayaran peserta</a>
                            </div>
                        </div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <table id="table-peserta" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Email</th>
                                    <th class="all">Nama</th>
                                    <th>Kelompok</th>
                                    <th>Pilihan Lomba</th>
                                    <th>Tanggal upload</th>
                                    <th class="all">Status</th>
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


<div style="max-height: 100%;overflow-y:auto;" class="modal fade" id="modal-tambah" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url . '/tambah', 'id="form-tambah"'); ?>
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Tambah Pembayaran peserta</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="form-pesan"></div>
                    <div class="row">
                        <div class="form-group col-12">
                            <label>Nama Peserta</label>
                            <select name="tambah-pay" id="tambah-pay" class="form-control input-sm" style="width: 100%;">
                                <optgroup label="Pilih peserta"> <?php if (!empty($select_group)) {
                                                                        echo $select_group;
                                                                    } ?>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label>Opsi</label>
                            <select name="tambah-opsi" id="tambah-opsi" class="form-control input-sm">
                                <option value="">-- Pilih Opsi --</option>
                                <option value="allow">Sudah membayar</option>
                                <option value="deny">Tolak membayar</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="tambah-simpan" class="btn btn-primary">Tambah</button>
                <a href="#" class="btn btn-danger" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
    <?= form_close() ?>
</div>

<div style="max-height: 100%;overflow-y:auto;" class="modal fade" id="modal-showDoc" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModalShowDoc" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div id="trx-judul">Dokumen pembayaran</div>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="form-pesan-show"></div>
                <input type="hidden" name="show-id" id="show-id">

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="show-email" name="show-email" placeholder="Email Peserta" readonly>
                </div>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" id="show-nama" name="show-nama" readonly>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Asal Sekolah</label>
                        <input type="text" class="form-control" id="show-detail" name="show-detail" readonly>
                    </div>

                    <div class="form-group col-sm-6">
                        <label>Level</label>
                        <input type="text" class="form-control" id="show-level" name="show-level" readonly>
                    </div>
                </div>

                <div class="alert alert-warning" id="msg-wait">
                    <span>Menunggu untuk dikonfirmasi</span>
                </div>
                <div class="alert alert-success" id="msg-allow">
                    <span>Diterima</span>
                </div>
                <div class="alert alert-danger" id="msg-deny">
                    <span style="font-weight: bold;">Ditolak</span>
                    <p id="msg-deny-message" class="m-0"></p>
                </div>
                <div class="col-sm-12" style="margin-bottom: 15px; display: flex; justify-content: center;">
                    <img src="" alt="" class="img-responsive img-thumbnail zoom" id="imagePay">
                </div>
            </div>
            <div class="modal-footer d-flex" style="justify-content: space-between;">
                <div class="" id="buttonActionShowDoc">
                    <button type="button" id="show-deny" class="btn btn-danger">Tolak</button>
                    <button type="button" id="show-allow" class="btn btn-success">Terima</button>
                </div>
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>


<script lang="javascript">
    function refresh_table() {
        $('#table-peserta').dataTable().fnReloadAjax();
    }

    function tambah() {
        $('#form-pesan').html('');

        $('#modal-tambah').modal('show');
    }

    function showDoc(id) {
        $('#imagePay').attr('src', '<?= site_url() ?>' + 'public/images/loading.gif');

        SW.loading()
        $.getJSON('<?php echo site_url() . '/' . $url; ?>/get_by_id/' + id + '', function(data) {
            if (data.data == 1) {
                $('#show-id').val(data.id);
                $('#show-nama').val(data.nama);
                $('#show-email').val(data.email);
                $('#show-detail').val(data.detail);
                $('#show-level').val(data.group);
                $('#imagePay').attr('src', '<?= site_url() ?>' + data.imgPay);

                switch (data.status) {
                    case 'wait':
                        $('#msg-wait').show();
                        $('#msg-allow').hide();
                        $('#msg-deny').hide();
                        $('#buttonActionShowDoc').show()
                        break;
                    case 'allow':
                        $('#msg-wait').hide();
                        $('#msg-allow').show();
                        $('#msg-deny').hide();
                        $('#buttonActionShowDoc').hide()
                        break
                    case 'deny':
                        $('#msg-wait').hide();
                        $('#msg-allow').hide();
                        $('#msg-deny').show();
                        $('#msg-deny-message').html(data.message);
                        $('#buttonActionShowDoc').hide()
                        break

                }

                $("#modal-showDoc").modal("show");
            }
            SW.close()
        });
    }

    $(function() {
        $('#status').change(function() {
            refresh_table()
        })

        $('#tambah-pay').select2({
            dropdownParent: $("#modal-tambah")
        });

        $('#show-allow').on('click', function() {
            SW.show({
                title: 'Harap diperhatikan !',
                text: 'Aksi ini tidak bisa diubah atau diurungkan',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan !',
                cancelButtonText: 'Batal'
            }).then((res) => {
                if (res.value) {
                    SW.loading()
                    proses_konfirmasi('allow')
                }
            })
        });

        $('#show-deny').on('click', function() {
            SW.yesno({
                title: 'Harap diperhatikan !',
                text: 'Aksi ini tidak bisa diubah atau diurungkan',
                icon: 'info',
            }).then((res) => {
                if (res.value) {
                    SW.yesno({
                        input: 'textarea',
                        inputPlaceholder: 'Ditolak karena ...',
                        inputAttributes: {
                            'aria-label': 'Ditolak karena ...'
                        },
                        title: 'Tuliskan alasan penolakan'
                    }).then((res) => {
                        if (res.value) {
                            SW.loading()
                            proses_konfirmasi('deny', res.value)
                        }
                    })
                }
            })
        });

        function proses_konfirmasi(type, message = '') {
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/konfirmpay",
                type: "POST",
                data: {
                    id: $('#show-id').val(),
                    type: type,
                    message: message
                },
                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
                        refresh_table();
                        $("#modal-showDoc").modal('hide');
                        SW.toast({
                            title: obj.pesan,
                            icon: 'success'
                        });
                    } else {
                        SW.toast({
                            title: obj.pesan,
                            icon: 'error'
                        })
                    }
                }
            });
        }

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

        $('#modal-showDoc').on('shown.bs.modal', function() {
            $(document).off('focusin.modal');
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
                    "sWidth": "100px"
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
            ],
            "sAjaxSource": "<?php echo site_url() . '/' . $url; ?>/get_datatable/",
            "autoWidth": false,
            "responsive": true,
            "fnServerParams": function(aoData) {
                aoData.push({
                    "name": "status",
                    "value": $('#status').val()
                });
            },
            'fnDrawCallback': function() {
                callBackDatatable('#table-peserta')
            }
        });

    });

    function export_excel() {
        let status = $('#status').val()
        window.open("<?php echo site_url() . '/' . $url; ?>/export/" + status, "_self");
    }

    $(() => {

    })
</script>