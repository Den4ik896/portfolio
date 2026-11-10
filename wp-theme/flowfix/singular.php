<?php
/**
 * Single posts and pages.
 *
 * @package FlowFix
 */

get_header();
while ( have_posts() ) :
	the_post();
	?>
	<section class="page-head">
		<div class="wrap narrow">
			<?php if ( is_singular( 'post' ) ) : ?>
				<p class="eyebrow"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></p>
			<?php endif; ?>
			<h1><?php the_title(); ?></h1>
		</div>
	</section>
	<article <?php post_class( 'section' ); ?>>
		<div class="wrap narrow entry">
			<?php
			the_content();
			wp_link_pages();
			?>
			<?php if ( is_singular( 'post' ) ) : ?>
				<p class="entry-cta"><a class="btn btn-acc" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Book a plumber', 'flowfix' ); ?></a></p>
			<?php endif; ?>
		</div>
	</article>
	<?php
endwhile;
get_footer();
