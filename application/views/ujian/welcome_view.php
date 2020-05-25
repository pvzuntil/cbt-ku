<div class="container">
	<?php if ($url != 'welcome') : ?>
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?php if (!empty($site_name)) {
					echo $site_name;
				} ?>
				<small>Ujian Online Berbasis Komputer</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Selamat Datang</li>
			</ol>
		</section>
	<?php endif ?>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<?php echo form_open('welcome/login', 'id="form-login" class="form-horizontal"') ?>
		</div>
		<div class="row">
			<div class="login-box">
				<div class="login-logo">
					<b>User Login</b>
				</div><!-- /.login-logo -->
				<div class="login-box-body">
					<p class="login-box-msg">Masukkan Email dan Password</p>
					<?php if ($this->session->flashdata('verif')) : ?>
						<div class="alert alert-info">
							<?= $this->session->flashdata('verif'); ?>
						</div>
					<?php endif ?>
					<div id="form-pesan"></div>
					<div class="form-group has-feedback">
						<input type="text" id="username" autocomplete="off" name="username" class="form-control" placeholder="Email" type="email" />
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" id="password" autocomplete="off" name="password" class="form-control" placeholder="Password" />
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="row" style="margin-bottom: 15px">
						<div class="col-xs-6">
							<div class="checkbox icheck">
								<label>
									<input type="checkbox" id="show-password"> Show Password
								</label>
							</div>
						</div><!-- /.col -->
						<div class="col-xs-6" style="display: flex; align-items: center; justify-content: flex-end; position: relative; top: 10px">
							<a href="">Lupa password</a>
						</div><!-- /.col -->

					</div>
					<div class="row">

						<div class="col-xs-12" style="margin-bottom: 10px">
							<button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>

						</div><!-- /.col -->

						<div class="col-xs-12">
							<button class="btn btn-default btn-block btn-flat" id="btnModalTambah" type="button">Daftar</button>
						</div><!-- /.col -->

					</div>
				</div><!-- /.login-box -->
			</div>
			</form>

			<!-- MODAL ADD PESERTA -->

			<div style="max-height: 100%;overflow-y:auto;" class="modal" id="modal-tambah" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
				<?php echo form_open($url . '/tambah', 'id="form-tambah"'); ?>
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h3 id="trx-judul text-center text-bold" style="font-weight: bold; text-align: center">Form Pendaftaran Peserta</h3>
						</div>
						<div class="modal-body">
							<div class="row-fluid">
								<div class="box-body">
									<div id="form-pesan-tambah"></div>
									<div class="form-group">
										<label>Email</label>
										<input type="email" class="form-control" id="tambah-email" name="tambah-email" placeholder="Email Peserta" autocomplete="off">
									</div>

									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" id="tambah-password" name="tambah-password" placeholder="Password" autocomplete="off">
									</div>

									<div class="form-group">
										<label>Nama Lengkap</label>
										<input type="text" class="form-control" id="tambah-nama" name="tambah-nama" placeholder="Nama Lengkap Peserta" autocomplete="off">
									</div>

									<div class="form-group">
										<label>Nama Sekolah</label>
										<input type="text" class="form-control" id="tambah-detail" name="tambah-detail" placeholder="Nama Sekolah" autocomplete="off">
									</div>

									<div class="form-group">
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
						</div>
						<div class="modal-footer">
							<button type="submit" id="tambah-simpan" class="btn btn-success">Daftar</button>
							<a href="#" class="btn btn-danger" data-dismiss="modal">Batal</a>
						</div>
					</div>
				</div>

				</form>
			</div>
	</section><!-- /.content -->
</div><!-- /.container -->

<script type="text/javascript">
	function showpassword() {
		var x = document.getElementById("password");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
	}
	$(function() {
		$('#username').focus();

		$('#show-password').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%' // optional
		});

		$('#show-password').on('ifChanged', function(event) {
			showpassword();
		});

		$('#form-login').submit(function() {
			$("#modal-proses").modal('show');
			$.ajax({
				url: "<?php echo site_url(); ?>/welcome/login",
				type: "POST",
				data: $('#form-login').serialize(),
				cache: false,
				success: function(respon) {
					var obj = $.parseJSON(respon);
					if (obj.status == 1) {
						window.open("<?php echo site_url(); ?>/tes_dashboard", "_self");
					} else {
						$('#form-pesan').html(pesan_err(obj.error));
						$("#modal-proses").modal('hide');
						$('#username').focus();
					}
				}
			});

			return false;
		});
	});

	$('#btnModalTambah').on('click', function() {
		$('#modal-tambah').modal('show')
	})

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
					$("#modal-proses").modal('hide');
					$("#modal-tambah").modal('hide');
					notify_success(obj.pesan);
				} else {
					$("#modal-proses").modal('hide');
					$('#form-pesan-tambah').html(pesan_err(obj.pesan));
				}
			}
		});
		return false;
	});

	function notify_success(pesan) {
		new PNotify({
			title: 'Berhasil',
			text: pesan,
			type: 'success',
			history: false,
			delay: 4000,
		});
	}
</script>