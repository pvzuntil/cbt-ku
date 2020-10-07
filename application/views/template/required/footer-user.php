<footer class="main-footer text-sm" style="margin-left: 0px !important;">
    <strong>Copyright &copy; <?= date('Y') ?> <?php echo $site_ket . ' - ' . $site_name?>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> <?php if (!empty($site_version)) {
                            echo $site_version;
                        } ?>
    </div>
</footer>