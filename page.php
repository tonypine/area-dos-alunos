<?php get_header(); ?>

	<div id="content" class="cf">
		<?php include('sidebar-nav.php'); ?> 
		<div id="meio">
            <article class="excerpt-article">
                <h2><?php the_title(); ?></h2>
                <section class="excerpt-info">
                    <span class="date"><?php echo get_the_date(); ?></span>
                </section>
                <section class="content">
                    <?php the_content(); ?>
                </section>

            </article>
		</div>
		<?php include('sidebar-right.php'); ?>
	</div>


<?php include 'footer.php'; ?>