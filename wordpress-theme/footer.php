    <?php if (function_exists('elementor_theme_do_location') && elementor_theme_do_location('footer')) : ?>
        <?php // Footer global do Elementor Pro ?>
    <?php else : ?>
    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section footer-about">
                    <h4><?php bloginfo('name'); ?></h4>
                    <p><?php echo get_bloginfo('description'); ?></p>
                </div>
                
                <div class="footer-section footer-nav">
                    <h4><?php _e('Navegação', 'osjc'); ?></h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer-links',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ));
                    ?>
                    <?php if (!has_nav_menu('footer')) : ?>
                        <ul class="footer-links">
                            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'osjc'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/quem-somos')); ?>"><?php _e('Quem Somos', 'osjc'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/programas')); ?>"><?php _e('Programas e Projetos', 'osjc'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/blog')); ?>"><?php _e('Blog', 'osjc'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/transparencia')); ?>"><?php _e('Transparência', 'osjc'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/contato')); ?>"><?php _e('Contato', 'osjc'); ?></a></li>
                        </ul>
                    <?php endif; ?>
                </div>
                
                <div class="footer-section footer-programs">
                    <h4><?php _e('Programas', 'osjc'); ?></h4>
                    <ul class="footer-links">
                        <li><a href="<?php echo esc_url(home_url('/portal-jovem-aprendiz')); ?>"><?php _e('Jovem Aprendiz', 'osjc'); ?></a></li>
                    </ul>
                </div>
                
                <div class="footer-section footer-contact">
                    <h4><?php _e('Contato', 'osjc'); ?></h4>
                    <div class="contact-info">
                        <p class="contact-item">
                            <span class="contact-icon">📍</span>
                            <span>Quadra 12, área reservada 3,<br>entrada pelo Conjunto A, Sobradinho-DF</span>
                        </p>
                        <p class="contact-item">
                            <span class="contact-icon">📞</span>
                            <span>(61)3051-3903</span>
                        </p>
                        <p class="contact-item">
                            <span class="contact-icon">✉️</span>
                            <span>contato@jeronimocandinho.org</span>
                        </p>
                        <p class="contact-item">
                            <span class="contact-icon">🕒</span>
                            <span>Segunda a Sexta<br>8h às 17h</span>
                        </p>
                    </div>
                </div>
                
                <div class="footer-section footer-social">
                    <h4><?php _e('Redes Sociais', 'osjc'); ?></h4>
                    <div class="footer-social-icons">
                        <a href="https://www.instagram.com/jeronimocandinho.osjc?igsh=NHlmb3NxN2p0ODh1" target="_blank" rel="noopener" aria-label="Instagram" class="footer-social-link">
                            <span class="social-icon-text">Instagram</span>
                        </a>
                        <a href="https://www.facebook.com" target="_blank" rel="noopener" aria-label="Facebook" class="footer-social-link">
                            <span class="social-icon-text">Facebook</span>
                        </a>
                        <a href="https://www.youtube.com/@obrassociaisjeronimocandinho" target="_blank" rel="noopener" aria-label="YouTube" class="footer-social-link">
                            <span class="social-icon-text">YouTube</span>
                        </a>
                        <a href="https://wa.me/5561981691123" target="_blank" rel="noopener" aria-label="WhatsApp" class="footer-social-link">
                            <span class="social-icon-text">WhatsApp</span>
                        </a>
                    </div>
                </div>
                
                <div class="footer-section footer-newsletter">
                    <h4><?php _e('Newsletter', 'osjc'); ?></h4>
                    <p class="newsletter-description"><?php _e('Receba nossas novidades e atualizações por email', 'osjc'); ?></p>
                    <form class="newsletter-form" id="newsletterForm">
                        <div class="newsletter-input-group">
                            <input type="email" id="newsletterEmail" class="newsletter-input" placeholder="<?php esc_attr_e('Seu melhor e-mail', 'osjc'); ?>" required aria-label="<?php esc_attr_e('Email para newsletter', 'osjc'); ?>">
                            <button type="submit" class="newsletter-button" aria-label="<?php esc_attr_e('Inscrever-se na newsletter', 'osjc'); ?>">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                        <p class="newsletter-message" id="newsletterMessage"></p>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; Copyright <?php echo date('Y'); ?> – <strong><?php bloginfo('name'); ?></strong> – <?php _e('Todos os direitos reservados', 'osjc'); ?></p>
            </div>
        </div>
    </footer>
    <?php endif; ?>
    
    <!-- Modal para imagem ampliada -->
    <div id="imageModal" class="image-modal">
        <span class="image-modal-close">&times;</span>
        <img class="image-modal-content" id="modalImage" alt="<?php esc_attr_e('Imagem ampliada', 'osjc'); ?>">
    </div>
    
    <?php wp_footer(); ?>
</body>
</html>
