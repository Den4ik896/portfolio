<?php
/**
 * Demo content created once when the theme is activated.
 *
 * @package FlowFix
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create services, testimonials, pages, posts and the menu. Runs once.
 */
function flowfix_seed() {
	if ( get_option( 'flowfix_seeded' ) ) {
		return;
	}
	flowfix_post_types();

	$img      = 'https://images.unsplash.com/%s?w=800&h=560&fit=crop&q=75&auto=format';
	$services = array(
		array( 'Leak detection & repair', 89, '1-2 hours', 'photo-1676210134188-4c05dd172f89', 'Dripping joints, hidden leaks and burst pipes found with pressure testing and fixed the same visit.' ),
		array( 'Drain cleaning', 79, '1 hour', 'photo-1609210884848-2d530cfb2a07', 'Blocked sinks, showers and toilets cleared with a drain machine, plus a camera check if the clog keeps coming back.' ),
		array( 'Faucets & fixtures', 69, '1 hour', 'photo-1542855368-ca6ea825bca2', 'Repair or replacement of faucets, shower mixers, toilets and shut-off valves, with parts in the van.' ),
		array( 'Water heater service', 129, '2-3 hours', 'photo-1770625467384-304e461ef1be', 'Diagnostics, flushing, thermostat and element replacement, or a full new water heater installation.' ),
		array( 'Bathroom installation', 349, '1-2 days', 'photo-1771681744660-d3ff70bc24a2', 'Sinks, toilets, showers and bathtubs installed and connected, with tidy sealing and a pressure test.' ),
		array( 'Pipe replacement', 199, 'Half a day', 'photo-1607472586893-edb57bdc0e39', 'Old steel or leaking sections replaced with modern piping, with minimal cutting into walls.' ),
	);
	$service_ids = array();
	foreach ( $services as $i => $s ) {
		$id = wp_insert_post(
			array(
				'post_type'    => 'service',
				'post_status'  => 'publish',
				'post_title'   => $s[0],
				'post_excerpt' => $s[4],
				'menu_order'   => $i,
				'post_content' => '<p>' . $s[4] . '</p><h2>What is included</h2><ul><li>Inspection and a fixed price before work starts</li><li>All labour and standard fittings</li><li>Clean-up after the job</li><li>12-month workmanship guarantee</li></ul><h2>How it works</h2><p>Book a two-hour arrival window online or by phone. The plumber checks the problem, confirms the price and completes most jobs in a single visit.</p>',
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_ff_price', $s[1] );
			update_post_meta( $id, '_ff_duration', $s[2] );
			update_post_meta( $id, '_ff_image', sprintf( $img, $s[3] ) );
			$service_ids[] = $id;
		}
	}

	$reviews = array(
		array( 'Maria Jensen', 'Kitchen leak repair', 'Called at 8 am with water under the sink, the plumber was here before 10 and the price matched the quote exactly.' ),
		array( 'David Okafor', 'Water heater replacement', 'They replaced our old water heater in one afternoon and took the old unit away. Clear explanation of every option.' ),
		array( 'Helen Park', 'Bathroom installation', 'New sink, toilet and shower fitted in two days. Neat work, no mess left behind, and everything was tested with us.' ),
	);
	foreach ( $reviews as $r ) {
		wp_insert_post(
			array(
				'post_type'    => 'testimonial',
				'post_status'  => 'publish',
				'post_title'   => $r[0],
				'post_excerpt' => $r[1],
				'post_content' => $r[2],
			)
		);
	}

	$posts = array(
		array( 'Five signs of a hidden water leak', 'A higher water bill, a meter that moves when every tap is closed, damp patches, a musty smell and the sound of running water are the five most common signs of a leak you cannot see.', 'photo-1542013936693-884638332954' ),
		array( 'How to stop a blocked drain from coming back', 'Most repeat clogs are caused by grease, hair and wipes. A drain strainer, hot water after washing up and a monthly enzyme cleaner prevent the majority of call-outs.', 'photo-1521207418485-99c705420785' ),
		array( 'When to repair and when to replace a water heater', 'If the tank is under eight years old and not leaking, a repair usually makes sense. Rust-coloured water, rumbling and leaks from the tank itself mean it is time for a new one.', 'photo-1620653713380-7a34b773fef8' ),
	);
	foreach ( $posts as $p ) {
		wp_insert_post(
			array(
				'post_type'    => 'post',
				'post_status'  => 'publish',
				'post_title'   => $p[0],
				'post_excerpt' => $p[1],
				'post_content' => '<figure class="wp-block-image"><img src="' . esc_url( sprintf( 'https://images.unsplash.com/%s?w=1100&h=560&fit=crop&q=75&auto=format', $p[2] ) ) . '" alt=""/></figure><p>' . $p[1] . '</p><h2>What to do first</h2><p>Close the main shut-off valve if water is escaping, take a photo of the problem and note when it started. This saves time on the visit and helps us bring the right parts.</p><h2>When to call a plumber</h2><p>If the problem returns after a simple fix, involves gas or hot water equipment, or you see water near electrics, book a visit instead of trying again.</p>',
			)
		);
	}

	$home = wp_insert_post(
		array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'post_title'  => 'Home',
		)
	);
	$blog = wp_insert_post(
		array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'post_title'  => 'Blog',
		)
	);
	$about = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'About us',
			'post_content' => '<p>FlowFix is a family-run plumbing company that has served local homes and businesses since 2011. Our team of eight licensed plumbers completes more than 3,000 jobs a year.</p><h2>How we work</h2><ul><li>Fixed prices agreed before work starts</li><li>Two-hour arrival windows and a call when the plumber is on the way</li><li>Shoe covers, dust sheets and a clean workspace when we leave</li></ul><p>This page is built with the standard WordPress editor, so the owner can change the text without a developer.</p>',
		)
	);
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home );
	update_option( 'page_for_posts', $blog );
	update_option( 'blogname', 'FlowFix' );
	update_option( 'blogdescription', 'Local plumbing services' );
	update_option( 'permalink_structure', '/%postname%/' );

	$hello = get_page_by_path( 'hello-world', OBJECT, 'post' );
	if ( $hello ) {
		wp_delete_post( $hello->ID, true );
	}
	$sample = get_page_by_path( 'sample-page' );
	if ( $sample ) {
		wp_delete_post( $sample->ID, true );
	}

	$menu_id = wp_create_nav_menu( 'Main menu' );
	if ( ! is_wp_error( $menu_id ) ) {
		$items = array(
			array( 'Services', home_url( '/#services' ) ),
			array( 'Prices', home_url( '/#estimate' ) ),
			array( 'Reviews', home_url( '/#reviews' ) ),
			array( 'FAQ', home_url( '/#faq' ) ),
		);
		foreach ( $items as $item ) {
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'  => $item[0],
					'menu-item-url'    => $item[1],
					'menu-item-status' => 'publish',
					'menu-item-type'   => 'custom',
				)
			);
		}
		foreach ( array( $about, $blog ) as $page_id ) {
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-object-id' => $page_id,
					'menu-item-object'    => 'page',
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
				)
			);
		}
		set_theme_mod( 'nav_menu_locations', array( 'primary' => $menu_id, 'footer' => $menu_id ) );
	}

	flush_rewrite_rules();
	update_option( 'flowfix_seeded', 1 );
}
add_action( 'after_switch_theme', 'flowfix_seed' );
