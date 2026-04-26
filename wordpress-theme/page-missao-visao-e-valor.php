<?php
/**
 * Template Name: Missão, Visão e Valores
 */

get_header();
?>

<main class="main-content">
    <section id="missao-visao-valores" class="mission-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag"><?php _e('Nossos fundamentos', 'osjc'); ?></span>
                <h2><?php _e('Missão, Visão e Valores', 'osjc'); ?></h2>
            </div>
            <div class="mission-grid">
                <div class="mission-card">
                    <h3><?php _e('Missão', 'osjc'); ?></h3>
                    <p><?php _e('Oferecer serviços socioeducacionais, socioassistenciais e sócio profissionalizantes às comunidades vulneráveis, em diferentes níveis, englobando a formação do indivíduo consciente e participativo e contribuindo para o fortalecimento da sociedade.', 'osjc'); ?></p>
                </div>
                <div class="mission-card">
                    <h3><?php _e('Visão', 'osjc'); ?></h3>
                    <p><?php _e('Ser referência em educação e profissionalização do público em situação de vulnerabilidade, atenuando a desigualdade social e educacional.', 'osjc'); ?></p>
                </div>
                <div class="mission-card">
                    <h3><?php _e('Valores', 'osjc'); ?></h3>
                    <p><?php _e('Praticar a caridade moral e material; prestar serviços gratuitos e permanentes aos usuários da assistência social, por todos os meios ao seu alcance e sem discriminação de clientela; difundir a instrução e combater os vícios humanos.', 'osjc'); ?></p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
