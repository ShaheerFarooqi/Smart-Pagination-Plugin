<?php

function sp_add_meta_box() {
    add_meta_box(
        'sp_settings',
        'Smart Pagination Settings',
        'sp_meta_box_html',
        'sp_pagination',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sp_add_meta_box');

function sp_meta_box_html($post) {

    $target = get_post_meta($post->ID, 'sp_target', true);
    $selector = get_post_meta($post->ID, 'sp_item_selector', true);
    $per_page = get_post_meta($post->ID, 'sp_per_page', true);

    $primary = get_post_meta($post->ID, 'sp_primary_color', true);
    $text = get_post_meta($post->ID, 'sp_text_color', true);
    $border = get_post_meta($post->ID, 'sp_border_color', true);

    $editable = get_post_meta($post->ID, 'sp_editable', true);
    $first_last = get_post_meta($post->ID, 'sp_first_last', true);
?>

<style>
.sp-tabs button { padding:10px 15px; cursor:pointer; }
.sp-tab { display:none; margin-top:15px; }
.sp-tab.active { display:block; }
</style>

<div class="sp-tabs">
    <button type="button" onclick="spTab(event,'general')">General</button>
    <button type="button" onclick="spTab(event,'design')">Design</button>
    <button type="button" onclick="spTab(event,'behavior')">Behavior</button>
</div>

<div id="general" class="sp-tab active">
    <label>Target Selector</label>
    <input type="text" name="sp_target" value="<?php echo esc_attr($target); ?>" style="width:100%;" />

    <br><br>

    <label>Item Selector</label>
    <input type="text" name="sp_item_selector" value="<?php echo esc_attr($selector); ?>" style="width:100%;" />

    <br><br>

    <label>Items Per Page</label>
    <input type="number" name="sp_per_page" value="<?php echo esc_attr($per_page); ?>" />
</div>

<div id="design" class="sp-tab">
    <label>Primary Color</label>
    <input type="color" name="sp_primary_color" value="<?php echo esc_attr($primary ?: '#ff4d6d'); ?>" />

    <br><br>

    <label>Text Color</label>
    <input type="color" name="sp_text_color" value="<?php echo esc_attr($text ?: '#ff4d6d'); ?>" />

    <br><br>

    <label>Border Color</label>
    <input type="color" name="sp_border_color" value="<?php echo esc_attr($border ?: '#ff4d6d'); ?>" />
</div>

<div id="behavior" class="sp-tab">
    <label><input type="checkbox" name="sp_editable" <?php checked($editable, 'on'); ?> /> Editable Page</label>
    <br><br>
    <label><input type="checkbox" name="sp_first_last" <?php checked($first_last, 'on'); ?> /> Show First/Last</label>
</div>

<p><strong>Shortcode:</strong> [smart_pagination id="<?php echo $post->ID; ?>"]</p>

<script>
function spTab(e,tab){
 document.querySelectorAll('.sp-tab').forEach(t=>t.classList.remove('active'));
 document.getElementById(tab).classList.add('active');
}
</script>

<?php
}

function sp_save_meta($post_id) {
    $fields = [
        'sp_target','sp_item_selector','sp_per_page',
        'sp_primary_color','sp_text_color','sp_border_color',
        'sp_editable','sp_first_last'
    ];

    foreach ($fields as $field) {
        $value = $_POST[$field] ?? '';
        update_post_meta($post_id, $field, $value);
    }
}
add_action('save_post', 'sp_save_meta');