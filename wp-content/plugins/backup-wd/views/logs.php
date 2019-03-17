<div class="wrap buwd" id="buwd-logs">
    <div class="update-nag wd_topic">
          <span class="wd_help_topic">
              This section allows you to view logs.
              <a target="_blank" href="http://docs.10web.io/docs/backup-wd/backup-logs">Read More in User Manual</a>
        </span>
    </div>

    <div class="buwd-clear"></div>
    <div class="buwd-messages"><?php $this->display_messages(); ?></div>
    <h1>Logs</h1>
    <form method="post" action="" id="buwd_form">
        <input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']); ?>"/>
        <input id="page" name="page" type="hidden" value="buwd_logs">
        <?php echo $this->display(); ?>
    </form>
</div>
<div id="buwd_overlay" class="buwd_overlay"></div>

