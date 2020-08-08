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

<body class="sidebar-mini pr-0">
  <div class="wrapper">
    <?php include 'required/navbar-admin.php' ?>

    <?php include 'required/sidemenu.php' ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php
      if (!empty($content)) {
        echo $content;
      }
      ?>
    </div><!-- /.content-wrapper -->

    <?php include 'required/footer.php' ?>

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