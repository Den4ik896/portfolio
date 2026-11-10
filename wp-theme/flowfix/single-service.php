<?php
/**
 * Single service page.
 *
 * @package FlowFix
 */

get_header();
while ( have_posts() ) :
	the_post();
	$flowfix_price = get_post_meta( get_the_ID(), '_ff_price', true );
	?>
	<section class="page-head">
		<div class="wrap">
			<p class="eyebrow"><a href="<?php echo esc_url( home_url( '/#services' ) ); ?>"><?php esc_html_e( 'Services', 'flowfix' ); ?></a></p>
			<h1><?php the_title(); ?></h1>
		</div>
	</section>
	<article <?php post_class( 'section' ); ?>>
		<div class="wrap service-grid">
			<div class="entry">
				<div class="service-media"><?php flowfix_service_image( get_the_ID(), 'large' ); ?></div>
				<?php the_content(); ?>
			</div>
			<aside class="panel service-aside">
				<p class="muted"><?php esc_html_e( 'Price', 'flowfix' ); ?></p>
				<p class="estimate">
					<strong>
					<?php
					/* translators: %s: price. */
					printf( esc_html__( 'from $%s', 'flowfix' ), esc_html( $flowfix_price ) );
					?>
					</strong>
				</p>
				<p class="muted"><?php esc_html_e( 'Typical duration', 'flowfix' ); ?>: <?php echo esc_html( get_post_meta( get_the_ID(), '_ff_duration', true ) ); ?></p>
				<a class="btn btn-acc" href="<?php echo esc_url( add_query_arg( 'service', get_the_ID(), home_url( '/' ) ) . '#contact' ); ?>"><?php esc_html_e( 'Book this service', 'flowfix' ); ?></a>
				<p class="form-note"><?php echo esc_html( flowfix_opt( 'phone' ) ); ?></p>
			</aside>
		</div>
	</article>
	<?php
endwhile;
get_footer();
