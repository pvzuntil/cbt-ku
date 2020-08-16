    <nav class="main-header navbar navbar-expand navbar-dark navbar-cyan" style="margin-left: 0px !important;">
        <ul class="navbar-nav">
            <li class="nav-item d-flex" style="height: 100%; align-items: center; justify-content: center;">
                <a href="<?= base_url() ?>" style="font-size: 1.3em; font-weight: 600;" class="text-white ml-3">CBT - <?php if (!empty($site_name)) {
                                                                                                                            echo $site_name;
                                                                                                                        } ?></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item d-flex" style="align-items: center; justify-content: center;">
                <p id="timestamp" class="text-white m-0"></p>
            </li>
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
            <li class="nav-item ml-2">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" id="btn-logout-user">
                    <i class="fas fa-power-off"></i>
                </a>
            </li>
        </ul>
    </nav>