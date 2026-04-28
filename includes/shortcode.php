<?php

function sp_shortcode($atts) {

    $atts = shortcode_atts(['id'=>''],$atts);
    if(!$atts['id']) return '';

    $target = get_post_meta($atts['id'],'sp_target',true);
    $selector = get_post_meta($atts['id'],'sp_item_selector',true);
    $per_page = get_post_meta($atts['id'],'sp_per_page',true);

    $primary = get_post_meta($atts['id'],'sp_primary_color',true);
    $text = get_post_meta($atts['id'],'sp_text_color',true);
    $border = get_post_meta($atts['id'],'sp_border_color',true);

    $editable = get_post_meta($atts['id'],'sp_editable',true);
    $first_last = get_post_meta($atts['id'],'sp_first_last',true);

    ob_start();
?>

<style>
.sp-pagination[data-id="<?php echo $atts['id']; ?>"] {
 border-color: <?php echo $border ?: '#ff4d6d'; ?>;
}
.sp-pagination[data-id="<?php echo $atts['id']; ?>"] .pg-btn,
.sp-pagination[data-id="<?php echo $atts['id']; ?>"] .pg-info {
 color: <?php echo $text ?: '#ff4d6d'; ?>;
}
</style>

<div class="sp-pagination"
     data-id="<?php echo $atts['id']; ?>"
     data-target="<?php echo esc_attr($target); ?>"
     data-items-per-page="<?php echo esc_attr($per_page); ?>"
     data-item-selector="<?php echo esc_attr($selector); ?>"
     data-editable="<?php echo $editable ? 'true':'false'; ?>"
     data-first-last="<?php echo $first_last ? 'true':'false'; ?>">
    <div class="pg_btn_wrap">
        <button class="pg-btn first">«</button>
        <button class="pg-btn prev">‹</button>
    </div>
    <span class="pg-info">
        Page <span class="current-page">1</span>
        of <span class="total-pages">1</span>
    </span>
    <div class="pg_btn_wrap">
        <button class="pg-btn next">›</button>
        <button class="pg-btn last">»</button>
    </div>
</div>

<?php
return ob_get_clean();
}
add_shortcode('smart_pagination','sp_shortcode');