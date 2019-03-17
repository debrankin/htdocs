<?php
/**
 * Restore View
 */
?>
<div id="buwd-restore" class="buwd-page buwd-restore">
    <div class="update-nag wd_topic">
          <span class="wd_help_topic">
              This section allows you to restore a backup.
              <a target="_blank" href="http://docs.10web.io/docs/backup-wd/restore">Read More in User Manual</a>
        </span>
    </div>

    <div class="buwd-messages"><?php $this->display_messages(); ?></div>
    <div class="buwd-options buwd-restore">
        <form name="buwd-form" id="buwd-form" enctype="multipart/form-data" method="post"
              action="<?php echo esc_attr(network_admin_url('admin-post.php')) ?>">
            <?php wp_nonce_field('nonce_buwd', 'nonce_buwd');
            ?>

            <div class="buwd-tabs">
                <ul>
                    <li>
                        <a href="#buwd-restore-db" class="">
                            Restore Database
                        </a>
                    </li>
                    <li>
                        <a href="#buwd-restore-premium">
                            Restore Full Website
                        </a>
                    </li>
                </ul>
                <div class="buwd-tabs-container">
                    <div id="buwd-restore-db" class="buwd-tabs-content">
                        <div class="buwd-restore-header">
                            Restore Database
                        </div>
                        <div class="buwd-restore-text">
                            After downloading the <b>database backup file</b>, you are able to easily
                            restore it by uploading the package through Backup WD plugin. <br>Simply press Choose File
                            and
                            browse the backup file you wish to restore, then click Restore.
                        </div>

                        <div class="buwd-restore-fileupload">
                            <input id="upload_backup" name="upload_backup" type="file">
                        </div>

                        <input type="submit" id="save" name="save" class="buwd-restore-button" value="Restore"/>
                    </div>

                    <div id="buwd-restore-premium" class="buwd-tabs-content">
                        <div class="buwd-restore-header">
                            Restore Full Website
                        </div>

                        <div class="buwd-restore-text">
                            Full website restore is available only in <b>Premium version</b> of the plugin and if your
                            backup stores in 10Web cloud storage
                        </div>

                        <a class="buwd-restore-button" target="_blank" href="https://10web.io/services/backup/"> GET FREE
                            FOR 14 DAYS</a>
                    </div>

                </div>
            </div>


            <input type="hidden" id="current_tab" name="current_tab" value="<?php echo $current_tab; ?>">
            <input type="hidden" id="page" name="page" value="buwd_restore">
            <input type="hidden" id="action" name="action" value="buwd_save">
        </form>
    </div>
</div>
