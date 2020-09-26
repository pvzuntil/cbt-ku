    <nav class="main-header navbar navbar-expand navbar-dark navbar-orange" style="margin-left: 0px !important;">
        <div class="row" style="width :100%">
            <div class="col-12 col-sm-6 d-flex align-items-center">
                <ul class="navbar-nav text-center text-md-left">
                    <li class="nav-item d-flex" style="height: 100%; align-items: center; justify-content: center;">
                        <a href="<?= base_url() ?>" style="font-weight: 600;" class="text-white ml-3"><?php if (!empty($site_name)) {
                                                                                                                                    echo $site_name;
                                                                                                                                } ?></a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-md-6 d-flex justify-content-md-end justify-content-center">
                <!-- Right navbar links -->
                <ul class="navbar-nav d-flex justify-content-md-end justify-content-center" style="width: 100%;">
                    <li class="nav-item d-flex mr-3" style="align-items: center; justify-content: center;">
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
                            <!-- <i class="fas fa-power-off"></i> -->
                            Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>