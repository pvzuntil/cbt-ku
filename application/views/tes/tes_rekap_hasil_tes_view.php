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
		<hr>
		<div class="row">
			<div class="col-md-4">
				<div class="card">
					<div class="card-header with-border">
						<div class="card-title">Pilih Peserta</div>
					</div><!-- /.card-header -->

					<div class="card-body">
						<div class="form-group">
							<label>Nama Peserta</label>
							<input type="hidden" id="nama-grup" name="nama-grup">
							<div>
								<select name="select-peserta" id="select-peserta" class="form-control input-sm select2" style="width: 100%;">
									<!-- < value="">-- Pilih Peserta --</option> -->
									<optgroup label="Pilih peserta"> <?php if (!empty($select_peserta)) {
																			echo $select_peserta;
																		} ?>
									</optgroup>
								</select>
							</div>
							<small class="text-muted">Pilih Peserta yang akan di Export</small>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-8">
				<div class="card">
					<div class="card-header with-border">
						<div class="card-title">Rekapitulasi Hasil Lomba</div>
					</div><!-- /.card-header -->

					<div class="card-body form-horizontal">
						<div class="form-group">
							<label class="control-label">Pilih Lomba</label>
							<div>
								<select name="select-lomba" id="select-lomba" class="form-control input-sm select2" style="width: 100%;">
									<option value="0">Pilih Lomba</option>
								</select>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<button type="button" class="btn btn-default" id="btn-lihat-detail">Lihat</button>
						<button type="button" class="btn btn-primary" id="btn-export-tes">Export</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section><!-- /.content -->



<script lang="javascript">
	const loadLomba = (id) => {
		$.ajax({
			url: '<?php echo site_url() . '/' . $url; ?>/load_lomba',
			method: 'POST',
			data: {
				id
			},
			beforeSend: () => {
				SW.loading()
			},
			success: (res) => {
				let data = JSON.parse(res)

				$('#select-lomba').empty()
				data.forEach((node) => {
					$('#select-lomba').append(`
						<option value="${node.id}">${node.name}</option>
					`)
				})
				SW.close()
			}
		})
	}

	function export_tes(idUser, idTes) {
		window.open("<?php echo site_url() . '/' . $url; ?>/tes_hasil_export/" + idUser + "/" + idTes);
	}

	$(function() {
		$('.select2').select2();

		$('#pilih-rentang-waktu').daterangepicker({
			timePicker: false,
			timePickerIncrement: 30,
			format: 'YYYY-MM-DD'
		});

		loadLomba($('#select-peserta').val())
	});

	$('#select-peserta').change(function() {
		loadLomba($(this).val())
	})

	$('#btn-export').click(function() {
		$('#nama-grup').val($('#pilih-grup option:selected').text());
		$('#form-export').submit();
	});

	$('#btn-export-tes').click(() => {
		let idUser = $('#select-peserta').val()
		let idTes = $('#select-lomba').val()
		export_tes(idUser, idTes)
	})

	$('#btn-lihat-detail').click(() => {
		let idUser = $('#select-peserta').val()
		let idTes = $('#select-lomba').val()
		$.ajax({
			url: '<?php echo site_url() . '/' . $url; ?>/load_detail',
			method: 'POST',
			data: {
				idUser, idTes
			},
			beforeSend: () => {
				SW.loading()
			},
			success: (res) => {
				window.open(res, '_blank')
				SW.close()
			}
		})
	})
</script>