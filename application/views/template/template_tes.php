<!-- Made with ♥ By pvzuntill.github.io -->
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title><?php if (!empty($site_name)) {
            echo $site_name;
          } ?> | <?php echo $title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content='width=device-width, initial-scale=0.9, minimum-scale=0.1, maximum-scale=10, user-scalable=yes' name='viewport'>

  <?php include 'required/css.php' ?>
  <?php include 'required/js.php' ?>

</head>

<body class="skin-yellow layout-top-nav">
  <div class="wrapper">

    <header class="main-header">
      <nav class="navbar navbar-static-top">
        <div class="container">
          <div class="navbar-header">
            <a href="<?php echo base_url(); ?>" class="navbar-brand"> <b><?php if (!empty($site_name)) {
                                                                            echo $site_name;
                                                                          } ?></b></a>
          </div>

          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <ul class="nav navbar-nav">
                <li><a href="#"><span id="timestamp"></span></a></li>
              </ul>
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url(); ?>public/images/avatar.png" class="user-image" alt="User Image" />
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php if (!empty($nama)) {
                                            echo $nama;
                                          } else {
                                            echo 'User Tes';
                                          } ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header" style="max-height: 70px;">
                    <p>
                      <?php if (!empty($nama)) {
                        echo $nama;
                      } else {
                        echo 'User Tes';
                      } ?>
                      <?php if (!empty($group)) {
                        echo ' | ' . $group;
                      } ?>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a data-toggle="modal" href="#modal-profile" class="btn btn-default btn-flat">Profile</a>
                      <a data-toggle="modal" href="#modal-password" class="btn btn-default btn-flat">Password</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo site_url(); ?>/welcome/logout" class="btn btn-default btn-flat">Log out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div><!-- /.navbar-custom-menu -->
        </div><!-- /.container-fluid -->
      </nav>
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper <?= $url == 'tes_dashboard' ? 'back-body' : '' ?>">
      <?php
      if (!empty($content)) {
        echo $content;
      }
      ?>
    </div><!-- /.content-wrapper -->
    <footer class="main-footer no-print">
      <div class="pull-right hidden-xs">
        <?php if (!empty($nama)) {
          echo $nama;
        } ?> | <strong> <a href="<?php echo site_url(); ?>/welcome/logout">Log out</a></strong>
      </div>
      <div class="container">
        <strong>&copy; 2020 QEC - Quantum Education Competition</strong>
      </div><!-- /.container -->
    </footer>
  </div><!-- ./wrapper -->

  <div class="modal" id="modal-password" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open('tes_dashboard/password', 'id="form-password"') ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Ubah Password</h4>
        </div>
        <div class="modal-body">
          <span id="form-pesan-password"></span>
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="password-submit">Ubah Password</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    <?php echo form_close(); ?>
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


  <script type="text/javascript">
    $(function() {
      var serverTime = <?php
                        if (!empty($timestamp)) {
                          echo $timestamp;
                        } ?>;
      var counterTime = 0;
      var date;

      setInterval(function() {
        date = new Date();

        serverTime = serverTime + 1;

        date.setTime(serverTime * 1000);
        time = date.toLocaleTimeString();
        $("#timestamp").html(time);
      }, 1000);

      $('#modal-password').on('shown.bs.modal', function(e) {
        $('#form-pesan-password').html('');
        $('#password-old').val('');
        $('#password-new').val('');
        $('#password-confirm').val('');
        $('#password-old').focus();
      });

      $('#form-password').submit(function() {
        $.ajax({
          url: "<?php echo site_url(); ?>/tes_dashboard/password",
          type: "POST",
          data: $('#form-password').serialize(),
          cache: false,
          success: function(respon) {
            var obj = $.parseJSON(respon);
            if (obj.status == 1) {
              $('#form-pesan-password').html('');
              $('#modal-password').modal('hide');
              notify_success('Password berhasil diubah');
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