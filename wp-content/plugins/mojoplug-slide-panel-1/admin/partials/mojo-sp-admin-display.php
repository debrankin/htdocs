<?php
/**
 * Provide a admin area view for the plugin
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    MojoPlug_Slide_Panel
 * @subpackage MojoPlug_Slide_Panel/admin/partials
 */
?>

<div class="wrap">
    <div style="background: #303030; padding: 10px; padding-bottom: 15px; margin-bottom: 20px;">
        <img src="<?php echo plugin_dir_url( __FILE__ ) ?>../assets/logo_100h.png" style="display:block; margin-left: auto; margin-right: auto; margin: 0 auto;">
    </div>
    <h1><span class="dashicons dashicons-admin-generic" style="font-size: 30px; margin-right:15px;"></span><?php echo esc_html(get_admin_page_title()); ?></h1>
    <p>Activate a panel by adding at least one widget in it in Appearance->Widgets menu.</p>
    <p>Show a panel either with the built-in button or using the Link ID in any clickable link or button on your page. E.g. &lt;a href="" id="mojosp-toggle-left"&gt;Click Me&lt;/a&gt;</p>
    <p>Read more about how to use the plugin and see a demo in <a href="http://mojoplug.com/slide-panel" target="_blank">http://mojoplug.com/slide-panel</a></p>
    <form action="options.php" method="post">
        <?php
        settings_fields($this->mojo_sp);
        do_settings_sections($this->mojo_sp);
        submit_button();
        ?>
    </form>
</div>
