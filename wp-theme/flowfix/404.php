<?php
/**
 * 404 page.
 *
 * @package FlowFix
 */

get_header();
?>
<section class="page-head">
	<div class="wrap narrow">
		<h1><?php esc_html_e( 'Page not found', 'flowfix' ); ?></h1>
		<p><?php esc_html_e( 'The page may have been moved. Start again from the home page.', 'flowfix' ); ?></p>
		<p><a class="btn btn-acc" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'flowfix' ); ?></a></p>
	</div>
</section>
<?php
get_footer();
