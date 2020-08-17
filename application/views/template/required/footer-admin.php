<footer class="main-footer text-sm" <?php if (@$url == 'login') : ?> style="margin-left: 0px !important;" <?php endif ?>>
    <strong>Copyright &copy; <?= date('Y') ?> QEC - Quantum Education Competition.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> <?php if (!empty($site_version)) {
                            echo $site_version;
                        } ?>
    </div>
</footer>