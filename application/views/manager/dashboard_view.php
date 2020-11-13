<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h1 class="m-0 text-dark"><?php if (!empty($site_name)) {
                                                echo $site_name;
                                            } ?></h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">
        <div class="callout callout-info">
            <h4>Informasi</h4>
            <p>Ini adalah area administratif, yang memiliki platform dan bahasa user-friendly untuk membuat, mengelola
                dan melaksanakan ujian online.</p>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Peserta</span>
                        <span class="info-box-number"><?= $countPeserta ?></span>
                        <span>
                            <div class="badge bg-green">AKTIF : <?= $countPesertaAktif ?></div>
                            <div class="badge bg-red">BELUM AKTIF : <?= $countPeserta - $countPesertaAktif ?></div>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <?php if ($bayar_aktif == 'on') : ?>

                <div class="col-sm-5">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-money-bill-wave"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Peserta membayar</span>
                            <span class="info-box-number"><?= $countPesertaPayIsPay ?></span>
                            <span>
                                <div class="badge bg-info">MENUNGGU : <?= $countPesertaPayIsWait ?></div>
                                <div class="badge bg-red">BELUM MEMBAYAR : <?= $countPesertaPayIsNope ?></div>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
            <?php endif ?>

            <div class="col-sm-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-scroll"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Jumlah Tes</span>
                        <span class="info-box-number"><?= $countTes ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <?php if ($bayar_aktif == 'on') : ?>
                <div class="col-sm-8">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-money-bill-wave"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Estimasi Pemasukan | <?= $bayar_jenis == 'mapel' ? 'Per-mapel' : 'Per-akun' ?></span>
                            <span class="info-box-number">Rp. <?= $bayar_jenis == 'mapel' ?  number_format((int) $infoLomba['count']['all'] * (int)$bayar_tarif, 0, '.', '.') : $countPesertaPayIsPay * (int)$bayar_tarif ?></span>
                            <span>
                                <div class="badge bg-info"><?= $infoLomba['count']['all'] ?> Lomba telah diikuti</div>
                                <?php foreach ($infoLomba['lomba'] as $lomba) : ?>
                                    <div class="badge bg-success"><?= $lomba->modul_nama ?> : <?= $infoLomba['count'][$lomba->modul_id] ?> Peserta</div>
                                <?php endforeach; ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
            <?php endif ?>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Konfigurasi System</h3>
            </div><!-- /.box-header -->

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <b><u>Waktu Server</u></b>
                        <br />
                        <b><?php if (!empty($waktu_server)) {
                                echo $waktu_server;
                            } ?></b>
                        <br />
                        Pastikan waktu server sesuai dengan waktu saat ini. Jika ada perbedaan, cek timezone server dan
                        timezone di konfigurasi PHP.
                    </div>
                    <div class="col-md-4">
                        <b><u>Informasi Konfigurasi Upload PHP</u></b>
                        <br />
                        POST_MAX_SIZE = <?php if (!empty($post_max_size)) {
                                            echo $post_max_size;
                                        } ?>
                        <br />
                        UPLOAD_MAX_FILESIZE = <?php if (!empty($upload_max_filesize)) {
                                                    echo $upload_max_filesize;
                                                } ?>
                    </div>
                    <div class="col-md-4">
                        <b><u>Folder Upload</u></b>
                        <br />
                        Folder "uploads" = <?php if (!empty($dir_public_uploads)) {
                                                echo $dir_public_uploads;
                                            } ?>
                        <br />
                        Folder "public/uploads" = <?php if (!empty($dir_uploads)) {
                                                        echo $dir_uploads;
                                                    } ?>
                        <br />
                        Pastikan kedua folder diatas memiliki nilai Writeable.
                    </div>
                </div>
                <p>
                </p>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Petunjuk Penggunaan</h3>
            </div><!-- /.box-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <dt>Data Modul</dt>
                        <dd>
                            Kelompok Data Modul digunakan untuk menambah modul, topik, dan soal. Serta digunakan untuk
                            mengatur file dengan memanfaatkan File Manager.
                            <ol>
                                <li>Topik</li>
                                <li>Soal</li>
                                <li>Import Soal</li>
                                <li>Daftar Soal</li>
                                <li>File Manager</li>
                            </ol>
                        </dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt>Data Peserta</dt>
                        <dd>
                            Kelompok Data Peserta digunakan untuk mengatur Peserta, dan Group.
                            <ol>
                                <li>Daftar Group</li>
                                <li>Daftar Peserta</li>
                                <li>Import Data Peserta</li>
                                <li>Cetak Kartu</li>
                            </ol>
                        </dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt>Data Tes</dt>
                        <dd>
                            Kelompok Data Tes digunakan untuk mengatur Tes, mengevaluasi jawaban essay, dan melihat Hasil
                            tes.
                            <ol>
                                <li>Tambah Tes</li>
                                <li>Daftar Tes</li>
                                <li>Evaluasi Tes</li>
                                <li>Hasil tes</li>
                                <li>Rekap Hasil Tes</li>
                                <li>Token</li>
                            </ol>
                        </dd>
                    </div>
                    <div class="col-12 col-md-6">
                        <dt>Tool</dt>
                        <dd>
                            Kelompok Tool digunakan untuk membackup database, file pedukung soal, dan Export Import Data
                            Soal
                            <ol>
                                <li>Backup Data</li>
                                <li>Export Import Soal</li>
                            </ol>
                        </dd>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</section><!-- /.content -->