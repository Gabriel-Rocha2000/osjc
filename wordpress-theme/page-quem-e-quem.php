<?php
/**
 * Template Name: Quem é Quem
 */

get_header();
?>

<main class="main-content">
    <section class="quem-e-quem-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag"><?php _e('Governança', 'osjc'); ?></span>
                <h1 class="quem-e-quem-title"><?php _e('Quem é Quem', 'osjc'); ?></h1>
                <p class="quem-e-quem-subtitle"><?php _e('Mandato 09/11/2023 a 17/04/2028', 'osjc'); ?></p>
            </div>

            <div class="quem-e-quem-grid">
                <article class="quem-e-quem-card">
                    <h2><?php _e('Diretoria Executiva', 'osjc'); ?></h2>
                    <ul>
                        <li><strong><?php _e('Presidência:', 'osjc'); ?></strong> <?php _e('Nome da Presidência', 'osjc'); ?></li>
                        <li><strong><?php _e('Vice-Presidência:', 'osjc'); ?></strong> <?php _e('Nome da Vice-Presidência', 'osjc'); ?></li>
                        <li><strong><?php _e('Secretaria:', 'osjc'); ?></strong> <?php _e('Nome da Secretaria', 'osjc'); ?></li>
                        <li><strong><?php _e('Tesouraria:', 'osjc'); ?></strong> <?php _e('Nome da Tesouraria', 'osjc'); ?></li>
                    </ul>
                </article>

                <article class="quem-e-quem-card">
                    <h2><?php _e('Conselho Fiscal', 'osjc'); ?></h2>
                    <ul>
                        <li><strong><?php _e('Membro Titular 1:', 'osjc'); ?></strong> <?php _e('Nome do membro', 'osjc'); ?></li>
                        <li><strong><?php _e('Membro Titular 2:', 'osjc'); ?></strong> <?php _e('Nome do membro', 'osjc'); ?></li>
                        <li><strong><?php _e('Membro Titular 3:', 'osjc'); ?></strong> <?php _e('Nome do membro', 'osjc'); ?></li>
                        <li><strong><?php _e('Suplente:', 'osjc'); ?></strong> <?php _e('Nome do suplente', 'osjc'); ?></li>
                    </ul>
                </article>

                <article class="quem-e-quem-card">
                    <h2><?php _e('Coordenações', 'osjc'); ?></h2>
                    <ul>
                        <li><strong><?php _e('Coordenação Pedagógica:', 'osjc'); ?></strong> <?php _e('Nome responsável', 'osjc'); ?></li>
                        <li><strong><?php _e('Coordenação Social:', 'osjc'); ?></strong> <?php _e('Nome responsável', 'osjc'); ?></li>
                        <li><strong><?php _e('Coordenação Administrativa:', 'osjc'); ?></strong> <?php _e('Nome responsável', 'osjc'); ?></li>
                        <li><strong><?php _e('Coordenação de Projetos:', 'osjc'); ?></strong> <?php _e('Nome responsável', 'osjc'); ?></li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
