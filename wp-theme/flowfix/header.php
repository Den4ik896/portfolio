<?php
/**
 * Site header.
 *
 * @package FlowFix
 */

$flowfix_phone = flowfix_opt( 'phone' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'flowfix' ); ?></a>
<header class="site-header">
	<div class="wrap header-row">
		<?php if ( has_custom_logo() ) : ?>
			<?php the_custom_logo(); ?>
		<?php else : ?>
			<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 2.5c3.6 4.3 6.5 7.900 6.500 11.500a6.500 6.500 0 0 1-13 0c0-3.600 2.900-7.200 6.500-11.500z"/></svg>
				<span><?php bloginfo( 'name' ); ?></span>
			</a>
		<?php endif; ?>
		<button class="nav-toggle" aria-expanded="false" aria-controls="site-nav">
			<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'flowfix' ); ?></span>
			<span class="bars" aria-hidden="true"></span>
		</button>
		<nav id="site-nav" class="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'flowfix' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'menu',
					'depth'          => 1,
					'fallback_cb'    => 'flowfix_menu_fallback',
				)
			);
			?>
			<a class="btn btn-acc header-cta" href="<?php echo esc_url( 'tel:' . preg_replace( '/[^\d+]/', '', $flowfix_phone ) ); ?>"><?php echo esc_html( $flowfix_phone ); ?></a>
		</nav>
	</div>
</header>
<main id="main">
