<?php

function sp_register_cpt() {
    register_post_type('sp_pagination', [
        'label' => 'Smart Pagination',
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-editor-ol',
        'supports' => ['title'],
    ]);
}
add_action('init', 'sp_register_cpt');