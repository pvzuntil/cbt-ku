<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php if (!empty($site_name)) {
            echo $site_name;
        } ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>/manager"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">


    <div class="callout callout-info">
        <h4>Informasi</h4>
        <p>Ini adalah area administratif, yang memiliki platform dan bahasa user-friendly untuk membuat, mengelola dan melaksanakan ujian online.</p>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Peserta terdaftar</span>
                    <span class="info-box-number"><?= $countPeserta ?></span>
                    <!-- The progress section is optional -->
                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description">
                        <div class="badge bg-green">AKTIF : <?= $countPesertaAktif ?></div>
                        <div class="badge bg-red">BELUM AKTIF : <?= $countPeserta - $countPesertaAktif ?></div>
                    </span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-sm-4">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Peserta membayar</span>
                    <span class="info-box-number"><?= $countPesertaPayIsPay ?></span>
                    <!-- The progress section is optional -->
                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description">
                        <div class="badge bg-red">BELUM MEMBAYAR : <?= $countPesertaPayIsNope ?> Peserta</div>
                    </span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-sm-4">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Jumlah tes</span>
                    <span class="info-box-number"><?= $countTes ?></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
    </div>

    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <div class="box-title">Konfigurasi System</div>
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <b><u>Waktu Server</u></b>
                    <br />
                    <b><?php if (!empty($waktu_server)) {
                            echo $waktu_server;
                        } ?></b>
                    <br />
                    Pastikan waktu server sesuai dengan waktu saat ini. Jika ada perbedaan, cek timezone server dan timezone di konfigurasi PHP.
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
    <div class="box box-warning box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Petunjuk Penggunaan</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <dl>
                <dt>Data Modul</dt>
                <dd>
                    Kelompok Data Modul digunakan untuk menambah modul, topik, dan soal. Serta digunakan untuk mengatur file dengan memanfaatkan File Manager.
                    <ol>
                        <li>Topik</li>
                        <li>Soal</li>
                        <li>Import Soal</li>
                        <li>Daftar Soal</li>
                        <li>File Manager</li>
                    </ol>
                </dd>
                <dt>Data Peserta</dt>
                <dd>
                    Kelompok Data Peserta digunakan untuk mengatur Peserta, dan Group.
                    <ol>
                        <li>Daftar Group</li>
                        <li>Daftar Peserta</li>
                        <li>Import Data Peserta</li>
                        <li>Cetak Kartu</li>
                    </ol>
                <dt>Data Tes</dt>
                <dd>
                    Kelompok Data Tes digunakan untuk mengatur Tes, mengevaluasi jawaban essay, dan melihat Hasil tes.
                    <ol>
                        <li>Tambah Tes</li>
                        <li>Daftar Tes</li>
                        <li>Evaluasi Tes</li>
                        <li>Hasil tes</li>
                        <li>Rekap Hasil Tes</li>
                        <li>Token</li>
                    </ol>
                </dd>
                <dt>Tool</dt>
                <dd>
                    Kelompok Tool digunakan untuk membackup database, file pedukung soal, dan Export Import Data Soal
                    <ol>
                        <li>Backup Data</li>
                        <li>Export Import Soal</li>
                    </ol>
                </dd>
            </dl>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</section><!-- /.content -->