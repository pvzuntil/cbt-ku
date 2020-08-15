<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<h1>
			Tambah Level
		</h1>
	</div>
</section>

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<?php echo form_open('manager/userlevel/add', 'id="form-tambah-level" class="form-horizontal"') ?>
		<div class="row">
			<div class="col-md-3 col-12">
				<div class="card sticky" style="top: 10%;">
					<div class="card-header with-border">
						<h3 class="card-title">Level</h3>
					</div><!-- /.card-header -->

					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">Level</label>
									<input type="text" class="form-control input-sm" id="level" name="level" placeholder="Level">
								</div>
								<div class="form-group">
									<label class="control-label">Keterangan</label>
									<input type="text" class="form-control input-sm" id="keterangan" name="keterangan" placeholder="Keterangan Level">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-9 col-12">
				<div class="card">
					<div class="card-header with-border">
						<h3 class="card-title">Hak Akses</h3>
					</div><!-- /.card-header -->

					<div class="card-body">
						<?php if (!empty($data_menu)) {
							echo $data_menu;
						} ?>
					</div>

					<div class="card-footer">
						<button type="submit" id="btn-simpan" class="btn btn-info pull-right btn-sm">Simpan</button>
					</div>
				</div>
			</div>
		</div>
		<?= form_close() ?>
	</div>
</section><!-- /.content -->

<script lang="javascript">
	$(function() {
		$('#form-tambah-level').submit(function() {
			SW.loading()
			$.ajax({
				url: "<?php echo site_url(); ?>/manager/userlevel/add",
				type: "POST",
				data: $('#form-tambah-level').serialize(),
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