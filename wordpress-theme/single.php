<?php
/**
 * Template para post unico
 */

get_header();
?>

<main class="main-content">
    <div class="container">
        <?php
        while (have_posts()) :
            the_post();
            the_content();
        endwhile;
        ?>
    </div>
</main>

<?php get_footer(); ?>
