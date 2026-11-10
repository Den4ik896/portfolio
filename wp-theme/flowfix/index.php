<?php
/**
 * Blog index, archives and search results.
 *
 * @package FlowFix
 */

get_header();
?>
<section class="page-head">
	<div class="wrap narrow">
		<h1>
			<?php
			if ( is_home() && get_option( 'page_for_posts' ) ) {
				echo esc_html( get_the_title( get_option( 'page_for_posts' ) ) );
			} elseif ( is_search() ) {
				/* translators: %s: search query. */
				printf( esc_html__( 'Search: %s', 'flowfix' ), esc_html( get_search_query() ) );
			} elseif ( is_archive() ) {
				the_archive_title();
			} else {
				esc_html_e( 'Blog', 'flowfix' );
			}
			?>
		</h1>
	</div>
</section>
<section class="section">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<div class="posts">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'post-card' ); ?>>
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
						<h2 class="h3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php the_excerpt(); ?>
					</article>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Nothing found yet.', 'flowfix' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
