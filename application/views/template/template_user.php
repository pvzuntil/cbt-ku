<!-- Made with ♥ By pvzuntil.github.io -->

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title><?php if (!empty($site_name)) {
            echo $site_name;
          } ?> | <?php echo $title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content='width=device-width, initial-scale=1, maximum-scale=10, user-scalable=yes' name='viewport'>

  <meta name="author" content="YasaPintar" />
  <meta name="copyright" content="YasaPintar" />
  <meta name="description" content="Kompetisi Online berbasis website di tuban jawa timmur" />
  <meta name="keywords" content="YasaPintar kompetisi tuban kompetisi online" />

  <?php include 'required/css.php' ?>
  <?php include 'required/js.php' ?>

  <?php if (@$url == 'welcome') : ?>
    <style>
      .back-body {
        background-image: url('<?php echo base_url(); ?>public/images/back.jpg');
        background-position: center;
        background-size: cover;
      }

      .shadow-box {
        /* box-shadow: 6px 6px 10px 0px #00000070; */
        box-shadow:
          0 2.3px 16.1px rgba(0, 0, 0, 0.06),
          0 5.1px 24.7px rgba(0, 0, 0, 0.051),
          0 9.7px 31.5px rgba(0, 0, 0, 0.046),
          0 19.3px 39px rgba(0, 0, 0, 0.043),
          0 48px 50.5px rgba(0, 0, 0, 0.04),
          0 128px 83px rgba(0, 0, 0, 0.033);
      }

      .counter {
        margin-bottom: 0px;
        display: flex;
      }

      .counter li {
        /* display: inline-block; */
        /* font-size: 1.5em; */
        list-style-type: none;
        padding: 0 .6em;
        text-transform: uppercase;
        text-align: center;
      }

      .counter li span {
        /* display: block; */
        /* font-size: 4.5rem; */
        margin-right: 3px;
      }
    </style>
  <?php endif ?>
</head>

<?php
$classBody = '';

if (@$url == 'welcome') {
  $classBody = 'hold-transition login-page back-body';
} else {
  $classBody = 'hold-transition';
}

?>


<body class="<?= $classBody ?>">
  <?php
  if (!empty($content)) {
    echo $content;
  }
  ?>
</body>

<script type="text/javascript">
  $(function() {
    var serverTime = <?php
                      if (!empty($timestamp)) {
                        echo $timestamp;
                      } else {
                        echo 0;
                      } ?>;
    var counterTime = 0;
    var date;

    if (serverTime != 0) {
      setInterval(function() {
        date = new Date();
        serverTime = serverTime + 1;
        date.setTime(serverTime * 1000);
        time = date.toLocaleTimeString();
        $("#timestamp").html(time);
      }, 1000);
    }

  });
</script>
</body>

</html>