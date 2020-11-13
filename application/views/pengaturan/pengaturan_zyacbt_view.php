<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>
            Pengaturan CBT
        </h1>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php echo form_open($url . '/simpan', 'id="form-pengaturan"'); ?>
                <div class="card">
                    <div class="card-header with-border">
                        <div class="card-title">Daftar Pengaturan CBT</div>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">

                                <div id="form-pesan"></div>
                                <div class="form-group">
                                    <label class="control-label">Nama</label>
                                    <input type="text" class="form-control input-sm" id="zyacbt-nama" name="zyacbt-nama">
                                    <small class="text-muted">
                                        Nama Pelaksana CBT. Digunakan sebagai identitas pelaksanaan Tes.
                                    </small>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label class="control-label">Keterangan</label>
                                    <input type="text" class="form-control input-sm" id="zyacbt-keterangan" name="zyacbt-keterangan">
                                    <small class="text-muted">
                                        Keterangan Pelaksana bisa diisi dengan Slogan ataupun Alamat dari Organisasi.
                                    </small>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label class="control-label">Link Login Operator</label>
                                    <select class="form-control input-sm" id="zyacbt-link-login" name="zyacbt-link-login">
                                        <option value="tidak">Tidak</option>
                                        <option value="ya">Ya</option>
                                    </select>
                                    <small class="text-muted">
                                        Menampilkan Link <b>Log In Operator</b> pada Halaman login user.
                                    </small>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label class="control-label">Lock Mobile Exam Browser</label>
                                    <select class="form-control input-sm" id="zyacbt-mobile-lock-xambro" name="zyacbt-mobile-lock-xambro">
                                        <option value="tidak">Tidak</option>
                                        <option value="ya">Ya</option>
                                    </select>
                                    <small class="text-muted">
                                        Lock Browser Mobile / Browser Android agar hanya dapat digunakan melalui Exam Browser
                                    </small>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label class="control-label">Mode Perbaikan</label>
                                    <select class="form-control input-sm" id="main-mode" name="main-mode">
                                        <option value="tidak">Tidak</option>
                                        <option value="ya">Ya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label class="control-label">Tutup Pendaftaran</label>
                                    <select class="form-control input-sm" id="tutup-daftar" name="tutup-daftar">
                                        <option value="tidak">Tidak</option>
                                        <option value="ya">Ya</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Pilihan Kelas</label>
                                <select name="pilihan-kelas[]" id="pilihan-kelas" class="form-control" multiple>
                                    <option value="sd">SD (Sekolah Dasar)</option>
                                    <option value="smp">SMP (Sekolah menengah pertama)</option>
                                    <option value="sma">SMA (Sekolah menengah atas)</option>
                                </select>
                            </div>
                        </div>



                        <!-- <div class="form-group">
                            <div class="></div>
                            <div class=">
                                <label>Tutup Pendaftaran</label>
                                <select class="form-control input-sm" id="tutup-daftar" name="tutup-daftar">
                                    <option value="tidak">Tidak</option>
                                    <option value="ya">Ya</option>
                                </select>
                            </div>
    
                            <div class=">
                                <label>Tutup Pembayaran</label>
                                <select class="form-control input-sm" id="tutup-bayar" name="tutup-bayar">
                                    <option value="tidak">Tidak</option>
                                    <option value="ya">Ya</option>
                                </select>
                            </div>
                        </div> -->

                        <!-- <hr> -->

                    </div>
                    <hr style="margin: 0px">
                    <div class="card-header with-border">
                        <div class="card-title">Pengaturan Pembayaran</div>
                    </div><!-- /.card-header -->


                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="bayar-aktif" name="bayar-aktif">
                                        <label class="custom-control-label" for="bayar-aktif">Aktifkan Opsi Pembayaran</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label">No. Rekening</label>
                                    <input type="number" class="form-control input-sm" id="bayar-rek" name="bayar-rek">
                                    <small class="text-muted">
                                    </small>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Atas Nama</label>
                                    <input type="text" class="form-control input-sm" id="bayar-an" name="bayar-an">
                                    <small class="text-muted">
                                    </small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Nama Bank</label>
                                    <input type="text" class="form-control input-sm" id="bayar-bank" name="bayar-bank">
                                    <small class="text-muted">
                                    </small>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Jenis Pembayaran</label>
                                    <select name="bayar-jenis" id="bayar-jenis" class="select custom-select form-control">
                                        <option value="mapel">Per-mapel</option>
                                        <option value="akun">Per-akun</option>
                                    </select>
                                    <small class="text-muted">
                                    </small>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Tarif</label>
                                    <input type="number" class="form-control input-sm" id="bayar-tarif" name="bayar-tarif">
                                    <small class="text-muted">
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" id="btn-simpan" class="btn btn-primary btn-sm">Simpan Pengaturan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</section><!-- /.content -->



<script lang="javascript">
    function load_data() {
        SW.loading()
        $.getJSON('<?php echo site_url() . '/' . $url; ?>/get_pengaturan_zyacbt', function(data) {
            if (data.data == 1) {
                $('#zyacbt-nama').val(data.cbt_nama);
                $('#zyacbt-keterangan').val(data.cbt_keterangan);
                $('#zyacbt-link-login').val(data.link_login_operator);
                $('#zyacbt-mobile-lock-xambro').val(data.mobile_lock_xambro);
                $('#main-mode').val(data.main_mode);
                $('#tutup-daftar').val(data.tutup_daftar);
                // $('#tutup-bayar').val(data.tutup_bayar);
                $('#pilihan-kelas').val(JSON.parse(data.pilihan_kelas)).trigger('change')

                $('#bayar-rek').val(data.bayar_rek);
                $('#bayar-an').val(data.bayar_an);
                $('#bayar-bank').val(data.bayar_bank);
                $('#bayar-jenis').val(data.bayar_jenis);
                $('#bayar-tarif').val(data.bayar_tarif);

                data.bayar_aktif == 'on' ? $('#bayar-aktif').attr('checked', '') : null


            }
            SW.close()
        });
    }

    $(function() {
        $('#pilihan-kelas').select2()

        load_data();
        $('#form-pengaturan').submit(function() {
            SW.loading()
            $.ajax({
                url: "<?php echo site_url() . '/' . $url; ?>/simpan",
                type: "POST",
                data: $('#form-pengaturan').serialize(),

                cache: false,
                success: function(respon) {
                    var obj = $.parseJSON(respon);
                    if (obj.status == 1) {
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
            return false;
        });
    });
</script>