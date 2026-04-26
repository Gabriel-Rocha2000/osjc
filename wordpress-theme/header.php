<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <meta name="keywords" content="obras sociais, centro espírita, educação, qualificação profissional, Sobradinho, DF, programas sociais">
    <meta property="og:title" content="<?php bloginfo('name'); ?>">
    <meta property="og:description" content="<?php bloginfo('description'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="<?php echo osjc_get_image_url('LOGO-JERONIMO-NEW-1-90x90.png'); ?>">
    <link rel="icon" type="image/png" href="<?php echo osjc_get_image_url('LOGO-JERONIMO-NEW-1-90x90.png'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Elementos decorativos verdes -->
<div class="decorative-green-right"></div>
<div class="decorative-green-bottom"></div>

<!-- Botão hambúrguer para abrir drawer (mobile) -->
<button class="drawer-toggle" id="drawerToggle" aria-label="Abrir menu">
    <span></span>
    <span></span>
    <span></span>
</button>

<?php if (function_exists('elementor_theme_do_location') && elementor_theme_do_location('header')) : ?>
    <?php // Header global do Elementor Pro ?>
<?php else : ?>
<header class="site-header" id="siteHeader">
    <div class="container">
        <div class="header-top">
            <div class="header-left">
                <div class="logo-circle">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img src="<?php echo osjc_get_image_url('LOGO-JERONIMO-NEW-1-90x90.png'); ?>" alt="<?php bloginfo('name'); ?>" />
                        </a>
                    <?php endif; ?>
                </div>
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
                </h1>
            </div>
        </div>
        <div class="header-bottom">
            <nav class="main-nav" role="navigation" aria-label="<?php esc_attr_e('Menu Principal', 'osjc'); ?>">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class'     => '',
                        'container'      => false,
                        'items_wrap'     => '<ul>%3$s</ul>',
                    ));
                } else {
                    osjc_fallback_menu();
                }
                ?>
            </nav>
            <div class="header-actions">
                <div class="social-icons">
                    <a href="https://www.instagram.com/jeronimocandinho.osjc?igsh=NHlmb3NxN2p0ODh1" target="_blank" rel="noopener" aria-label="Instagram" class="social-icon">
                        <img src="<?php echo osjc_get_asset_url('instagram-icon.svg'); ?>" alt="Instagram" class="social-icon-img" />
                    </a>
                    <a href="https://www.facebook.com" target="_blank" rel="noopener" aria-label="Facebook" class="social-icon">
                        <img src="<?php echo osjc_get_asset_url('facebook-icon.svg'); ?>" alt="Facebook" class="social-icon-img" />
                    </a>
                    <a href="https://www.youtube.com/@obrassociaisjeronimocandinho" target="_blank" rel="noopener" aria-label="YouTube" class="social-icon">
                        <img src="<?php echo osjc_get_image_url('youtube-123.svg'); ?>" alt="YouTube" class="social-icon-img" />
                    </a>
                </div>
                <button class="theme-toggle" id="themeToggle" aria-label="Alternar tema">
                    <span class="theme-icon">🌙</span>
                </button>
                <a href="<?php echo esc_url(home_url('/doe-aqui')); ?>" class="donate-button">
                    <img src="<?php echo osjc_get_image_url('heart-icon.png'); ?>" alt="Coração" class="donate-heart-icon"> 
                    <?php _e('Doe aqui', 'osjc'); ?>
                </a>
            </div>
        </div>
    </div>
</header>
<?php endif; ?>
