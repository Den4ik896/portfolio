<?php
/**
 * Site footer.
 *
 * @package FlowFix
 */

?>
</main>
<footer class="site-footer">
	<div class="wrap footer-grid">
		<div>
			<p class="footer-brand"><?php bloginfo( 'name' ); ?></p>
			<p><?php bloginfo( 'description' ); ?></p>
		</div>
		<div>
			<p class="footer-title"><?php esc_html_e( 'Contact', 'flowfix' ); ?></p>
			<p><?php echo esc_html( flowfix_opt( 'phone' ) ); ?><br>
			<a href="<?php echo esc_url( 'mailto:' . antispambot( flowfix_opt( 'email' ) ) ); ?>"><?php echo esc_html( antispambot( flowfix_opt( 'email' ) ) ); ?></a><br>
			<?php echo esc_html( flowfix_opt( 'address' ) ); ?></p>
		</div>
		<div>
			<p class="footer-title"><?php esc_html_e( 'Hours', 'flowfix' ); ?></p>
			<p><?php echo esc_html( flowfix_opt( 'hours' ) ); ?></p>
		</div>
		<nav aria-label="<?php esc_attr_e( 'Footer', 'flowfix' ); ?>">
			<p class="footer-title"><?php esc_html_e( 'Pages', 'flowfix' ); ?></p>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'footer-menu',
					'depth'          => 1,
					'fallback_cb'    => false,
				)
			);
			?>
		</nav>
	</div>
	<div class="wrap footer-note">
		<?php
		/* translators: 1: year, 2: site name. */
		printf( esc_html__( '&copy; %1$s %2$s. Demo WordPress theme, the company is fictional.', 'flowfix' ), esc_html( gmdate( 'Y' ) ), esc_html( get_bloginfo( 'name' ) ) );
		?>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
