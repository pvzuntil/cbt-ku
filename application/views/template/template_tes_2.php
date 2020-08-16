<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title><?php if (!empty($site_name)) {
            echo $site_name;
          } ?> | <?php echo $title; ?></title>

  <meta name="__base_url" content="<?= base_url() ?>">
  <?php include 'required/css.php' ?>
  <?php include 'required/js.php' ?>

</head>

<?php

$classBody = '';
if ($url == 'login') {
  $classBody = '';
}
?>

<body class="pr-0 layout-fixed layout-navbar-fixed <?= $classBody ?>">
  <div class="wrapper">

    <?php if ($url != 'login') : ?>
      <?php include 'required/navbar-user.php' ?>
    <?php endif ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-left: 0px !important;">
      <?php
      if (!empty($content)) {
        echo $content;
      }
      ?>
    </div><!-- /.content-wrapper -->

    <?php include 'required/footer-user.php' ?>

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

  <script>
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

      //TODO Form Ubah Password
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