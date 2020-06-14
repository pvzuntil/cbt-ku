<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Pembayaran Peserta
        <small>Konfirmasi pembayaran peserta disini.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pembayaran Peserta</li>
    </ol>
</section>

<style>
    .badge-success {
        color: #fff;
        background-color: #28a745 !important;
    }

    .badge-danger {
        color: #fff;
        background-color: #dc3545 !important;
    }

    .zoom {
        transition: transform .2s;
        /* Animation */
        margin: 0 auto;
    }

    .zoom:hover {
        transform: scale(2);
        /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
    }
</style>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-title">Pilih Group</div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>Group</label>
                        <div id="data-kelas">
                            <select name="group" id="group" class="form-control input-sm">
                                <option value="semua">Semua Group</option>
                                <?php if (!empty($select_group)) {
                                    echo $select_group;
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <p>Pilih group terlebih dahulu untuk menampilkan dan menambah data Peserta</p>
                </div>
            </div>
        </div> -->

        <div class="col-sm-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-title">Bukti Pembayaran yang terkirim</div>
                    <div class="box-tools pull-right">
                        <div class="dropdown pull-right">
                            <a style="cursor: pointer;" onclick="tambah()" class="btn btn-success">Tambah Pembayaran peserta</a>
                        </div>
                    </div>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <table id="table-peserta" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Email</th>
                                <th class="all">Nama</th>
                                <th>Level</th>
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
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div style="max-height: 100%;overflow-y:auto;" class="modal" id="modal-tambah" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <?php echo form_open($url . '/tambah', 'id="form-tambah"'); ?>
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Tambah Pembayaran peserta</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div id="form-pesan"></div>
                            <div class="form-group row">
                                <div class="col-xs-12">
                                    <label>Nama Peserta</label>
                                </div>
                                <div class="col-xs-12">
                                    <div>
                                        <select name="tambah-pay" id="tambah-pay" class="form-control input-sm" style="width: 100%;">
                                            <!-- < value="">-- Pilih Peserta --</option> -->
                                            <optgroup label="Pilih peserta"> <?php if (!empty($select_group)) {
                                                                                    echo $select_group;
                                                                                } ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
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
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>

        </form>
    </div>

    <div style="max-height: 100%;overflow-y:auto;" class="modal" id="modal-showDoc" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModalEdit" aria-hidden="true">
        <?php echo form_open($url . '/edit', 'id="form-edit"'); ?>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Dokumen pembayaran</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
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

                            <div class="callout callout-warning" id="msg-wait">
                                <p>Menunggu untuk dikonfirmasi</p>
                            </div>
                            <div class="callout callout-success" id="msg-allow">
                                <p>Diterima</p>
                            </div>
                            <div class="callout callout-danger" id="msg-deny">
                                <p>Ditolak</p>
                                <p id="msg-deny-message"></p>
                            </div>
                            <div class="col-sm-12" style="margin-bottom: 15px; display: flex; justify-content: center;">
                                <img src="" alt="" class="img-responsive zoom" style="border-radius: 5px; cursor: pointer; box-shadow: 0px 4px 8px 0px #00000026;" id="imagePay">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-left" id="buttonActionShowDoc">
                        <button type="button" id="show-allow" class="btn btn-success">Terima</button>
                        <button type="button" id="show-deny" class="btn btn-danger">Tolak</button>
                    </div>
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>

        </form>
    </div>
</section><!-- /.content -->



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

        $("#modal-proses").modal('show');
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
            $("#modal-proses").modal('hide');
        });
    }

    $(function() {
        $('#tambah-pay').select2({
            dropdownParent: $("#modal-tambah")
        });

        $('#show-allow').on('click', function() {
            Swal.fire({
                title: 'Harap diperhatikan !',
                text: 'Aksi ini tidak bisa diubah atau diurungkan',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan !',
                cancelButtonText: 'Batal'
            }).then((res) => {
                if (res.value) {
                    $("#modal-proses").modal('show');
                    proses_konfirmasi('allow')
                }
            })
        });

        $('#show-deny').on('click', function() {
            Swal.fire({
                title: 'Harap diperhatikan !',
                text: 'Aksi ini tidak bisa diubah atau diurungkan',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan !',
                cancelButtonText: 'Batal'
            }).then((res) => {
                if (res.value) {
                    Swal.fire({
                        input: 'textarea',
                        inputPlaceholder: 'Ditolak karena ...',
                        inputAttributes: {
                            'aria-label': 'Ditolak karena ...'
                        },
                        showCancelButton: true,
                        title: 'Tuliskan alasan penolakan'
                    }).then((res) => {
                        if (res.value) {
                            $("#modal-proses").modal('show');
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
                        $("#modal-proses").modal('hide');
                        $("#modal-showDoc").modal('hide');
                        notify_success(obj.pesan);
                    } else {
                        $("#modal-proses").modal('hide');
                        notify_error(obj.pesan);
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
                        Swal.fire({
                            title: 'Berhasil !',
                            text: obj.pesan,
                            icon: 'success'
                        }).then(() => {
                            window.location.reload()
                        })
                    } else {
                        $("#modal-proses").modal('hide');
                        $('#form-pesan').html(pesan_err(obj.pesan));
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
                    "sWidth": "100px"
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
                    "name": "group",
                    "value": $('#group').val()
                });
            }
        });

    });

    function export_excel() {
        let groupName = $('#group').val()

        window.open("<?php echo site_url() . '/' . $url; ?>/export/" + groupName, "_self");
    }
</script>