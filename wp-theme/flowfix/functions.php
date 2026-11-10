<?php
/**
 * FlowFix theme functions.
 *
 * @package FlowFix
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FLOWFIX_VER', '1.0.0' );

require get_template_directory() . '/inc/demo-content.php';

/**
 * Theme supports and menus.
 */
function flowfix_setup() {
	load_theme_textdomain( 'flowfix', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 48, 'width' => 180, 'flex-width' => true ) );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	register_nav_menus(
		array(
			'primary' => __( 'Primary menu', 'flowfix' ),
			'footer'  => __( 'Footer menu', 'flowfix' ),
		)
	);
}
add_action( 'after_setup_theme', 'flowfix_setup' );

/**
 * Default values for Customizer settings.
 */
function flowfix_defaults() {
	return array(
		'phone'      => '+1 (555) 014-2277',
		'email'      => 'hello@flowfix.example',
		'address'    => '48 Harbor Street, Portland',
		'hours'      => 'Mon-Sat 7:00-20:00, emergencies 24/7',
		'hero_title' => 'Plumbing fixed right, the same day',
		'hero_text'  => 'Licensed local plumbers for leaks, drains, water heaters and bathroom installs. Upfront prices and a 12-month guarantee on every job.',
		'hero_image' => 'https://images.unsplash.com/photo-1749532125405-70950966b0e5?w=1100&h=900&fit=crop&q=75&auto=format',
	);
}

/**
 * Read a theme setting with its default.
 *
 * @param string $key Setting key.
 */
function flowfix_opt( $key ) {
	$defaults = flowfix_defaults();
	return get_theme_mod( 'flowfix_' . $key, isset( $defaults[ $key ] ) ? $defaults[ $key ] : '' );
}

/**
 * Customizer: contact details and hero.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function flowfix_customize( $wp_customize ) {
	$sections = array(
		'flowfix_contact' => array(
			'title'  => __( 'Contact details', 'flowfix' ),
			'fields' => array(
				'phone'   => __( 'Phone', 'flowfix' ),
				'email'   => __( 'Email', 'flowfix' ),
				'address' => __( 'Address', 'flowfix' ),
				'hours'   => __( 'Working hours', 'flowfix' ),
			),
		),
		'flowfix_hero'    => array(
			'title'  => __( 'Home page hero', 'flowfix' ),
			'fields' => array(
				'hero_title' => __( 'Headline', 'flowfix' ),
				'hero_text'  => __( 'Text', 'flowfix' ),
				'hero_image' => __( 'Image URL', 'flowfix' ),
			),
		),
	);
	$defaults = flowfix_defaults();
	foreach ( $sections as $id => $section ) {
		$wp_customize->add_section( $id, array( 'title' => $section['title'], 'priority' => 30 ) );
		foreach ( $section['fields'] as $key => $label ) {
			$is_url = 'hero_image' === $key;
			$wp_customize->add_setting(
				'flowfix_' . $key,
				array(
					'default'           => $defaults[ $key ],
					'sanitize_callback' => $is_url ? 'esc_url_raw' : 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'flowfix_' . $key,
				array(
					'label'   => $label,
					'section' => $id,
					'type'    => 'hero_text' === $key ? 'textarea' : ( $is_url ? 'url' : 'text' ),
				)
			);
		}
	}
}
add_action( 'customize_register', 'flowfix_customize' );

/**
 * Custom post types: services, testimonials, booking requests.
 */
function flowfix_post_types() {
	register_post_type(
		'service',
		array(
			'labels'       => array(
				'name'          => __( 'Services', 'flowfix' ),
				'singular_name' => __( 'Service', 'flowfix' ),
				'add_new_item'  => __( 'Add new service', 'flowfix' ),
				'edit_item'     => __( 'Edit service', 'flowfix' ),
			),
			'public'       => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-admin-tools',
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			'rewrite'      => array( 'slug' => 'services' ),
		)
	);
	register_post_type(
		'testimonial',
		array(
			'labels'    => array(
				'name'          => __( 'Testimonials', 'flowfix' ),
				'singular_name' => __( 'Testimonial', 'flowfix' ),
				'add_new_item'  => __( 'Add new testimonial', 'flowfix' ),
			),
			'public'    => false,
			'show_ui'   => true,
			'menu_icon' => 'dashicons-format-quote',
			'supports'  => array( 'title', 'editor', 'excerpt' ),
		)
	);
	register_post_type(
		'ff_request',
		array(
			'labels'       => array(
				'name'          => __( 'Booking requests', 'flowfix' ),
				'singular_name' => __( 'Booking request', 'flowfix' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'menu_icon'    => 'dashicons-email-alt',
			'supports'     => array( 'title', 'editor' ),
			'capabilities' => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap' => true,
		)
	);
}
add_action( 'init', 'flowfix_post_types' );

/**
 * Service details meta box.
 */
function flowfix_meta_boxes() {
	add_meta_box( 'flowfix_service', __( 'Service details', 'flowfix' ), 'flowfix_service_box', 'service', 'side' );
}
add_action( 'add_meta_boxes', 'flowfix_meta_boxes' );

/**
 * Render the service meta box.
 *
 * @param WP_Post $post Post.
 */
function flowfix_service_box( $post ) {
	wp_nonce_field( 'flowfix_service', 'flowfix_service_nonce' );
	$fields = array(
		'_ff_price'    => array( __( 'Price from, $', 'flowfix' ), 'number' ),
		'_ff_duration' => array( __( 'Typical duration', 'flowfix' ), 'text' ),
		'_ff_image'    => array( __( 'Image URL (used when no featured image)', 'flowfix' ), 'url' ),
	);
	foreach ( $fields as $key => $field ) {
		printf(
			'<p><label for="%1$s">%2$s</label><br><input class="widefat" type="%3$s" id="%1$s" name="%1$s" value="%4$s"></p>',
			esc_attr( $key ),
			esc_html( $field[0] ),
			esc_attr( $field[1] ),
			esc_attr( get_post_meta( $post->ID, $key, true ) )
		);
	}
}

/**
 * Save the service meta box.
 *
 * @param int $post_id Post ID.
 */
function flowfix_save_service( $post_id ) {
	if ( ! isset( $_POST['flowfix_service_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['flowfix_service_nonce'] ), 'flowfix_service' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['_ff_price'] ) ) {
		update_post_meta( $post_id, '_ff_price', absint( $_POST['_ff_price'] ) );
	}
	if ( isset( $_POST['_ff_duration'] ) ) {
		update_post_meta( $post_id, '_ff_duration', sanitize_text_field( wp_unslash( $_POST['_ff_duration'] ) ) );
	}
	if ( isset( $_POST['_ff_image'] ) ) {
		update_post_meta( $post_id, '_ff_image', esc_url_raw( wp_unslash( $_POST['_ff_image'] ) ) );
	}
}
add_action( 'save_post_service', 'flowfix_save_service' );

/**
 * All published services, ordered by menu order.
 */
function flowfix_services() {
	return get_posts(
		array(
			'post_type'      => 'service',
			'posts_per_page' => 12,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		)
	);
}

/**
 * Print a service image: featured image first, then the URL from the meta box.
 *
 * @param int    $post_id Service ID.
 * @param string $size    Image size.
 */
function flowfix_service_image( $post_id, $size = 'medium_large' ) {
	if ( has_post_thumbnail( $post_id ) ) {
		echo get_the_post_thumbnail( $post_id, $size, array( 'loading' => 'lazy' ) );
		return;
	}
	$url = get_post_meta( $post_id, '_ff_image', true );
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy">', esc_url( $url ), esc_attr( get_the_title( $post_id ) ) );
	}
}

/**
 * Frequently asked questions shown on the home page.
 */
function flowfix_faq() {
	return apply_filters(
		'flowfix_faq',
		array(
			__( 'How fast can a plumber arrive?', 'flowfix' ) => __( 'For standard bookings we offer two-hour arrival windows, usually the same or next day. Emergency calls are answered around the clock and a plumber is typically on site within 60 minutes.', 'flowfix' ),
			__( 'Do you charge a call-out fee?', 'flowfix' ) => __( 'No. You pay for the job, not for the visit. The plumber inspects the problem and gives you a fixed price before any work starts.', 'flowfix' ),
			__( 'Is your work guaranteed?', 'flowfix' ) => __( 'Yes. Every repair and installation is covered by a 12-month workmanship guarantee, and parts carry the manufacturer warranty.', 'flowfix' ),
			__( 'Are your plumbers licensed and insured?', 'flowfix' ) => __( 'All our plumbers are licensed, background-checked and fully insured for work in your home or business.', 'flowfix' ),
			__( 'How can I pay?', 'flowfix' ) => __( 'Card, bank transfer or cash once the job is finished. Business customers can be invoiced monthly.', 'flowfix' ),
		)
	);
}

/**
 * Styles and scripts.
 */
function flowfix_assets() {
	wp_enqueue_style( 'flowfix-fonts', 'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap', array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
	wp_enqueue_style( 'flowfix-style', get_stylesheet_uri(), array(), FLOWFIX_VER );
	wp_enqueue_script( 'flowfix-main', get_template_directory_uri() . '/assets/main.js', array(), FLOWFIX_VER, true );
}
add_action( 'wp_enqueue_scripts', 'flowfix_assets' );

/**
 * Handle the booking form: validate, store as a request, notify the site admin.
 */
function flowfix_handle_request() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( array( 'ff_sent', 'ff_error' ), $back );

	if ( ! isset( $_POST['flowfix_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['flowfix_nonce'] ), 'flowfix_request' ) ) {
		wp_safe_redirect( add_query_arg( 'ff_error', 'nonce', $back ) . '#contact' );
		exit;
	}
	// Honeypot: real visitors never fill this hidden field.
	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'ff_sent', '1', $back ) . '#contact' );
		exit;
	}

	$name    = isset( $_POST['ff_name'] ) ? sanitize_text_field( wp_unslash( $_POST['ff_name'] ) ) : '';
	$phone   = isset( $_POST['ff_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['ff_phone'] ) ) : '';
	$service = isset( $_POST['ff_service'] ) ? absint( $_POST['ff_service'] ) : 0;
	$urgency = isset( $_POST['ff_urgency'] ) ? sanitize_key( $_POST['ff_urgency'] ) : 'standard';
	$message = isset( $_POST['ff_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ff_message'] ) ) : '';

	$digits = preg_replace( '/\D/', '', $phone );
	if ( mb_strlen( $name ) < 2 || strlen( $digits ) < 7 ) {
		wp_safe_redirect( add_query_arg( 'ff_error', 'fields', $back ) . '#contact' );
		exit;
	}

	$service_title = $service ? get_the_title( $service ) : __( 'Not sure yet', 'flowfix' );
	$body          = sprintf(
		"Name: %s\nPhone: %s\nService: %s\nUrgency: %s\n\n%s",
		$name,
		$phone,
		$service_title,
		$urgency,
		$message
	);

	wp_insert_post(
		array(
			'post_type'    => 'ff_request',
			'post_status'  => 'private',
			'post_title'   => sprintf( '%s - %s', $name, $phone ),
			'post_content' => $body,
		)
	);
	wp_mail( get_option( 'admin_email' ), __( 'New booking request', 'flowfix' ), $body );

	wp_safe_redirect( add_query_arg( 'ff_sent', '1', $back ) . '#contact' );
	exit;
}
add_action( 'admin_post_nopriv_flowfix_request', 'flowfix_handle_request' );
add_action( 'admin_post_flowfix_request', 'flowfix_handle_request' );

/**
 * Shorter excerpts for cards.
 */
function flowfix_excerpt_length() {
	return 22;
}
add_filter( 'excerpt_length', 'flowfix_excerpt_length' );

/**
 * Fallback menu when no menu is assigned.
 */
function flowfix_menu_fallback() {
	$links = array(
		'#services' => __( 'Services', 'flowfix' ),
		'#estimate' => __( 'Prices', 'flowfix' ),
		'#reviews'  => __( 'Reviews', 'flowfix' ),
		'#faq'      => __( 'FAQ', 'flowfix' ),
	);
	echo '<ul class="menu">';
	foreach ( $links as $hash => $label ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( '/' . $hash ) ), esc_html( $label ) );
	}
	echo '</ul>';
}
