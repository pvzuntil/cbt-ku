<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<h1>
			Rekapitulasi Hasil Tes
		</h1>
	</div>
</section>

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="callout callout-info">
					<h4>Informasi</h4>
					<p>Pilih Grup peserta yang akan di export Hasil tes nya pada bagian samping halaman ini, dan pilih rentang waktu Tes tersebut dikerjakan.</p>
					<p>Siswa yang tidak mengikuti Tes, maka Hasilnya akan bernilai N/A pada file hasil Export.</p>
				</div>
			</div>
		</div>
		<?php echo form_open($url . '/export', 'id="form-export"'); ?>
		<div class="row">
			<div class="col-md-4">
				<div class="card">
					<div class="card-header with-border">
						<div class="card-title">Pilih Grup</div>
					</div><!-- /.card-header -->

					<div class="card-body">
						<div class="form-group">
							<label>Nama Grup</label>
							<input type="hidden" id="nama-grup" name="nama-grup">
							<select name="pilih-grup" id="pilih-grup" class="form-control input-sm">
								<?php if (!empty($select_group)) {
									echo $select_group;
								} ?>
							</select>
							<small class="text-muted">Pilih Grup yang akan di Export</small>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-8">
				<div class="card">
					<div class="card-header with-border">
						<div class="card-title">Rekapitulasi Hasil Tes</div>
					</div><!-- /.card-header -->

					<div class="card-body form-horizontal">
						<div class="form-group">
							<label class="control-label">Waktu Tes</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="inputGroup-sizing-default">
										<i class="fas fa-clock"></i>
									</span>
								</div>
								<input type="text" name="pilih-rentang-waktu" id="pilih-rentang-waktu" class="form-control input-sm" value="<?php if (!empty($rentang_waktu)) {
																																				echo $rentang_waktu;
																																			} ?>" readonly />
							</div>

							<small class="text-muted">Pilih Rentang Tanggal dimana Tes dilakukan. Sesuai Waktu Mulai pada Daftar Tes.</small>
						</div>
					</div>
					<div class="card-footer">
						<button type="button" class="btn btn-primary" id="btn-export">Export</button>
					</div>
				</div>
			</div>
		</div>
		<?= form_close() ?>
	</div>
</section><!-- /.content -->



<script lang="javascript">
	$(function() {
		$('#pilih-rentang-waktu').daterangepicker({
			timePicker: false,
			timePickerIncrement: 30,
			format: 'YYYY-MM-DD'
		});
	});

	$('#btn-export').click(function() {
		$('#nama-grup').val($('#pilih-grup option:selected').text());
		$('#form-export').submit();
	});
</script>