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

  <div class="modal fade" id="modal-ubah-password" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Change Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <?php echo form_open('manager/dashboard/password', 'id="form-password"') ?>
        <div class="modal-body">
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
        <div class="modal-footer d-flex" style="justify-content: space-between;">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="password-submit">Change</button>
        </div>
        <?php echo form_close(); ?>
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

      $('#modal-ubah-password').on('shown.bs.modal', function(e) {
        $('#password-old').val('');
        $('#password-new').val('');
        $('#password-confirm').val('');
        $('#password-old').focus();
      });

      $('#form-password').submit(function() {
        SW.loading()
        $.ajax({
          url: "<?php echo site_url(); ?>/tes_dashboard/password",
          type: "POST",
          data: $('#form-password').serialize(),
          cache: false,
          success: function(respon) {
            var obj = $.parseJSON(respon);
            if (obj.status == 1) {
              SW.toast({
                title: 'Berhasil mengubah password',
                icon: 'success'
              })
              $('#modal-ubah-password').modal('hide')
            } else {
              SW.toast({
                title: obj.error,
                icon: 'error'
              })
            }
          }
        });
        return false;
      });
    });
  </script>
</body>

</html>