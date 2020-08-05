<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title><?php if (!empty($site_name)) {
            echo $site_name;
          } ?> | <?php echo $title; ?></title>

  <?php include 'required/css.php' ?>
  <?php include 'required/js.php' ?>

</head>

<body class="sidebar-mini layout-fixed">
  <div class="wrapper">

    <!--  -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-cyan">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" id="btn-logout">
            <i class="fas fa-power-off"></i>
          </a>
        </li>
      </ul>
    </nav>

    <aside class="main-sidebar elevation-4 sidebar-dark-info">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-light ml-2">Quantum Education Center</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">
        <div class="os-resize-observer-host">
          <div class="os-resize-observer observed" style="left: 0px; right: auto;"></div>
        </div>
        <div class="os-size-auto-observer" style="height: calc(100% + 1px); float: left;">
          <div class="os-resize-observer observed"></div>
        </div>
        <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 829px;"></div>
        <div class="os-padding">
          <div class="os-viewport os-viewport-native-scrollbars-invisible os-viewport-native-scrollbars-overlaid" style="overflow-y: scroll;">
            <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
              <!-- Sidebar Menu -->
              <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <li class="nav-item">
                    <a href="<?= base_url() ?>manager/dashboard" class="nav-link <?= $url == 'dashboard' ? 'active' : '' ?>">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>
                        Dashboard
                      </p>
                    </a>
                  </li>
                  <?php
                  if (!empty($sidemenu)) {
                    echo $sidemenu;
                  }
                  ?>
                </ul>
              </nav>
              <!-- /.sidebar-menu -->
            </div>
          </div>
        </div>
        <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
          <div class="os-scrollbar-track">
            <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
          </div>
        </div>
        <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
          <div class="os-scrollbar-track">
            <div class="os-scrollbar-handle" style="height: 65.9777%; transform: translate(0px, 0px);"></div>
          </div>
        </div>
        <div class="os-scrollbar-corner"></div>
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php
      if (!empty($content)) {
        echo $content;
      }
      ?>
    </div><!-- /.content-wrapper -->

    <footer class="main-footer">
      <strong>Copyright &copy; <?= date('Y') ?> QEC - Quantum Education Competition.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> <?php if (!empty($site_version)) {
                          echo $site_version;
                        } ?>
      </div>
    </footer>

  </div><!-- ./wrapper -->

  <div class="modal" id="modal-password" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Change Password</h4>
        </div>
        <div class="modal-body">
          <span id="form-pesan-password">
          </span>
          <?php echo form_open('manager/dashboard/password', 'id="form-password"') ?>
          <div class="box-body">
            <div class="form-group">
              <label>Old Password</label>
              <input type="password" class="form-control" id="password-old" name="password-old" placeholder="Old Password">
            </div>
            <div class="form-group">
              <label>New Password</label>
              <input type="password" class="form-control" id="password-new" name="password-new" placeholder="New Password">
            </div>
            <div class="form-group">
              <label>Confirm Password</label>
              <input type="password" class="form-control" id="password-confirm" name="password-confirm" placeholder="Confirm Password">
            </div>
          </div>
          <?php echo form_close(); ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="password-submit">Change</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div class="modal" id="modal-proses" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div style="text-align: center;">
            <img width="50" src="<?php echo base_url(); ?>public/images/loading.gif" /> <br />Data Sedang diproses...
          </div>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <script>
    $(function() {

      //Form Ubah Password
      $('#modal-password').on('shown.bs.modal', function(e) {
        $('#form-pesan-password').html('');
        $('#password-old').val('');
        $('#password-new').val('');
        $('#password-confirm').val('');
        $('#password-old').focus();
      });

      $('#password-submit').click(function() {
        $('#form-password').submit();
      });

      $('#form-password').submit(function() {
        $.ajax({
          url: "<?php echo site_url(); ?>/manager/dashboard/password",
          type: "POST",
          data: $('#form-password').serialize(),
          cache: false,
          success: function(respon) {
            var obj = $.parseJSON(respon);
            if (obj.status == 1) {
              $('#form-pesan-password').html(pesan_succ('Password berhasil diubah !'));
              setTimeout(function() {
                $('#modal-password').modal('hide')
              }, 1500);
            } else {
              $('#form-pesan-password').html(pesan_err(obj.error));
            }
          }
        });
        return false;
      });
    });
  </script>
</body>

</html>