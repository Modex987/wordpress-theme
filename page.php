<?php get_header(); ?>

<div class="page">
    <?php if(have_posts()): ?>
    <?php while(have_posts()): the_post(); ?>

    <?php the_title(); ?>

    <?php endwhile; ?>
    <?php endif; ?>
</div>

<?php get_footer(); ?>