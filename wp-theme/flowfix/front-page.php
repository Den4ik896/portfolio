<?php
/**
 * Home page: hero, services, process, estimate and booking, reviews, FAQ, blog.
 *
 * @package FlowFix
 */

get_header();

$flowfix_services = flowfix_services();
$flowfix_phone    = flowfix_opt( 'phone' );
// phpcs:disable WordPress.Security.NonceVerification.Recommended -- read-only status flags.
$flowfix_sent  = isset( $_GET['ff_sent'] );
$flowfix_error = isset( $_GET['ff_error'] ) ? sanitize_key( $_GET['ff_error'] ) : '';
// phpcs:enable
?>

<section class="hero">
	<div class="wrap hero-grid">
		<div>
			<p class="eyebrow"><?php esc_html_e( 'Licensed and insured since 2011', 'flowfix' ); ?></p>
			<h1><?php echo esc_html( flowfix_opt( 'hero_title' ) ); ?></h1>
			<p class="lead"><?php echo esc_html( flowfix_opt( 'hero_text' ) ); ?></p>
			<div class="hero-actions">
				<a class="btn btn-acc" href="#contact"><?php esc_html_e( 'Book a plumber', 'flowfix' ); ?></a>
				<a class="btn btn-ghost" href="#estimate"><?php esc_html_e( 'Get a price estimate', 'flowfix' ); ?></a>
			</div>
			<ul class="stats">
				<li><strong data-count="3200">3200</strong><span><?php esc_html_e( 'jobs a year', 'flowfix' ); ?></span></li>
				<li><strong data-count="60">60</strong><span><?php esc_html_e( 'min emergency arrival', 'flowfix' ); ?></span></li>
				<li><strong data-count="12">12</strong><span><?php esc_html_e( 'month guarantee', 'flowfix' ); ?></span></li>
			</ul>
		</div>
		<div class="hero-media">
			<img src="<?php echo esc_url( flowfix_opt( 'hero_image' ) ); ?>" alt="<?php esc_attr_e( 'Plumber repairing pipes in a bathroom', 'flowfix' ); ?>" width="550" height="450">
			<div class="hero-badge">
				<strong>4.9 / 5</strong>
				<span><?php esc_html_e( 'from 1,240 customer reviews', 'flowfix' ); ?></span>
			</div>
		</div>
	</div>
</section>

<section id="services" class="section">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Services', 'flowfix' ); ?></p>
		<h2><?php esc_html_e( 'What we fix and install', 'flowfix' ); ?></h2>
		<p class="section-lead"><?php esc_html_e( 'Every price is a starting point. You get a fixed quote on site before any work begins.', 'flowfix' ); ?></p>
		<div class="cards">
			<?php foreach ( $flowfix_services as $flowfix_service ) : ?>
				<article class="card reveal">
					<a class="card-media" href="<?php echo esc_url( get_permalink( $flowfix_service ) ); ?>" tabindex="-1" aria-hidden="true">
						<?php flowfix_service_image( $flowfix_service->ID ); ?>
					</a>
					<div class="card-body">
						<h3><a href="<?php echo esc_url( get_permalink( $flowfix_service ) ); ?>"><?php echo esc_html( get_the_title( $flowfix_service ) ); ?></a></h3>
						<p><?php echo esc_html( get_the_excerpt( $flowfix_service ) ); ?></p>
						<div class="card-foot">
							<span class="price">
								<?php
								/* translators: %s: price. */
								printf( esc_html__( 'from $%s', 'flowfix' ), esc_html( get_post_meta( $flowfix_service->ID, '_ff_price', true ) ) );
								?>
							</span>
							<span class="muted"><?php echo esc_html( get_post_meta( $flowfix_service->ID, '_ff_duration', true ) ); ?></span>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section-alt">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'How it works', 'flowfix' ); ?></p>
		<h2><?php esc_html_e( 'From call to fixed in four steps', 'flowfix' ); ?></h2>
		<ol class="steps">
			<li class="reveal"><h3><?php esc_html_e( 'Tell us the problem', 'flowfix' ); ?></h3><p><?php esc_html_e( 'Book online or call. Choose a two-hour arrival window that suits you.', 'flowfix' ); ?></p></li>
			<li class="reveal"><h3><?php esc_html_e( 'Plumber arrives', 'flowfix' ); ?></h3><p><?php esc_html_e( 'You get a call when the plumber is on the way, with the parts most jobs need.', 'flowfix' ); ?></p></li>
			<li class="reveal"><h3><?php esc_html_e( 'Fixed price first', 'flowfix' ); ?></h3><p><?php esc_html_e( 'The plumber inspects the problem and confirms the price before starting.', 'flowfix' ); ?></p></li>
			<li class="reveal"><h3><?php esc_html_e( 'Work guaranteed', 'flowfix' ); ?></h3><p><?php esc_html_e( 'We test everything with you, clean up and cover the job for 12 months.', 'flowfix' ); ?></p></li>
		</ol>
	</div>
</section>

<section id="estimate" class="section">
	<div class="wrap split">
		<div class="panel">
			<p class="eyebrow"><?php esc_html_e( 'Prices', 'flowfix' ); ?></p>
			<h2><?php esc_html_e( 'Estimate your job', 'flowfix' ); ?></h2>
			<p class="section-lead"><?php esc_html_e( 'Pick a service and how soon you need us. The final price is confirmed on site.', 'flowfix' ); ?></p>
			<div class="field">
				<label for="est-service"><?php esc_html_e( 'Service', 'flowfix' ); ?></label>
				<select id="est-service">
					<?php foreach ( $flowfix_services as $flowfix_service ) : ?>
						<option value="<?php echo esc_attr( $flowfix_service->ID ); ?>" data-price="<?php echo esc_attr( get_post_meta( $flowfix_service->ID, '_ff_price', true ) ); ?>"><?php echo esc_html( get_the_title( $flowfix_service ) ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<fieldset class="field">
				<legend><?php esc_html_e( 'When do you need it?', 'flowfix' ); ?></legend>
				<div class="choices">
					<label><input type="radio" name="est-urgency" value="standard" data-mult="1" checked> <span><?php esc_html_e( 'Next days', 'flowfix' ); ?></span></label>
					<label><input type="radio" name="est-urgency" value="sameday" data-mult="1.25"> <span><?php esc_html_e( 'Same day +25%', 'flowfix' ); ?></span></label>
					<label><input type="radio" name="est-urgency" value="emergency" data-mult="1.5"> <span><?php esc_html_e( 'Emergency +50%', 'flowfix' ); ?></span></label>
				</div>
			</fieldset>
			<p class="estimate" aria-live="polite"><?php esc_html_e( 'Estimated from', 'flowfix' ); ?> <strong id="est-total">$0</strong></p>
			<a class="btn btn-acc" id="est-book" href="#contact"><?php esc_html_e( 'Book this service', 'flowfix' ); ?></a>
		</div>

		<div class="panel panel-dark" id="contact">
			<h2><?php esc_html_e( 'Book a plumber', 'flowfix' ); ?></h2>
			<p><?php esc_html_e( 'Leave your details and we will call you back within 15 minutes during working hours.', 'flowfix' ); ?></p>
			<?php if ( $flowfix_sent ) : ?>
				<p class="notice notice-ok" role="status"><?php esc_html_e( 'Thank you! Your request has been received. We will call you shortly.', 'flowfix' ); ?></p>
			<?php elseif ( $flowfix_error ) : ?>
				<p class="notice notice-err" role="alert"><?php esc_html_e( 'Please enter your name and a valid phone number, then try again.', 'flowfix' ); ?></p>
			<?php endif; ?>
			<form class="booking" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
				<input type="hidden" name="action" value="flowfix_request">
				<?php wp_nonce_field( 'flowfix_request', 'flowfix_nonce' ); ?>
				<p class="hp" aria-hidden="true"><label><?php esc_html_e( 'Website', 'flowfix' ); ?> <input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>
				<div class="field">
					<label for="ff_name"><?php esc_html_e( 'Your name', 'flowfix' ); ?></label>
					<input id="ff_name" name="ff_name" type="text" autocomplete="name" required minlength="2">
					<span class="err" hidden><?php esc_html_e( 'Please enter your name.', 'flowfix' ); ?></span>
				</div>
				<div class="field">
					<label for="ff_phone"><?php esc_html_e( 'Phone', 'flowfix' ); ?></label>
					<input id="ff_phone" name="ff_phone" type="tel" autocomplete="tel" required>
					<span class="err" hidden><?php esc_html_e( 'Please enter a phone number with at least 7 digits.', 'flowfix' ); ?></span>
				</div>
				<div class="field">
					<label for="ff_service"><?php esc_html_e( 'Service', 'flowfix' ); ?></label>
					<select id="ff_service" name="ff_service">
						<option value="0"><?php esc_html_e( 'Not sure yet', 'flowfix' ); ?></option>
						<?php foreach ( $flowfix_services as $flowfix_service ) : ?>
							<option value="<?php echo esc_attr( $flowfix_service->ID ); ?>"><?php echo esc_html( get_the_title( $flowfix_service ) ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<input type="hidden" name="ff_urgency" id="ff_urgency" value="standard">
				<div class="field">
					<label for="ff_message"><?php esc_html_e( 'What happened? (optional)', 'flowfix' ); ?></label>
					<textarea id="ff_message" name="ff_message" rows="3"></textarea>
				</div>
				<button class="btn btn-acc" type="submit"><?php esc_html_e( 'Request a call back', 'flowfix' ); ?></button>
				<p class="form-note">
					<?php
					/* translators: %s: phone number. */
					printf( esc_html__( 'Urgent? Call %s', 'flowfix' ), esc_html( $flowfix_phone ) );
					?>
				</p>
			</form>
		</div>
	</div>
</section>

<?php
$flowfix_reviews = get_posts(
	array(
		'post_type'      => 'testimonial',
		'posts_per_page' => 3,
	)
);
if ( $flowfix_reviews ) :
	?>
<section id="reviews" class="section section-alt">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Reviews', 'flowfix' ); ?></p>
		<h2><?php esc_html_e( 'What customers say', 'flowfix' ); ?></h2>
		<div class="reviews">
			<?php foreach ( $flowfix_reviews as $flowfix_review ) : ?>
				<figure class="review reveal">
					<div class="stars" aria-label="<?php esc_attr_e( '5 out of 5 stars', 'flowfix' ); ?>">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
					<blockquote><?php echo esc_html( wp_strip_all_tags( $flowfix_review->post_content ) ); ?></blockquote>
					<figcaption><strong><?php echo esc_html( get_the_title( $flowfix_review ) ); ?></strong><span><?php echo esc_html( $flowfix_review->post_excerpt ); ?></span></figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section id="faq" class="section">
	<div class="wrap narrow">
		<p class="eyebrow"><?php esc_html_e( 'FAQ', 'flowfix' ); ?></p>
		<h2><?php esc_html_e( 'Questions before you book', 'flowfix' ); ?></h2>
		<div class="faq">
			<?php foreach ( flowfix_faq() as $flowfix_q => $flowfix_a ) : ?>
				<details>
					<summary><?php echo esc_html( $flowfix_q ); ?></summary>
					<p><?php echo esc_html( $flowfix_a ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
$flowfix_posts = get_posts( array( 'posts_per_page' => 3 ) );
if ( $flowfix_posts ) :
	?>
<section class="section section-alt">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Advice', 'flowfix' ); ?></p>
		<h2><?php esc_html_e( 'From our blog', 'flowfix' ); ?></h2>
		<div class="posts">
			<?php foreach ( $flowfix_posts as $flowfix_post ) : ?>
				<article class="post-card reveal">
					<time datetime="<?php echo esc_attr( get_the_date( 'c', $flowfix_post ) ); ?>"><?php echo esc_html( get_the_date( '', $flowfix_post ) ); ?></time>
					<h3><a href="<?php echo esc_url( get_permalink( $flowfix_post ) ); ?>"><?php echo esc_html( get_the_title( $flowfix_post ) ); ?></a></h3>
					<p><?php echo esc_html( wp_trim_words( $flowfix_post->post_excerpt, 22 ) ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
get_footer();
