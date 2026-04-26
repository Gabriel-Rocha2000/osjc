<?php
/**
 * Template padrão do WordPress
 * 
 * Este arquivo é usado quando nenhum template específico corresponde a uma consulta.
 * Por exemplo, lista de posts, arquivos, etc.
 */

get_header();
?>

<main class="main-content">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="posts-list">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                        <h2 class="post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="post-meta">
                            <span class="post-date"><?php echo get_the_date(); ?></span>
                        </div>
                        <div class="post-content">
                            <?php the_excerpt(); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="post-link"><?php _e('Ler mais →', 'osjc'); ?></a>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <div class="pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => __('Anterior', 'osjc'),
                    'next_text' => __('Próxima', 'osjc'),
                ));
                ?>
            </div>
        <?php else : ?>
            <div class="no-posts">
                <h2><?php _e('Nenhum conteúdo encontrado', 'osjc'); ?></h2>
                <p><?php _e('Desculpe, não encontramos nenhum conteúdo.', 'osjc'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
