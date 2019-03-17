<?php

function nks_clear_value($value)
{
    if (substr($value, -1) == '%') {
        return $value;
    } else {
        if (substr($value, -2) == 'px') {
            return $value;
        } else {
            $value = preg_replace('/[^0-9]/', '', $value);

            return $value.'px';
        }
    }
    return false;
}


$bg = $options['nks_cc_image_bg'];
$width = !empty($options['nks_cc_sidebar_width']) ? $options['nks_cc_sidebar_width'] : 400;
$pwidth = $width + 60;
$sidebar_type = $options['nks_cc_sidebar_type'];
if (NKS_MODE === 'demo') {
    $sidebar_type = isset($_GET['nks_sidebar_type']) ? esc_html($_GET['nks_sidebar_type']) : $sidebar_type;
}

$opacityLevel = $options['nks_cc_fade_content'] === 'light' ? 0.3 : ($options['nks_cc_fade_content'] === 'dark' ? 0.7 : 0);
?>

<style type="text/css" id="nks-dynamic-styles">
    @font-face{
        font-family: 'FontAwesome';
        src: url('<?php echo plugins_url();?>/NKS-custom/fonts/fontawesome-webfont.eot?v=4.3.0');
        src: url('<?php echo plugins_url();?>/NKS-custom/fonts/fontawesome-webfont.eot?#iefix&v=4.3.0') format('embedded-opentype'),
        url('<?php echo plugins_url();?>/NKS-custom/fonts/fontawesome-webfont.svg?v=4.3.0#fontawesomeregular') format('svg'),
        url('<?php echo plugins_url();?>/NKS-custom/fonts/fontawesome-webfont.woff?v=4.3.0') format('woff'),
        url('<?php echo plugins_url();?>/NKS-custom/fonts/fontawesome-webfont.ttf?v=4.3.0') format('truetype');
        font-weight: normal;
        font-style: normal
    }

    <?php if(!empty($bg) && strpos($bg, 'none') === false): ?>
    #nks_cc_sidebar{
        background-image: url(<?php echo plugins_url('/img/bg/' . $bg . '.jpg', __FILE__) ; ?>);
    }

    <?php if(strpos($bg, 'blur') !== false): ?>
    #nks_cc_sidebar{
        background-repeat: no-repeat;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        background-size: cover;
        background-position: 0 0;
    }

    <?php endif; ?>
    <?php endif; ?>

    <?php if($sidebar_type === 'push'): ?>

    #nks_cc_sidebar{
        width: <?php echo $pwidth; ?>px;
        left: -<?php echo $pwidth; ?>px;
    }

    #nks_cc_sidebar .nks_cc_sidebar_cont{
        width: <?php echo $width; ?>px;
    }

    .nks_cc_sidebar_pos_right #nks_cc_sidebar{
        right: -<?php echo $pwidth; ?>px;
    }

    body.nks_cc_exposed > *, body.nks_cc_exposed #nks-overlay-wrapper{
        -webkit-transform: translate(<?php echo $width; ?>px, 0);
        -moz-transform: translate(<?php echo $width; ?>px, 0);
        -ms-transform: translate(<?php echo $width; ?>px, 0);
        -o-transform: translate(<?php echo $width; ?>px, 0);
        transform: translate(<?php echo $width; ?>px, 0);
        -webkit-transform: translate3d(<?php echo $width; ?>px, 0, 0);
        -moz-transform: translate3d(<?php echo $width; ?>px, 0, 0);
        -ms-transform: translate3d(<?php echo $width; ?>px, 0, 0);
        -o-transform: translate3d(<?php echo $width; ?>px, 0, 0);
        transform: translate3d(<?php echo $width; ?>px, 0, 0);
    }


    body.nks_cc_sidebar_pos_right.nks_cc_exposed > *, body.nks_cc_sidebar_pos_right.nks_cc_exposed #nks-overlay-wrapper{
        -webkit-transform: translate(-<?php echo $width; ?>px, 0);
        -moz-transform: translate(-<?php echo $width; ?>px, 0);
        -ms-transform: translate(-<?php echo $width; ?>px, 0);
        -o-transform: translate(-<?php echo $width; ?>px, 0);
        transform: translate(-<?php echo $width; ?>px, 0);
        -webkit-transform: translate3d(-<?php echo $width; ?>px, 0, 0);
        -moz-transform: translate3d(-<?php echo $width; ?>px, 0, 0);
        -ms-transform: translate3d(-<?php echo $width; ?>px, 0, 0);
        -o-transform: translate3d(-<?php echo $width; ?>px, 0, 0);
        transform: translate3d(-<?php echo $width; ?>px, 0, 0);
    }

    <?php endif; ?>

    <?php if($sidebar_type === 'slide'): ?>
    #nks_cc_sidebar{
        width: <?php echo $width; ?>px;
        overflow: hidden;
    }

    #nks_cc_sidebar .nks_cc_sidebar_cont_scrollable{
        width: <?php echo $width; ?>px !important;
        padding-right: 60px;
    }

    .nks_mobile #nks_cc_sidebar .nks_cc_sidebar_cont_scrollable,
    .nks_mobile #nks_cc_sidebar .nks_cc_sidebar_cont{
        width: 100% !important;
    }

    #nks_cc_sidebar .nks_cc_sidebar_cont{
        width: <?php echo $width; ?>px !important;
    }

    body #nks_cc_sidebar{
        -webkit-transform: translate(-<?php echo $width; ?>px, 0);
        -moz-transform: translate(-<?php echo $width; ?>px, 0);
        -ms-transform: translate(-<?php echo $width; ?>px, 0);
        -o-transform: translate(-<?php echo $width; ?>px, 0);
        transform: translate(-<?php echo $width; ?>px, 0);
        -webkit-transform: translate3d(-<?php echo $width; ?>px, 0, 0);
        -moz-transform: translate3d(-<?php echo $width; ?>px, 0, 0);
        -ms-transform: translate3d(-<?php echo $width; ?>px, 0, 0);
        -o-transform: translate3d(-<?php echo $width; ?>px, 0, 0);
        transform: translate3d(-<?php echo $width; ?>px, 0, 0);
    }

    body.nks_cc_sidebar_pos_right #nks_cc_sidebar{
        -webkit-transform: translate(<?php echo $width; ?>px, 0);
        -moz-transform: translate(<?php echo $width; ?>px, 0);
        -ms-transform: translate(<?php echo $width; ?>px, 0);
        -o-transform: translate(<?php echo $width; ?>px, 0);
        transform: translate(<?php echo $width; ?>px, 0);
        -webkit-transform: translate3d(<?php echo $width; ?>px, 0, 0);
        -moz-transform: translate3d(<?php echo $width; ?>px, 0, 0);
        -ms-transform: translate3d(<?php echo $width; ?>px, 0, 0);
        -o-transform: translate3d(<?php echo $width; ?>px, 0, 0);
        transform: translate3d(<?php echo $width; ?>px, 0, 0);
    }

    body.nks_cc_exposed > .nks_cc_trigger_tabs{
        -webkit-transform: translate(<?php echo $width; ?>px, 0);
        -moz-transform: translate(<?php echo $width; ?>px, 0);
        -ms-transform: translate(<?php echo $width; ?>px, 0);
        -o-transform: translate(<?php echo $width; ?>px, 0);
        transform: translate(<?php echo $width; ?>px, 0);
        -webkit-transform: translate3d(<?php echo $width; ?>px, 0, 0);
        -moz-transform: translate3d(<?php echo $width; ?>px, 0, 0);
        -ms-transform: translate3d(<?php echo $width; ?>px, 0, 0);
        -o-transform: translate3d(<?php echo $width; ?>px, 0, 0);
        transform: translate3d(<?php echo $width; ?>px, 0, 0);
    }

    body.nks_cc_sidebar_pos_right.nks_cc_exposed > .nks_cc_trigger_tabs{
        -webkit-transform: translate(-<?php echo $width; ?>px, 0);
        -moz-transform: translate(-<?php echo $width; ?>px, 0);
        -ms-transform: translate(-<?php echo $width; ?>px, 0);
        -o-transform: translate(-<?php echo $width; ?>px, 0);
        transform: translate(-<?php echo $width; ?>px, 0);
        -webkit-transform: translate3d(-<?php echo $width; ?>px, 0, 0);
        -moz-transform: translate3d(-<?php echo $width; ?>px, 0, 0);
        -ms-transform: translate3d(-<?php echo $width; ?>px, 0, 0);
        -o-transform: translate3d(-<?php echo $width; ?>px, 0, 0);
        transform: translate3d(-<?php echo $width; ?>px, 0, 0);
    }

    <?php endif; ?>

    .nks_cc_exposed #nks-overlay{
        opacity: <?php echo $opacityLevel; ?>;
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=<?php echo $opacityLevel * 100; ?>)";
    }

    <?php if($opacityLevel != 0): ?>
    .nks_cc_exposed #nks-overlay:hover{
        cursor: pointer;
        cursor: url("<?php echo plugins_url('/img/', __FILE__);?>close2.png") 16 16, pointer;
    }

    <?php endif; ?>

    <?php if(isset($options['nks_cc_base_color'])): ?>
    #nks_cc_sidebar{
        background-color: <?php echo $options['nks_cc_base_color']; ?> !important;
    }

    <?php endif; ?>

    <?php

    for ($i = 1; $i <= $options['nks_cc_tabs']; $i++) {
        $col = (!empty($options['nks_cc_label_invert']) || !empty($options['nks_cc_label_stroke'])) ? 'white' : $options['nks_cc_label_color_' . $i];

            if(isset($options['nks_cc_label_color_' . $i])) {
         echo ".nks_cc_trigger_tabs #nks-tab-" . $i . " .fa:before  {
                    color: " . $options['nks_cc_label_color_' . $i] .";
          }";

         if (isset($col)) {
        echo ".nks_cc_trigger_tabs.nks_metro  #nks-tab-" . $i . " .fa-stack-2x {
                    background-color: " . $col .";
          }";
         }

    }

        if (isset($options['nks_cc_tab_tooltip_' . $i]) && $options['nks_cc_label_tooltip'] != 'none') {
            echo "
           .nks_cc_trigger_tabs #nks-tab-" . $i . ":after {
                        content: '" . $options['nks_cc_tab_tooltip_' . $i] ."';
                    }
            ";
        }

    if(isset($options['nks_cc_tab_bg_' . $i])) {
         echo "#nks-content-" . $i . " {
                    background-color: " . $options['nks_cc_tab_bg_' . $i] ." !important;
          }";
    }
    if(isset($options['nks_cc_tab_text_color_' . $i])) {
         echo "#nks-content-" . $i . ", #nks-content-" . $i . " p{
                    color: " . $options['nks_cc_tab_text_color_' . $i] ." !important;
          }";
    }
    if(isset($options['nks_cc_tab_image_bg_' . $i]) && $options['nks_cc_tab_image_bg_' . $i] !== 'none') {
      $bg = $options['nks_cc_tab_image_bg_' . $i];
         echo "#nks-content-" . $i . " {
                background-image: url(" . plugins_url('/img/bg/' . $bg . '.jpg', __FILE__) . ");
          }";
    }
    }
    ?>
    <?php
?>
    <?php
        if(isset($options['nks_cc_sidebar_gaps'])):
        $gaps = nks_clear_value($options['nks_cc_sidebar_gaps']);
    ?>
    .nks-content > div{
        padding: <?php echo $gaps; ?> !important;
    }

    <?php endif; ?>
    <?php if(isset($options['nks_cc_custom_bg'])): ?>
    .nks_cc_imagebg_custom{
        background-image: url(<?php echo $options['nks_cc_custom_bg']; ?>) !important;
    }

    <?php endif; ?>

    <?php if($options['nks_cc_sidebar_scale'] === 'yes'): ?>

    #nks_cc_sidebar .nks-content > div{
        -webkit-transition: -webkit-transform 0.4s ease-in-out 0.2s;
        -moz-transition: -moz-transform 0.4s ease-in-out 0.2s;
        -ms-transition: -ms-transform 0.4s ease-in-out 0.2s;
        -o-transition: -o-transform 0.4s ease-in-out 0.2s;
        transition: transform 0.4s ease-in-out;
        -webkit-backface-visibility: hidden;
    }

    #nks_cc_sidebar .nks-content > div.nks-shrinked{
        -webkit-transform: scale(0.9, 0.9) !important;
        -moz-transform: scale(0.9, 0.9) !important;
        -ms-transform: scale(0.9, 0.9) !important;
        transform: scale(0.9, 0.9) !important;
        -webkit-transform-origin: top center;
        -moz-transform-origin: top center;
        -ms-transform-origin: top center;
        transform-origin: top center;
    }

    <?php endif; ?>

    .nks_mobile .nks_cc_trigger_tabs{
        top: <?php echo $options['nks_cc_label_top_mob'] ?> !important;
    }

    <?php
      for ($i = 1; $i <= $options['nks_cc_tabs']; $i++) {
         if(isset($options['nks_cc_css_' . $i])) {
           echo $options['nks_cc_css_' . $i];
         }
        }
    ?>

    <?php if($options['nks_cc_label_tooltip'] == 'hover'): ?>

    .nks_mobile .nks_cc_trigger_tabs .nks-tab:after{
        display: none !important;
    }

    .nks_cc_trigger_tabs .nks-tab:after{
        opacity: 0;
        visibility: hidden;
        background-color: <?php echo $options['nks_cc_tooltip_color'] ?>;
        position: absolute;
        padding: 6px 14px;
        top: 50%;
        margin-top: -20px;
        left: 110%;
        font-family: inherit;
        font-size: 14px;
        line-height: 28px;
        white-space: nowrap;
        border-radius: 20px;
        -moz-border-radius: 20px;
        -webkit-border-radius: 20px;
        color: #FFF;
        -webkit-transition: opacity 0.25s cubic-bezier(0.645, 0.045, 0.355, 1), visibility 0s 0.25s;
        -moz-transition: opacity 0.25s cubic-bezier(0.645, 0.045, 0.355, 1), visibility 0s 0.25s;
        -ms-transition: opacity 0.25s cubic-bezier(0.645, 0.045, 0.355, 1), visibility 0s 0.25s;
        -o-transition: opacity 0.25s cubic-bezier(0.645, 0.045, 0.355, 1), visibility 0s 0.25s;
        transition: opacity 0.25s cubic-bezier(0.645, 0.045, 0.355, 1), visibility 0s 0.25s;
        -webkit-backface-visibility: hidden;
    }

    body.nks_cc_hidden .nks_cc_trigger_tabs .nks-tab:hover:after{
        opacity: 1;
        visibility: visible;
        -webkit-transition: opacity 0.25s cubic-bezier(0.645, 0.045, 0.355, 1);
        -moz-transition: opacity 0.25s cubic-bezier(0.645, 0.045, 0.355, 1);
        -ms-transition: opacity 0.25s cubic-bezier(0.645, 0.045, 0.355, 1);
        -o-transition: opacity 0.25s cubic-bezier(0.645, 0.045, 0.355, 1);
        transition: opacity 0.25s cubic-bezier(0.645, 0.045, 0.355, 1);
    }

    .nks_cc_sidebar_pos_right .nks_cc_trigger_tabs .nks-tab:after{
        right: 110%;
        left: auto;
    }

    .nks_cc_trigger_tabs.nks_metro .nks-tab:after{
        left: 100%;
        border-radius: 0px;
        -moz-border-radius: 0px;
        -webkit-border-radius: 0px;
    }

    .nks_cc_sidebar_pos_right .nks_cc_trigger_tabs.nks_metro .nks-tab:after{
        right: 100%;
        left: auto;
    }

    .nks_cc_trigger_tabs.nks_metro .nks-tab.fa-2x:after{
        padding: 10px 14px;
        margin-top: -24px;
    }

    .nks_cc_trigger_tabs.nks_metro .nks-tab.fa-3x:after{
        padding: 21px 14px;
        margin-top: -35px
    }

    <?php endif; ?>

</style>

<div id="nks_cc_sidebar" class="<?php echo 'nks_cc_imagebg_'.$bg; ?>">
    <div class="nks_cc_sidebar_cont_scrollable">
        <div class="nks_cc_sidebar_cont">

            <?php
            for ($i = 1; $i <= $options['nks_cc_tabs']; $i++) {

                //browser()->log('indi');
                //browser()->log($nks_init);
                $tab = 'tab_'.$i;
                if (isset($nks_init->$tab) && $nks_init->$tab) {
                    echo "<div id='nks-content-".$i."' class='nks-content'><div class='nks-shrinked'>";
                    if (isset($options['nks_cc_content_'.$i])) {
                        echo do_shortcode($options['nks_cc_content_'.$i]);
                    }
                    dynamic_sidebar('nks_area_'.$i);
                    echo "</div></div>";
                }
            }
            ?>
        </div>
    </div>
</div>

<?php

$inverse_bg = '';
if (empty($options['nks_cc_label_invert']) && !$options['nks_cc_label_stroke']) {
    $inverse_bg = 'fa-inverse';
}

$metro = !empty($options['nks_cc_metro']) ? ' nks_metro' : '';
echo '<div class="nks_cc_trigger_tabs nks_cc_label_'.$options['nks_cc_label_vis'].$metro.'" style="top:'.$options['nks_cc_label_top'].'">';
for ($i = 1; $i <= $options['nks_cc_tabs']; $i++) {
    $tab = 'tab_'.$i;
    $set = LA_IconManager::getSet($options['nks_cc_fa_icon_'.$i]) ? LA_IconManager::getSet($options['nks_cc_fa_icon_'.$i]) : 'Font Awesome';
    if ($set) {
        if ($set === '####') {
            $icon = LA_IconManager::getIcon($options['nks_cc_fa_icon_'.$i]);
            $icon = '<i style="background: url('.$icon.')" class="fa la_icon_manager_custom fa-stack-1x '.$inverse_bg.'"></i>';
        } else {
            $icon = $options['nks_cc_fa_icon_'.$i];
            $icon = LA_IconManager::getSet($icon) ? $icon : $set.'_####_'.str_replace('fa-', '', $icon);
            $icon = LA_IconManager::getIconClass($icon);
            $icon = '<i class="fa '.$icon.' fa-stack-1x '.$inverse_bg.'"></i>';
        }
        if (isset($nks_init->$tab) && $nks_init->$tab) {
            if ($options['nks_cc_label_stroke']) {
                $style = $options['nks_cc_label_style_'.$i] === 'circle' ? 'circle-thin' : 'square-o';
            } else {
                $style = $options['nks_cc_label_style_'.$i];
            }

            $link = $options['nks_cc_link_'.$i];

            $inverse = '';
            if (!empty($options['nks_cc_label_invert']) && !$options['nks_cc_label_stroke']) {
                $inverse = 'fa-inverse';
            }

            if (!empty($link)) {
                $target = '';
                if (!empty($options['nks_cc_link_target_'.$i])) {
                    $target = 'target="_blank"';
                }

                echo '<a href="'.$link.'" '.$target.' id="nks-tab-'.$i.'" class="nks-tab fa-stack fa-lg fa-'.$options['nks_cc_label_size'].'">
                    <i class="fa fa-'.$style.' fa-stack-2x '.$inverse.'"></i> '.$icon.'
                </a>';
            } else {
                echo '<span id="nks-tab-'.$i.'" '.$link.' class="nks-tab fa-stack fa-lg fa-'.$options['nks_cc_label_size'].'">
                    <i class="fa fa-'.$style.' fa-stack-2x '.$inverse.'"></i> '.$icon.'
                </span>';
            }
        }
    }
}
echo '</div>';
?>
<div id="nks-body-bg"></div>
<div id="nks-overlay-wrapper">
    <div id="nks-overlay"></div>
</div>
<script>
    (function ($) {
        if (!$ || !window.NKS_CC_Opts) return;

        var TYPE = NKS_CC_Opts.sidebar_type;
        var $bodybg = $('#nks-body-bg');
        var b = document.body;
        var $body = $('body');
        var bodyCss;

        // fix onload
        $(function () {
            setTimeout(function () {

                if (!$bodybg.parent().is($body)) {
                    $body.prepend($bodybg).prepend($('.nks_cc_trigger_tabs')).prepend($('#nks_cc_sidebar')).append($('#nks-overlay-wrapper'));
                }

                if (TYPE === 'push') {
                    $bodybg.css('backgroundColor', $body.css('backgroundColor'))
                }

            }, 0)
        })

        if (TYPE === 'push') {

            bodyCss = {
                'backgroundColor': $body.css('backgroundColor'),
                'backgroundImage': $body.css('backgroundImage'),
                'backgroundAttachment': $body.css('backgroundAttachment'),
                'backgroundSize': $body.css('backgroundSize'),
                'backgroundPosition': $body.css('backgroundPosition'),
                'backgroundRepeat': $body.css('backgroundRepeat'),
                'backgroundOrigin': $body.css('backgroundOrigin'),
                'backgroundClip': $body.css('backgroundClip')
            };

            if (bodyCss.backgroundColor.indexOf('(0, 0, 0, 0') + 1 || bodyCss.backgroundColor.indexOf('transparent') + 1) {
                bodyCss.backgroundColor = '#fff';
            }

            if (bodyCss.backgroundAttachment === 'fixed') {
                NKS_CC_Opts.isBgFixed = true;
                bodyCss.position = 'fixed';
                bodyCss.bottom = 0;
                bodyCss.backgroundAttachment = 'scroll';
            } else {
//				bodyCss.height = Math.max(
//					b.scrollHeight, document.documentElement.scrollHeight,
//					b.offsetHeight, document.documentElement.offsetHeight,
//					b.clientHeight, document.documentElement.clientHeight
//				)
            }

            $bodybg.css(bodyCss);

        } else {
            //$body.addClass('nks_sidebar_slide')
        }

    })(window.jQuery)
</script>



