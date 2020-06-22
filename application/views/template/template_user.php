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
  <!-- Bootstrap 3.3.4 -->
  <link href="<?php echo base_url(); ?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- Font Awesome Icons -->
  <link href="<?php echo base_url(); ?>public/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

  <!-- Theme style -->
  <link href="<?php echo base_url(); ?>public/plugins/adminlte/css/AdminLTE.css" rel="stylesheet" type="text/css" />
  <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
  <link href="<?php echo base_url(); ?>public/plugins/adminlte/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

  <link href="<?php echo base_url(); ?>public/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

  <link href="<?php echo base_url(); ?>public/plugins/pnotify/pnotify.custom.min.css" rel="stylesheet" type="text/css" />

  <link rel="shortcut icon" href="<?php echo base_url(); ?>public/images/icon.png" type="image/x-icon">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->



  <!-- jQuery 2.1.4 -->
  <script src="<?php echo base_url(); ?>public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <!-- Bootstrap 3.3.2 JS -->
  <script src="<?php echo base_url(); ?>public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url(); ?>public/plugins/adminlte/js/app.min.js" type="text/javascript"></script>
  <!-- iCheck -->
  <script src="<?php echo base_url(); ?>public/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

  <script src="<?php echo base_url(); ?>public/app.js" type="text/javascript"></script>

  <script src="<?php echo base_url(); ?>public/plugins/pnotify/pnotify.custom.min.js" type="text/javascript"></script>

  <script src="<?php echo base_url(); ?>public/plugins/swal/swal.js" type="text/javascript"></script>

  <!-- <script src="https://www.google.com/recaptcha/api.js?render=6LcIHqYZAAAAAAjrpAdAIn2iqNyPNFsj8Tdcg4iY"></script> -->
  <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

  <style>
    .swal2-popup {
      font-size: 1.6rem !important;
    }
  </style>
  <?php if (@$url == 'welcome') : ?>
    <style>
      .back-body {
        background-image: url('<?php echo base_url(); ?>public/images/back.jpg');
        background-position: center;
        background-size: cover;
      }

      .shadow-box {
        box-shadow: 6px 6px 10px 0px #00000070;
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

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-104089728-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-104089728-1');
  </script>

  <style>
    .flyover {
      display: flex;
      width: 100%;
      position: fixed;
      background-color: #fcc604;
      top: 0;
      left: 0;
      z-index: 9999;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      padding: 10px 100px;
    }

    .close-button-flyover {
      position: absolute;
      right: 20px;
    }
  </style>

</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="skin-yellow layout-top-nav">
  <?php if (@$url == 'welcome') : ?>
    <!-- <div class="flyover">
      <button type="button" class="close close-button-flyover">×</button>
      <ul class="counter">
        <li><span id="days"></span>hari</li>
        <li><span id="hours"></span>jam</li>
        <li><span id="minutes"></span>menit</li>
        <li><span id="seconds"></span>detik</li>
      </ul>
      <div>Menuju pelaksanaan kompetisi Matematika & Sains Online</div>
    </div> -->
  <?php endif ?>

  <div class="wrapper">

    <?php if (@$url != 'welcome') : ?>
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
                <li><a href="#"><span id="timestamp"></span></a></li>
              </ul>
            </div>
          </div><!-- /.container-fluid -->
        </nav>
      </header>

    <?php endif ?>
    <!-- Full Width Column -->
    <div class="content-wrapper back-body">
      <?php
      if (!empty($content)) {
        echo $content;
      }
      ?>
    </div><!-- /.content-wrapper -->
    <footer class="main-footer no-print">
      <?php if (@$url != 'welcome') : ?>
        <div class="pull-right hidden-xs">
          <?php
          if (!empty($link_login_operator)) {
            if ($link_login_operator == 'ya') {
          ?>
              <strong> <a href="<?php echo site_url(); ?>/manager/">Log In Operator</a></strong>
            <?php
            }
          } else {
            ?>
            <strong> <a href="<?php echo site_url(); ?>/manager/">Log In Operator</a></strong>
          <?php
          }
          ?>
        </div>
      <?php endif ?>
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <strong>&copy; 2020 QEC - Quantum Education Competition</strong>
          </div>
        </div>
      </div><!-- /.container -->
    </footer>
  </div><!-- ./wrapper -->

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
      var serverTime = <?php if (!empty($timestamp)) {
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
      <?php if (@$url == 'welcome') : ?>
        // const second = 1000,
        //   minute = second * 60,
        //   hour = minute * 60,
        //   day = hour * 24;

        // let countDown = new Date('7 4 2020').getTime(),
        //   x = setInterval(function() {

        //     let now = new Date().getTime(),
        //       distance = countDown - now;

        //     document.getElementById('days').innerText = Math.floor(distance / (day)),
        //       document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour)),
        //       document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
        //       document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);
        //   }, second)
      <?php endif ?>

    });
  </script>
</body>

</html>