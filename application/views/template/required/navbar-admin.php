    <nav class="main-header navbar navbar-expand navbar-dark navbar-cyan" <?php if ($url == 'login') : ?> style="margin-left: 0px !important;" <?php endif ?>>
        <ul class="navbar-nav">
            <!-- <li class="nav-item">
                    <h4>Halaman Administrator</h4>
                </li> -->
        </ul>
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                    <i class="fas fa-user-circle"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal-ubah-password">
                        <i class="fas fa-lock mr-2"></i> Change Password
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" id="btn-logout-admin">
                    <i class="fas fa-power-off"></i>
                </a>
            </li>
        </ul>
    </nav>