<?php
/**
 * OSJC Theme Functions
 * 
 * Funções principais do tema WordPress
 * Mantém 100% da funcionalidade original do site HTML
 */

// Definir constantes do tema
define('OSJC_VERSION', '1.0.0');
define('OSJC_THEME_DIR', get_template_directory());
define('OSJC_THEME_URI', get_template_directory_uri());

/**
 * Configuração do tema
 */
function osjc_setup() {
    // Suporte para título automático
    add_theme_support('title-tag');
    
    // Suporte para imagens destacadas
    add_theme_support('post-thumbnails');
    
    // Suporte para HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    
    // Suporte para logo customizado
    add_theme_support('custom-logo', array(
        'height'      => 90,
        'width'       => 90,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Registrar menus
    register_nav_menus(array(
        'primary' => __('Menu Principal', 'osjc'),
        'footer'  => __('Menu Rodapé', 'osjc'),
    ));
    
    // Suporte para feed automático
    add_theme_support('automatic-feed-links');

    // Suporte ao Elementor e recursos de layout amplo
    add_theme_support('align-wide');
    add_theme_support('elementor');
}
add_action('after_setup_theme', 'osjc_setup');

/**
 * Registrar localizacoes do Theme Builder (Elementor Pro)
 */
function osjc_register_elementor_locations($elementor_theme_manager) {
    $elementor_theme_manager->register_all_core_location();
}
add_action('elementor/theme/register_locations', 'osjc_register_elementor_locations');

/**
 * Enfileirar estilos e scripts
 */
function osjc_scripts() {
    // CSS Principal
    wp_enqueue_style('osjc-style', OSJC_THEME_URI . '/assets/css/style.css', array(), OSJC_VERSION);
    
    // CSS Doe Aqui (condicional)
    if (is_page_template('page-doe-aqui.php') || is_page('doe-aqui')) {
        wp_enqueue_style('osjc-doe-aqui', OSJC_THEME_URI . '/assets/css/doe-aqui.css', array('osjc-style'), OSJC_VERSION);
        
        // Font Awesome para ícones
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    }
    
    // JavaScript Principal
    wp_enqueue_script('osjc-main', OSJC_THEME_URI . '/assets/js/main.js', array('jquery'), OSJC_VERSION, true);
    
    // JavaScript Doe Aqui (condicional)
    if (is_page_template('page-doe-aqui.php') || is_page('doe-aqui')) {
        wp_enqueue_script('osjc-doe-aqui', OSJC_THEME_URI . '/assets/js/doe-aqui.js', array('osjc-main'), OSJC_VERSION, true);
    }
    
    // JavaScript Instagram Feed
    wp_enqueue_script('osjc-instagram-feed', OSJC_THEME_URI . '/assets/js/instagram-feed.js', array('osjc-main'), OSJC_VERSION, true);
    
    // Localizar script para AJAX se necessário
    wp_localize_script('osjc-main', 'osjcAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('osjc-nonce'),
    ));
    
    // Comentários
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'osjc_scripts');

/**
 * Função auxiliar para obter URL de imagem
 */
function osjc_get_image_url($filename) {
    return OSJC_THEME_URI . '/assets/images/' . $filename;
}

/**
 * Função auxiliar para obter URL de asset
 */
function osjc_get_asset_url($filename) {
    return OSJC_THEME_URI . '/assets/images/' . $filename;
}

/**
 * Classes personalizadas para o body
 */
function osjc_body_classes($classes) {
    // Adicionar classe se for página inicial
    if (is_front_page()) {
        $classes[] = 'home-page';
    }
    
    return $classes;
}
add_filter('body_class', 'osjc_body_classes');

/**
 * Personalizar tamanho de excerpt
 */
function osjc_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'osjc_excerpt_length');

/**
 * Personalizar texto de "read more"
 */
function osjc_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'osjc_excerpt_more');

/**
 * Menu de fallback caso não tenha menu configurado
 */
function osjc_fallback_menu() {
    echo '<ul>';
    echo '<li><a href="' . esc_url(home_url('/')) . '" class="nav-link">' . __('Home', 'osjc') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/quem-somos')) . '" class="nav-link">' . __('Quem Somos', 'osjc') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/programas')) . '" class="nav-link">' . __('Programas', 'osjc') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/blog')) . '" class="nav-link">' . __('Blog', 'osjc') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/transparencia')) . '" class="nav-link">' . __('Transparência', 'osjc') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contato')) . '" class="nav-link">' . __('Contato', 'osjc') . '</a></li>';
    echo '</ul>';
}
