<?php
/**
 * Template para a página Doe Aqui.
 */

get_header();
?>

<main class="main-content">
    <section class="donate-hero">
        <div class="donate-hero-content">
            <h1 class="donate-hero-title"><?php _e('Doe aqui', 'osjc'); ?></h1>
            <p class="donate-hero-text"><?php _e('A Osjc ajuda famílias a saírem da vulnerabilidade social. Sua contribuição é essencial para manter programas de amparo e proteção em todas as fases da vida.', 'osjc'); ?></p>
        </div>
    </section>

    <section class="home-ajude-fome-section" aria-labelledby="home-ajude-heading">
        <div class="container">
            <div class="section-header home-ajude-fome-header">
                <span class="section-tag home-ajude-fome-tag"><?php _e('Nossa missão', 'osjc'); ?></span>
                <h2 id="home-ajude-heading" class="home-ajude-fome-title"><?php _e('Ajude quem tem fome', 'osjc'); ?></h2>
            </div>
            <div class="home-ajude-fome-video">
                <iframe src="https://www.youtube.com/embed/nJWzHtltPqA" title="<?php esc_attr_e('AJUDE QUEM TEM FOME - Projeto Social OSJC', 'osjc'); ?>" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>
            <div class="home-ajude-fome-text">
                <p><?php _e('A desnutrição é responsável por quase metade das mortes de crianças menores de cinco anos em todo o mundo, o que equivale a cerca de 3 milhões de vidas perdidas a cada ano.', 'osjc'); ?></p>
                <p><?php _e('No projeto Ajude quem tem fome, nosso compromisso com a comunidade é impulsionado por um objetivo primordial: proporcionar esperança e apoio aos mais necessitados. Estamos emocionados em compartilhar que, graças ao apoio de doadores e voluntários, conseguimos ajudar mais de 180 famílias por semana a terem acesso a alimentos nutritivos e essenciais.', 'osjc'); ?></p>
            </div>
            <p class="home-ajude-fome-cta">
                <a href="<?php echo esc_url(home_url('/posts/todos/ajude-quem-tem-fome/')); ?>" class="btn-secondary"><?php _e('Saiba mais sobre o projeto', 'osjc'); ?></a>
            </p>
        </div>
    </section>

    <section class="donate-section">
        <div class="container">
            <div class="donate-content">
                <div class="donate-text-side">
                    <div class="bank-data-container" id="bankDataContainer" title="<?php esc_attr_e('Clique para copiar os dados bancários', 'osjc'); ?>">
                        <h2 class="bank-data-title"><?php _e('Dados bancários para doação', 'osjc'); ?></h2>
                        <div class="bank-data-content">
                            <p class="bank-data-line"><strong><?php _e('BANCO:', 'osjc'); ?></strong> 070 - BRB BANCO DE BRASILIA S/A</p>
                            <p class="bank-data-line"><strong><?php _e('AGENCIA:', 'osjc'); ?></strong> 050 PONTA NORTE</p>
                            <p class="bank-data-line"><strong><?php _e('CONTA CORRENTE:', 'osjc'); ?></strong> 050.022029-8</p>
                            <p class="bank-data-line"><strong><?php _e('FAVORECIDO:', 'osjc'); ?></strong> OBRAS SOCIAIS C E F J CANDINHO</p>
                        </div>
                        <div class="bank-data-copy-hint">
                            <i class="fa-solid fa-copy"></i> <?php _e('Clique para copiar', 'osjc'); ?>
                        </div>
                    </div>
                </div>

                <div class="donate-form-side">
                    <div class="donate-form-container">
                        <h3 class="donate-form-title"><?php _e('Escolha um valor abaixo para doar:', 'osjc'); ?></h3>
                        <div class="donate-amount-buttons">
                            <button class="donate-amount-btn" data-amount="15">R$ 15</button>
                            <button class="donate-amount-btn" data-amount="30">R$ 30</button>
                            <a href="https://pag.ae/81gQ2eMX3" target="_blank" rel="noopener" class="donate-amount-btn donate-amount-link" data-amount="50">R$ 50</a>
                            <button class="donate-amount-btn" data-amount="80">R$ 80</button>
                            <a href="https://pag.ae/81gQ2UsnH" target="_blank" rel="noopener" class="donate-amount-btn donate-amount-link" data-amount="100">R$ 100</a>
                            <button class="donate-amount-btn" data-amount="140">R$ 140</button>
                        </div>
                        <a href="https://pag.ae/81gQ3wwX2" target="_blank" rel="noopener" class="donate-basket-btn donate-basket-link"><?php _e('Cesta básica de Natal', 'osjc'); ?></a>
                        <div class="donate-custom-amount">
                            <label for="custom-amount"><?php _e('Ou digite um valor personalizado:', 'osjc'); ?></label>
                            <div class="custom-amount-input">
                                <span class="currency-symbol">R$</span>
                                <input type="number" id="custom-amount" placeholder="0,00" min="1" step="0.01">
                            </div>
                        </div>
                        <button class="donate-submit-btn"><?php _e('Continuar com a doação', 'osjc'); ?></button>
                    </div>

                    <div class="donate-hero-image">
                        <img src="<?php echo esc_url(osjc_get_image_url('superhero-placeholder.png')); ?>" alt="<?php esc_attr_e('Super-herói', 'osjc'); ?>" class="superhero-img" style="display: none;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="donation-projects-section">
        <div class="container">
            <div class="donation-projects-banner">
                <img src="<?php echo esc_url(osjc_get_image_url('donation-banner.png')); ?>" alt="<?php esc_attr_e('Faça sua doação e contribua para o combate à fome!', 'osjc'); ?>">
            </div>

            <h2 class="donation-projects-title"><?php _e('Nossos Projetos em Ação', 'osjc'); ?></h2>

            <div class="donation-projects-cards">
                <article class="donation-project-card">
                    <img src="<?php echo esc_url(osjc_get_image_url('donation-card-address.png')); ?>" alt="<?php esc_attr_e('Card com endereço para doação', 'osjc'); ?>">
                </article>
                <article class="donation-project-card">
                    <img src="<?php echo esc_url(osjc_get_image_url('donation-card-account.png')); ?>" alt="<?php esc_attr_e('Card com dados de conta para doação', 'osjc'); ?>">
                </article>
                <article class="donation-project-card">
                    <img src="<?php echo esc_url(osjc_get_image_url('donation-card-pix.png')); ?>" alt="<?php esc_attr_e('Card com chave PIX para doação', 'osjc'); ?>">
                </article>
                <article class="donation-project-card">
                    <img src="<?php echo esc_url(osjc_get_image_url('donation-card-paypal.png')); ?>" alt="<?php esc_attr_e('Card de doação via PayPal', 'osjc'); ?>">
                </article>
            </div>
        </div>
    </section>

    <section class="donation-contact-section">
        <div class="container">
            <h2 class="donation-contact-title"><?php _e('Entre em contato para doar', 'osjc'); ?></h2>
            <div class="donation-contact-layout">
                <form class="donation-contact-form" action="#" method="post">
                    <h3><?php _e('Entre em contato', 'osjc'); ?></h3>
                    <label for="contact-donation-name"><?php _e('Nome', 'osjc'); ?></label>
                    <input id="contact-donation-name" type="text" placeholder="<?php esc_attr_e('Seu nome completo', 'osjc'); ?>" required>
                    <label for="contact-donation-email"><?php _e('E-mail', 'osjc'); ?></label>
                    <input id="contact-donation-email" type="email" placeholder="seu@email.com" required>
                    <label for="contact-donation-phone"><?php _e('Telefone', 'osjc'); ?></label>
                    <input id="contact-donation-phone" type="tel" placeholder="(00) 00000-0000" required>
                    <button type="submit" class="donation-contact-button"><?php _e('Enviar', 'osjc'); ?> <span aria-hidden="true">→</span></button>
                </form>
                <div class="donation-contact-image">
                    <img src="<?php echo esc_url(osjc_get_image_url('donation-phone.png')); ?>" alt="<?php esc_attr_e('Contato para doação', 'osjc'); ?>">
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
