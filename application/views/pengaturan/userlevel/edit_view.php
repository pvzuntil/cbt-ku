<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<h1>
			Edit Level
		</h1>
	</div>
</section>

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<?php echo form_open('manager/userlevel/edit', 'id="form-edit-level" class="form-horizontal"') ?>
		<div class="row">
			<div class="col-3">
				<div class="card sticky" style="top: 10%;">
					<div class="card-header with-border">
						<h3 class="card-title">Level</h3>
					</div><!-- /.card-header -->

					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">Level</label>
									<input type="hidden" class="form-control input-sm" id="aksi" name="aksi">
									<input type="text" class="form-control input-sm" value="<?php if (!empty($level)) {
																								echo $level;
																							} ?>" id="level" name="level" placeholder="Level" readonly>
								</div>
								<div class="form-group">
									<label class="control-label">Keterangan</label>
									<input type="text" class="form-control input-sm" value="<?php if (!empty($keterangan)) {
																								echo $keterangan;
																							} ?>" id="keterangan" name="keterangan" placeholder="Keterangan" readonly>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-9">
				<div class="card">
					<div class="card-header with-border">
						<h3 class="card-title">Hak Akses</h3>
					</div><!-- /.card-header -->

					<div class="card-body">
						<div id="form-pesan"></div>
						<?php if (!empty($data_menu)) {
							echo $data_menu;
						} ?>
					</div>

					<div class="card-footer">
						<div class="row d-flex" style="justify-content: space-between;">
							<button type="button" id="hapus" class="btn btn-danger btn-sm">Hapus</button>
							<button type="button" id="simpan" class="btn btn-info btn-sm">Simpan</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?= form_close() ?>
	</div>
</section><!-- /.content -->

<script lang="javascript">
	$(function() {
		$('#simpan').click(function() {
			SW.loading()
			$('#aksi').val('1');
			$('#form-edit-level').submit();
		});
		$('#hapus').click(function() {
			SW.loading()
			$('#aksi').val('0');
			$('#form-edit-level').submit();
		});

		$('#form-edit-level').submit(function() {
			$.ajax({
				url: "<?php echo site_url(); ?>/manager/userlevel/edit",
				type: "POST",
				data: $('#form-edit-level').serialize(),
				cache: false,
				success: function(respon) {
					var obj = $.parseJSON(respon);
					if (obj.status == 1) {
						SW.toast({
							title: obj.pesan,
							icon: 'success'
						})
						setTimeout(function() {
							window.open("<?php echo site_url(); ?>/manager/userlevel", "_self");
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
	});
</script>