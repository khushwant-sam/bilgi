<?php
if ( ! defined( 'myCRED_VERSION' ) ) exit;

/**
 * myCRED_Payment_Gateway class
 * @see http://mycred.me/add-ons/mycred_payment_gateway/
 * @since 0.1
 * @version 1.2
 */
if ( ! class_exists( 'myCRED_Payment_Gateway' ) ) {
	abstract class myCRED_Payment_Gateway {

		public $id;
		public $core;
		public $prefs = false;

		protected $current_user_id = 0;
		protected $sandbox_mode = NULL;
		public $gateway_logo_url = '';

		protected $response;
		protected $request;
		protected $status;
		protected $errors = array();
		protected $processing_log = NULL;

		/**
		 * Construct
		 */
		function __construct( $args = array(), $gateway_prefs = NULL ) {
			// Make sure gateway prefs is set
			if ( $gateway_prefs === NULL ) return;

			// Current User ID
			$this->current_user_id = get_current_user_id();

			// Arguments
			if ( ! empty( $args ) ) {
				foreach ( $args as $key => $value ) {
					$this->$key = $value;
				}
			}

			// Preferences
			if ( is_array( $gateway_prefs ) && isset( $gateway_prefs[ $this->id ] ) )
				$this->prefs = mycred_apply_defaults( $this->defaults, $gateway_prefs[ $this->id ] );

			elseif ( is_object( $gateway_prefs ) && isset( $gateway_prefs->gateway_prefs[ $this->id ] ) )
				$this->prefs = mycred_apply_defaults( $this->defaults, $gateway_prefs->gateway_prefs[ $this->id ] );

			else
				$this->prefs = $this->defaults;

			// Load myCRED
			if ( isset( $gateway_prefs->core ) )
				$mycred = $gateway_prefs->core;
			
			else
				$mycred = mycred();

			if ( isset( $mycred->buy_creds['type'] ) )
				$this->mycred_type = $mycred->buy_creds['type'];
			else
				$this->mycred_type = $mycred->cred_id;

			if ( $this->mycred_type != 'mycred_default' )
				$this->core = new myCRED_Settings( $this->mycred_type );
			else
				$this->core = $mycred;

			// Sandbox Mode
			if ( isset( $this->prefs['sandbox'] ) )
				$this->sandbox_mode = (bool) $this->prefs['sandbox'];

			if ( isset( $this->defaults['gateway_logo_url'] ) )
				$this->gateway_logo_url = $this->defaults['gateway_logo_url'];

			// Decode Log Entries
			add_filter( 'mycred_prep_template_tags',                          array( $this, 'decode_log_entries' ), 10, 2 );
			add_filter( 'mycred_parse_log_entry_buy_creds_with_' . $this->id, array( $this, 'log_entry' ), 10, 2          );
		}

		/**
		 * Process Purchase
		 * @since 0.1
		 * @version 1.0
		 */
		function process() {
			wp_die( 'function myCRED_Payment_Gateway::process() must be over-ridden in a sub-class.' );
		}

		/**
		 * Buy Creds Handler
		 * @since 0.1
		 * @version 1.0
		 */
		function buy() {
			wp_die( 'function myCRED_Payment_Gateway::buy() must be over-ridden in a sub-class.' );
		}

		/**
		 * Results Handler
		 * @since 0.1
		 * @version 1.0
		 */
		function returning() { }

		/**
		 * Preferences
		 * @since 0.1
		 * @version 1.0
		 */
		function preferences() {
			echo '<p>' . __( 'This Payment Gateway has no settings', 'mycred' ) . '</p>';
		}

		/**
		 * Sanatize Prefs
		 * @since 0.1
		 * @version 1.0
		 */
		function sanitise_preferences( $data ) {
			return $data;
		}

		/**
		 * Exchange Rate Setup
		 * @since 1.5
		 * @version 1.0.1
		 */
		function exchange_rate_setup( $default = 'USD' ) {
			if ( ! isset( $this->prefs['exchange'] ) ) return;

			$types = array( 'mycred_default' );
			if ( isset( $this->core->buy_creds['types'] ) )
				$types = (array) $this->core->buy_creds['types'];

			foreach ( $types as $type ) {
				$mycred = mycred( $type );
				
				if ( ! isset( $this->prefs['exchange'][ $type ] ) )
					$this->prefs['exchange'][ $type ] = 1;
?>

<li>
	<table>
		<tr>
			<td style="min-width: 100px;"><div class="h2">1 <?php echo $mycred->singular(); ?></div></td>
			<td style="width: 10px;"><div class="h2">=</div></td>
			<td><div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'exchange' => $type ) ); ?>" id="<?php echo $this->field_id( array( 'exchange' => $type ) ); ?>" value="<?php echo $this->prefs['exchange'][ $type ]; ?>" size="8" />
			<?php if ( isset( $this->prefs['currency'] ) ) : ?><span class="mycred-gateway-<?php echo $this->id; ?>-currency"><?php echo ( $this->prefs['currency'] == '' ) ? __( 'Select currency', 'mycred' ) : $this->prefs['currency']; ?></span><?php else : ?><span><?php echo $default; ?></span><?php endif; ?>
			</div></td>
		</tr>
	</table>
</li>
<?php
			}

		}

		/**
		 * Add Pending Payment
		 * @since 1.5
		 * @version 1.0
		 */
		function add_pending_payment( $data ) {

			$post_id = false;

			// Title
			if ( isset( $_REQUEST['transaction_id'] ) )
				$post_title = trim( $_REQUEST['transaction_id'] );
			else
				$post_title = strtoupper( wp_generate_password( 6, false, false ) );

			// Make sure we are not adding more then one pending item
			$check = get_page_by_title( $post_title, ARRAY_A, 'buycred_payment' );
			if ( $check === NULL || ( isset( $check['post_status'] ) && $check['post_status'] == 'trash' ) ) {

				// Generate new id
				if ( isset( $check['post_status'] ) && $check['post_status'] == 'trash' )
					$post_title = strtoupper( wp_generate_password( 6, false, false ) );

				// Insert post
				$post_id = wp_insert_post( array(
					'post_title'     => $post_title,
					'post_type'      => 'buycred_payment',
					'post_status'    => 'publish',
					'post_author'    => $this->current_user_id,
					'ping_status'    => 'closed',
					'comment_status' => 'closed'
				) );

				// Add meta details if insertion was a success
				if ( $post_id !== NULL && ! is_wp_error( $post_id ) ) {
					add_post_meta( $post_id, 'to',         $data[0] );
					add_post_meta( $post_id, 'from',       $data[1] );
					add_post_meta( $post_id, 'amount',     $data[2] );
					add_post_meta( $post_id, 'cost',       $data[3] );
					add_post_meta( $post_id, 'currency',   $data[4] );
					add_post_meta( $post_id, 'point_type', $data[5] );
					add_post_meta( $post_id, 'gateway',    $this->id );
				}
			}
			else $post_id = $check['ID'];

			return apply_filters( 'mycred_add_pending_payment', $post_id, $data );

		}

		/**
		 * Get Pending Payment
		 * @since 1.5
		 * @version 1.0.1
		 */
		function get_pending_payment( $post_id = '' ) {

			$post_id = sanitize_text_field( $post_id );
			if ( is_numeric( $post_id ) )
				$post = get_post( $post_id );
			else
				$post = get_page_by_title( $post_id, OBJECT, 'buycred_payment' );

			if ( isset( $post->ID ) && $post->post_type == 'buycred_payment' ) {
				$pending_payment = array();
				$pending_payment['to'] =       (int) get_post_meta( $post->ID, 'to', true );
				$pending_payment['from'] =     (int) get_post_meta( $post->ID, 'from', true );
				$pending_payment['amount'] =   get_post_meta( $post->ID, 'amount', true );
				$pending_payment['cost'] =     get_post_meta( $post->ID, 'cost', true );
				$pending_payment['currency'] = get_post_meta( $post->ID, 'currency', true );
				$pending_payment['ctype'] =    get_post_meta( $post->ID, 'point_type', true );
			}
			else {
				$pending_payment = false;
			}

			return apply_filters( 'mycred_get_pending_payment', $pending_payment, $post_id );

		}

		/**
		 * Log Gateway Call
		 * @since 1.5
		 * @version 1.0.1
		 */
		function log_call( $post_id, $log ) {

			if ( is_numeric( $post_id ) )
				$post = get_post( $post_id );
			else
				$post = get_page_by_title( $post_id, OBJECT, 'buycred_payment' );

			if ( isset( $post->ID ) )
				return wp_insert_comment( array(
					'comment_post_ID'   => $post->ID,
					'comment_author'    => $this->label,
					'comment_content'   => implode( '<br />', $log ),
					'comment_type'      => 'payment_gatway_call',
					'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
					'comment_date'      => current_time( 'mysql' ),
					'comment_approved'  => 1
				) );

		}

		/**
		 * Decode Log Entries
		 * @since 0.1
		 * @version 1.0
		 */
		function log_entry( $content, $log_entry ) {
			$content = $this->core->template_tags_user( $content, $log_entry->ref_id );
			return $content;
		}

		/**
		 * Get Log Entry
		 * @since 1.4
		 * @version 1.0
		 */
		function get_log_entry( $from = 0, $to = 0 ) {
			$entry = $this->get_entry( $from, $to );
			$entry = str_replace( '%gateway%', $this->label, $entry );
			if ( $this->sandbox_mode ) $entry = 'TEST ' . $entry;
			
			return apply_filters( 'mycred_buycred_get_log_entry', $entry, $from, $to, $this );
		}

		/**
		 * Get Field Name
		 * Returns the field name for the current gateway
		 * @since 0.1
		 * @version 1.0
		 */
		function field_name( $field = '' ) {
			if ( is_array( $field ) ) {
				$array = array();
				foreach ( $field as $parent => $child ) {
					if ( ! is_numeric( $parent ) )
						$array[] = str_replace( '-', '_', $parent );

					if ( ! empty( $child ) && ! is_array( $child ) )
						$array[] = str_replace( '-', '_', $child );
				}
				$field = '[' . implode( '][', $array ) . ']';
			}
			else {
				$field = '[' . $field . ']';
			}
			return 'mycred_pref_buycreds[gateway_prefs][' . $this->id . ']' . $field;
		}

		/**
		 * Get Field ID
		 * Returns the field id for the current gateway
		 * @since 0.1
		 * @version 1.0
		 */
		function field_id( $field = '' ) {
			if ( is_array( $field ) ) {
				$array = array();
				foreach ( $field as $parent => $child ) {
					if ( ! is_numeric( $parent ) )
						$array[] = str_replace( '_', '-', $parent );

					if ( ! empty( $child ) && ! is_array( $child ) )
						$array[] = str_replace( '_', '-', $child );
				}
				$field = implode( '-', $array );
			}
			else {
				$field = str_replace( '_', '-', $field );
			}
			return 'mycred-gateway-prefs-' . str_replace( '_', '-', $this->id ) . '-' . $field;
		}

		/**
		 * Callback URL
		 * @since 0.1
		 * @version 1.0
		 */
		function callback_url() {
			return get_bloginfo( 'url' ) . '/?mycred_call=' . $this->id;
		}

		/**
		 * Start Log
		 * @since 1.4
		 * @version 1.0
		 */
		function start_log() {
			$this->new_log_entry( __( 'Incoming confirmation call detected', 'mycred' ) );
			$this->new_log_entry( sprintf( __( 'Gateway identified itself as "%s"', 'mycred' ), $this->id ) );
			$this->new_log_entry( __( 'Verifying caller', 'mycred' ) );
		}

		/**
		 * New Log Entry
		 * @since 0.1
		 * @version 1.0
		 */
		function new_log_entry( $entry = '' ) {
			if ( ! isset( $this->processing_log[ $this->id ] ) )
				$this->processing_log[ $this->id ] = array();

			$this->processing_log[ $this->id ][] = $entry;
		}

		/**
		 * Save Log Entry
		 * @since 0.1
		 * @version 1.0
		 */
		function save_log_entry( $id = '', $outcome = '' ) {
			update_option( 'mycred_buycred_last_call', array(
				'gateway' => $this->id,
				'date'    => time(),
				'outcome' => $outcome,
				'id'      => $id,
				'entries' => serialize( $this->processing_log[ $this->id ] )
			) );
		}

		/**
		 * Payment Page Header
		 * @since 0.1
		 * @version 1.1
		 */
		function get_page_header( $site_title = '', $reload = false ) {
			// Set Logo
			$logo = '';
			if ( isset( $this->prefs['logo'] ) && ! empty( $this->prefs['logo'] ) )
				$logo = '<img src="' . $this->prefs['logo'] . '" alt="" />';
			elseif ( isset( $this->prefs['logo_url'] ) && ! empty( $this->prefs['logo_url'] ) )
				$logo = '<img src="' . $this->prefs['logo_url'] . '" alt="" />';
			elseif ( isset( $this->gateway_logo_url ) && ! empty( $this->gateway_logo_url ) )
				$logo = '<img src="' . $this->gateway_logo_url . '" alt="" />';
			
			if ( $this->sandbox_mode )
				$title = __( 'Test Payment', 'mycred' );
			elseif ( isset( $this->label ) )
				$title = $this->label;
			else
				$title = __( 'Payment', 'mycred' );

			if ( ! isset( $this->transaction_id ) )
				$this->transaction_id = ''; ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<title><?php echo $site_title; ?></title>
	<meta name="robots" content="noindex, nofollow" />
	<?php if ( $reload ) echo '<meta http-equiv="refresh" content="2;url=' . $reload . '" />'; ?>

	<link rel="stylesheet" href="<?php echo plugins_url( 'assets/css/gateway.css', myCRED_PURCHASE ); ?>" type="text/css" media="all" />
	<?php do_action( 'mycred_buycred_page_header', $title, $reload, $this->id ); ?>

</head>
<body>
	<div id="payment-title"><?php echo $logo; ?><?php echo $title; ?><a href="<?php echo $this->get_cancelled( $this->transaction_id ); ?>" id="return-where-we-came-from"><?php _e( 'Cancel purchase', 'mycred_stripe' ); ?></a></div>
<?php
			do_action( 'mycred_buycred_page_top', $title, $reload, $this->id );
		}
			public function purchase_header( $title = '', $reload = false ) {
				$this->get_page_header( $title, $reload );
			}

		/**
		 * Payment Page Footer
		 * @since 0.1
		 * @version 1.1
		 */
		function get_page_footer() {
			do_action( 'mycred_buycred_page_footer', $this->id ); ?>

</body> 
</html>
<?php
		}
			function purchase_footer() {
				$this->get_page_footer();
			}

		/**
		 * Get Billing Address Form
		 * @since 1.4
		 * @version 1.0
		 */
		function get_billing_address_form( $country_dropdown = false ) {
			if ( ! is_user_logged_in() ) return;

			$user = wp_get_current_user();

			// Base
			$user_details = array(
				'first_name' => ( isset( $_POST['billing']['first_name'] ) ) ? $_POST['billing']['first_name'] : $user->first_name,
				'last_name'  => ( isset( $_POST['billing']['last_name'] )  ) ? $_POST['billing']['last_name']  : $user->last_name,
				'address1'   => ( isset( $_POST['billing']['address1'] )   ) ? $_POST['billing']['address1']   : $user->address1,
				'address2'   => ( isset( $_POST['billing']['address2'] )   ) ? $_POST['billing']['address2']   : $user->address2,
				'city'       => ( isset( $_POST['billing']['city'] )       ) ? $_POST['billing']['city']       : $user->city,
				'postcode'   => ( isset( $_POST['billing']['postcode'] )   ) ? $_POST['billing']['postcode']   : $user->postcode,
				'state'      => ( isset( $_POST['billing']['state'] )      ) ? $_POST['billing']['state']      : $user->state,
				'country'    => ( isset( $_POST['billing']['country'] )    ) ? $_POST['billing']['country']    : $user->country
			);

			// Grab WooCommerce User Fields
			if ( ! isset( $_POST['billing']['address1'] ) ) {
				if ( class_exists( 'WC_Customer' ) ) {
					$user_details['first_name'] = get_user_meta( $user->ID, 'billing_first_name', true );
					$user_details['last_name']  = get_user_meta( $user->ID, 'billing_last_name',  true );
					$user_details['address1']   = get_user_meta( $user->ID, 'billing_address_1',  true );
					$user_details['address2']   = get_user_meta( $user->ID, 'billing_address_2',  true );
					$user_details['city']       = get_user_meta( $user->ID, 'billing_city',       true );
					$user_details['postcode']   = get_user_meta( $user->ID, 'billing_postcode',   true );
					$user_details['state']      = get_user_meta( $user->ID, 'billing_state',      true );
				}

				// Else grab MarketPress User Fields
				elseif ( class_exists( 'MarketPress' ) ) {
					$meta = get_user_meta( $user->ID, 'mp_billing_info', true );
					if ( is_array( $meta ) ) {
						$user_details['address1']   = ( isset( $meta['address1'] ) ) ? $meta['address1'] : '';
						$user_details['address2']   = ( isset( $meta['address2'] ) ) ? $meta['address2'] : '';
						$user_details['city']       = ( isset( $meta['city'] ) )     ? $meta['city']     : '';
						$user_details['postcode']   = ( isset( $meta['zip'] ) )      ? $meta['zip']      : '';
						$user_details['state']      = ( isset( $meta['state'] ) )    ? $meta['state']    : '';
						$user_details['country']    = ( isset( $meta['country'] ) )  ? $meta['country']  : '';
					}
				}
			}

			// Let others play
			$user_details = apply_filters( 'mycred_buycred_user_details', $user_details, $this );

			// Required Fields
			$required_fields = apply_filters( 'mycred_buycred_req_fields', array( 'first_name', 'last_name', 'address1', 'city', 'zip', 'state', 'country' ), $this );

			// Show required and optional fields via placeholders
			$required = 'placeholder="' . __( 'required', 'mycred' ) . '"';
			$optional = 'placeholder="' . __( 'optional', 'mycred' ) . '"'; ?>

<div class="gateway-section">
	<ul class="input-fields">
		<li class="inline">
			<label for="billing-first-name"><?php _e( 'First Name', 'mycred' ); ?></label>
			<input type="text" name="billing[first_name]" id="billing-first-name" value="<?php echo $user_details['first_name']; ?>" class="long<?php if ( array_key_exists( 'first_name', $this->errors ) ) { echo ' error'; } ?>" <?php if ( in_array( 'first_name', $required_fields ) ) echo $required; else echo $optional; ?> autocomplete="off"  />
		</li>
		<li class="inline last">
			<label for="billing-last-name"><?php _e( 'Last Name', 'mycred' ); ?></label>
			<input type="text" name="billing[last_name]" id="billing-last-name" value="<?php echo $user_details['last_name']; ?>" class="long<?php if ( array_key_exists( 'last_name', $this->errors ) ) { echo ' error'; } ?>" <?php if ( in_array( 'last_name', $required_fields ) ) echo $required; else echo $optional; ?>  autocomplete="off"  />
		</li>
		<li class="inline">
			<label for="billing-address1"><?php _e( 'Address Line 1', 'mycred' ); ?></label>
			<input type="text" name="billing[address1]" id="billing-address1" value="<?php echo $user_details['address1']; ?>" class="long<?php if ( array_key_exists( 'address1', $this->errors ) ) { echo ' error'; } ?>" <?php if ( in_array( 'address1', $required_fields ) ) echo $required; else echo $optional; ?> autocomplete="off"  />
		</li>
		<li class="inline">
			<label for="billing-address2"><?php _e( 'Address Line 2', 'mycred' ); ?></label>
			<input type="text" name="billing[address2]" id="billing-address2" value="<?php echo $user_details['address2']; ?>" class="long<?php if ( array_key_exists( 'address2', $this->errors ) ) { echo ' error'; } ?>" <?php if ( in_array( 'address2', $required_fields ) ) echo $required; else echo $optional; ?> autocomplete="off"  />
		</li>
		<li class="inline">
			<label for="billing-city"><?php _e( 'City', 'mycred' ); ?></label>
			<input type="text" name="billing[city]" id="billing-city" value="<?php echo $user_details['city']; ?>" class="medium<?php if ( array_key_exists( 'city', $this->errors ) ) { echo ' error'; } ?>" <?php if ( in_array( 'city', $required_fields ) ) echo $required; else echo $optional; ?> autocomplete="off"  />
		</li>
		<li class="inline">
			<label for="billing-zip"><?php _e( 'Zip', 'mycred' ); ?></label>
			<input type="text" name="billing[zip]" id="billing-zip" value="<?php echo $user_details['postcode']; ?>" class="short<?php if ( array_key_exists( 'zip', $this->errors ) ) { echo ' error'; } ?>" <?php if ( in_array( 'zip', $required_fields ) ) echo $required; else echo $optional; ?> autocomplete="off"  />
		</li>
		<li class="inline">
			<label for="billing-state"><?php _e( 'State', 'mycred' ); ?></label>
			<input type="text" name="billing[state]" id="billing-state" value="<?php echo $user_details['state']; ?>" class="short<?php if ( array_key_exists( 'state', $this->errors ) ) { echo ' error'; } ?>" <?php if ( in_array( 'state', $required_fields ) ) echo $required; else echo $optional; ?> autocomplete="off"  />
		</li>
		<li class="inline last">
			<label for="billing-country"><?php _e( 'Country', 'mycred' ); ?></label>
			<?php if ( $country_dropdown !== false ) : ?>
			<select name="billing[country]" id="billing-country">
				<option value=""><?php _e( 'Choose Country', 'mycred' ); ?></option>
				<?php $this->list_option_countries(); ?>
			</select>
			<?php else : ?>
				<input type="text" name="billing[country]" id="billing-country" value="<?php echo $user_details['country']; ?>" class="medium<?php if ( array_key_exists( 'country', $this->errors ) ) { echo ' error'; } ?>" <?php if ( in_array( 'country', $required_fields ) ) echo $required; else echo $optional; ?> autocomplete="off"  />

			<?php endif; ?>
			
		</li>
	</ul>
	<?php do_action( 'mycred_buycred_after_billing_details', $user_details, $this ); ?>

</div>
<?php
		}

		/**
		 * Get Order
		 * @since 1.0
		 * @version 1.0
		 */
		function get_order( $amount, $cost ) {
			$order_name = apply_filters( 'mycred_buycred_order_name', sprintf( __( '%s Purchase', 'mycred' ), $this->core->singular() ), $amount, $cost, $this ) ?>

<table cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th id="gateway-order-item" class="order-item"><?php _e( 'Item', 'mycred' ); ?></th>
			<th id="gateway-order-amount" class="order-amount"><?php _e( 'Amount', 'mycred' ); ?></th>
			<th id="gateway-order-cost" class="order-cost"><?php _e( 'Cost', 'mycred' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class=""><?php echo $order_name; ?></td>
			<td class=""><?php echo $amount; ?></td>
			<td class=""><?php echo $cost; ?> <?php if ( isset( $this->prefs['currency'] ) ) echo $this->prefs['currency']; else echo 'USD'; ?></td>
		</tr>
	</tbody>
</table>
<?php
		}

		/**
		 * Get Debug
		 * @since 1.0
		 * @version 1.0
		 */
		function get_debug() { ?>

<h2><?php _e( 'Debug', 'mycred' ); ?></h2>
<p><span class="description"><?php _e( 'Here you can see information that are collected and sent to this gateway. Debug information is only visible for administrators and are intended for troubleshooting / testing of this gateway. Please disable "Sandbox Mode" when you want to take this gateway online.', 'mycred' ); ?></span></p>
<table id="gateway-debug">
	<thead>
		<tr>
			<th id="gateway-col-section" class="col-section"><?php _e( 'Section', 'mycred' ); ?></th>
			<th id="gateway-col-result" class="col-result"><?php _e( 'Result', 'mycred' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="col-section"><?php _e( 'Payment Status', 'mycred' ); ?></td>
			<td class="col-result"><pre><?php print_r( $this->status ); ?></pre></td>
		</tr>
		<tr>
			<td class="col-section"><?php _e( 'Request', 'mycred' ); ?></td>
			<td class="col-result"><pre><?php print_r( $this->request ); ?></pre></td>
		</tr>
		<tr>
			<td class="col-section"><?php _e( 'Gateway Response', 'mycred' ); ?></td>
			<td class="col-result"><pre><?php print_r( $this->response ); ?></pre></td>
		</tr>
	</tbody>
</table>
<?php
		}

		/**
		 * Get Errors
		 * @since 1.0
		 * @version 1.0
		 */
		function get_errors() {
			if ( empty( $this->errors ) ) return;

			$errors = array();
			foreach ( $this->errors as $form_field => $error_message )
				$errors[] = $error_message; ?>

<div class="gateway-error"><?php echo implode( '<br />', $errors ); ?></div>
<?php
		}

		/**
		 * Form Builder with Redirect
		 * Used by gateways that redirects users to a remote processor.
		 * @since 0.1
		 * @version 1.0
		 */
		function get_page_redirect( $hidden_fields = array(), $location = '' ) {
			$id = str_replace( '-', '_', $this->id );

			// Logo
			if ( empty( $logo_url ) )
				$logo_url = plugins_url( 'images/cred-icon32.png', myCRED_THIS );

			// Hidden Fields
			$hidden_fields = apply_filters( "mycred_{$id}_purchase_fields", $hidden_fields, $this ); ?>

<form name="mycred_<?php echo $id; ?>_request" action="<?php echo $location; ?>" method="post" id="redirect-form">
<?php
			// Required hidden form fields
			foreach ( $hidden_fields as $name => $value )
				echo "\t" . '<input type="hidden" name="' . $name . '" value="' . $value . '" />' . "\n"; ?>

		<img src="<?php echo plugins_url( 'assets/images/loading.gif', myCRED_PURCHASE ); ?>" alt="Loading" />
		<noscript><input type="submit" name="submit-form" value="<?php printf( __( 'Continue to %s', 'mycred' ), $this->label ); ?>" /></noscript>
		<p id="manual-continue"><a href="javascript:void(0);" onclick="document.mycred_<?php echo str_replace( '-', '_', $this->id ); ?>_request.submit();return false;"><?php _e( 'Click here if you are not automatically redirected', 'mycred' ); ?></a></p>
</form>
<?php		if ( $this->sandbox_mode ) : ?>

<div class="gateway-section">
	<pre><?php _e( 'The following information will be sent to the gateway', 'mycred' ); ?>:

<?php print_r( $hidden_fields ); ?></pre>
</div>
<?php		endif; ?>

<script type="text/javascript">
<?php if ( $this->sandbox_mode ) echo '//'; ?>setTimeout( "document.mycred_<?php echo $id; ?>_request.submit()",2000 );
</script>
<?php
		}
			function form_with_redirect( $hidden_fields = array(), $location = '', $logo_url = '', $custom_html = '', $sales_data = '' ) {
				$this->get_page_redirect( $hidden_fields, $location, $custom_html, $sales_data );
			}

		/**
		 * Get To
		 * Returns either the current user id or if gifting is enabled and used
		 * the id of the user this is gifted to.
		 * @since 0.1
		 * @version 1.0
		 */
		function get_to() {
			// Gift to a user
			if ( $this->core->buy_creds['gifting']['members'] == 1 ) {
				if ( isset( $_POST['gift_to'] ) ) {
					$gift_to = trim( $_POST['gift_to'] );
					return absint( $gift_to );
				}
				elseif ( isset( $_GET['gift_to'] ) ) {
					$gift_to = trim( $_GET['gift_to'] );
					return absint( $gift_to );
				}
			}

			// Gifting author
			if ( $this->core->buy_creds['gifting']['authors'] == 1 ) {
				if ( isset( $_REQEST['post_id'] ) ) {
					$post_id = trim( $_POST['post_id'] );
					$post_id = absint( $post_id );
					$post = get_post( $post_id );
					if ( isset( $post->post_author ) )
						return absint( $post->post_author );
				}
			}

			return $this->current_user_id;
		}

		/**
		 * Get Thank You Page
		 * @since 0.1
		 * @version 1.0
		 */
		function get_thankyou() {
			if ( $this->core->buy_creds['thankyou']['use'] == 'page' ) {
				if ( empty( $this->core->buy_creds['thankyou']['page'] ) )
					return get_bloginfo( 'url' );
				else
					return get_permalink( $this->core->buy_creds['thankyou']['page'] );
			}

			return get_bloginfo( 'url' ) . '/' . $this->core->buy_creds['thankyou']['custom'];
		}

		/**
		 * Get Cancelled Page
		 * @since 0.1
		 * @version 1.2
		 */
		function get_cancelled( $title = '' ) {
			if ( $this->core->buy_creds['cancelled']['use'] == 'page' ) {
				if ( empty( $this->core->buy_creds['cancelled']['page'] ) )
					$base = get_bloginfo( 'url' );
				else
					$base = get_permalink( $this->core->buy_creds['cancelled']['page'] );
			}
			else {
				$base = get_bloginfo( 'url' ) . '/' . $this->core->buy_creds['cancelled']['custom'];
			}

			if ( isset( $_REQUEST['return_to'] ) )
				$base = $_REQUEST['return_to'];

			if ( $title != '' )
				return add_query_arg( array( 'buycred_cancel' => $title ), $base );
			else
				return $base;
		}

		/**
		 * Get Entry
		 * Returns the appropriate log entry template.
		 * @since 0.1
		 * @version 1.0
		 */
		function get_entry( $_to, $_from ) {
			// Log entry
			if ( $_to == $_from ) return $this->core->buy_creds['log'];

			if ( $this->core->buy_creds['gifting']['members'] == 1 || $this->core->buy_creds['gifting']['authors'] == 1 )
				return $this->core->buy_creds['gifting']['log'];

			return $this->core->buy_creds['log'];
		}

		/**
		 * POST to data
		 * @since 0.1
		 * @version 1.2
		 */
		function POST_to_data( $unset = false ) {
			$data = array();
			foreach ( $_POST as $key => $value ) {
				$data[ $key ] = stripslashes( $value );
			}
			if ( $unset )
				unset( $_POST );

			return $data;
		}

		/**
		 * Transaction ID unique
		 * Searches the Log for a given transaction.
		 *
		 * @returns (bool) true if transaction id is unique or false
		 * @since 0.1
		 * @version 1.0.1
		 */
		function transaction_id_is_unique( $transaction_id = '' ) {
			if ( empty( $transaction_id ) ) return false;

			global $wpdb;

			// Make sure this is a new transaction
			$sql = "
				SELECT * 
				FROM {$this->core->log_table} 
				WHERE ref = %s 
					AND data LIKE %s 
					AND ctype = %s;";

			$gateway = str_replace( '-', '_', $this->id );
			$gateway_id = 'buy_creds_with_' . $gateway;

			$check = $wpdb->get_results( $wpdb->prepare( $sql, $gateway_id, "%:\"" . $transaction_id . "\";%", $this->mycred_type ) );
			if ( $wpdb->num_rows > 0 ) return false;

			return true;
		}

		/**
		 * Create Unique Transaction ID
		 * Returns a unique transaction ID that has no been used by buyCRED yet.
		 * @since 1.4
		 * @version 1.0
		 */
		function create_unique_transaction_id() {
			global $wpdb;

			do {

				$id = strtoupper( wp_generate_password( 12, false, false ) );
				$query = $wpdb->get_row( $wpdb->prepare( "
					SELECT * 
					FROM {$this->core->log_table} 
					WHERE ref LIKE %s 
						AND data LIKE %s;", 'buy_creds_with_%', "%:\"" . $id . "\";%" ) );

			} while ( ! empty( $query ) );
	
			return $id;
		}

		/**
		 * Create Token
		 * Returns a wp nonce
		 * @since 0.1
		 * @version 1.0
		 */
		function create_token( $user_id = NULL ) {
			return wp_create_nonce( 'mycred-buy-' . $this->id );
		}

		/**
		 * Get Point Type
		 * @since 1.5
		 * @version 1.0.1
		 */
		function get_point_type() {
			$type = '';
			
			if ( isset( $_REQUEST['ctype'] ) )
				$type = sanitize_text_field( $_REQUEST['ctype'] );

			if ( $type == '' )
				$type = 'mycred_default';

			return $type;
		}

		/**
		 * Verify Token
		 * Based on wp_verify_nonce() this function requires the user id used when the token
		 * was created as by default not logged in users would generate different tokens causing us
		 * to fail.
		 *
		 * @param $user_id (int) required user id
		 * @param $nonce (string) required nonce to check
		 * @returns true or false
		 * @since 0.1
		 * @version 1.0.1
		 */
		function verify_token( $user_id, $nonce ) {
			$uid = absint( $user_id );

			$i = wp_nonce_tick();

			if ( substr( wp_hash( $i . 'mycred-buy-' . $this->id . $uid, 'nonce' ), -12, 10 ) == $nonce )
				return true;
			if ( substr( wp_hash( ( $i - 1 ) . 'mycred-buy-' . $this->id . $uid, 'nonce' ), -12, 10 ) === $nonce )
				return true;

			return false;
		}

		/**
		 * Encode Sales Data
		 * @since 0.1
		 * @version 1.1
		 */
		function encode_sales_data( $data ) {
			$protect = new myCRED_Protect();
			if ( $protect !== false )
				return $protect->do_encode( $data );
			else
				return $data;
		}

		/**
		 * Decode Sales Data
		 * @since 0.1
		 * @version 1.1
		 */
		function decode_sales_data( $data ) {
			$protect = new myCRED_Protect();
			if ( $protect !== false )
				return $protect->do_decode( $data );
			else
				return $data;
		}

		/**
		 * Get Cost
		 * @since 1.3.2
		 * @version 1.1
		 */
		function get_cost( $amount = 0, $type = 'mycred_default', $raw = false ) {
			// Apply minimum
			if ( $amount < $this->core->buy_creds['minimum'] )
				$amount = $this->core->buy_creds['minimum'];

			// Calculate cost here so we can use any exchange rate
			if ( isset( $this->prefs['exchange'][ $type ] ) ) {
				// Check for user override
				$override = mycred_get_user_meta( $this->current_user_id, 'mycred_buycred_rates_' . $type, '', true );
				if ( isset( $override[ $this->id ] ) && $override[ $this->id ] != '' )
					$rate = $override[ $this->id ];
				else
					$rate = $this->prefs['exchange'][ $type ];

				if ( isfloat( $rate ) )
					$rate = (float) $rate;
				else
					$rate = (int) $rate;

				$mycred = mycred( $type );
				$cost = $mycred->number( $amount ) * $rate;
			}
			else
				$cost = $amount;

			// Return a properly formated cost so PayPal is happy
			if ( ! $raw )
				$cost = number_format( $cost, 2, '.', '' );

			return apply_filters( 'mycred_buycred_get_cost', $cost, $amount, $type, $this->prefs, $this->core->buy_creds );
		}

		/**
		 * Currencies Dropdown
		 * @since 0.1
		 * @version 1.0.2
		 */
		function currencies_dropdown( $name = '', $js = '' ) {
			$currencies = array(
				'USD' => 'US Dollars',
				'AUD' => 'Australian Dollars',
				'CAD' => 'Canadian Dollars',
				'EUR' => 'Euro',
				'GBP' => 'British Pound Sterling',
				'JPY' => 'Japanese Yen',
				'NZD' => 'New Zealand Dollars',
				'CHF' => 'Swiss Francs',
				'HKD' => 'Hong Kong Dollars',
				'SGD' => 'Singapore Dollars',
				'SEK' => 'Swedish Kronor',
				'DKK' => 'Danish Kroner',
				'PLN' => 'Polish Zloty',
				'NOK' => 'Norwegian Kronor',
				'HUF' => 'Hungarian Forint',
				'CZK' => 'Check Koruna',
				'ILS' => 'Israeli Shekel',
				'MXN' => 'Mexican Peso',
				'BRL' => 'Brazilian Real',
				'MYR' => 'Malaysian Ringgits',
				'PHP' => 'Philippine Pesos',
				'RUB' => 'Russian Ruble',
				'TWD' => 'Taiwan New Dollars',
				'THB' => 'Thai Baht'
			);
			$currencies = apply_filters( 'mycred_dropdown_currencies', $currencies, $this->id );
			$currencies = apply_filters( 'mycred_dropdown_currencies_' . $this->id, $currencies );

			if ( $js != '' )
				$js = ' data-update="' . $js . '"';

			echo '<select name="' . $this->field_name( $name ) . '" id="' . $this->field_id( $name ) . '" class="currency"' . $js . '>';
			echo '<option value="">' . __( 'Select', 'mycred' ) . '</option>';
			foreach ( $currencies as $code => $cname ) {
				echo '<option value="' . $code . '"';
				if ( isset( $this->prefs[ $name ] ) && $this->prefs[ $name ] == $code ) echo ' selected="selected"';
				echo '>' . $cname . '</option>';
			}
			echo '</select>';
		}

		/**
		 * Item Type Dropdown
		 * @since 0.1
		 * @version 1.0
		 */
		function item_types_dropdown( $name = '' ) {
			$types = array(
				'product'  => 'Product',
				'service'  => 'Service',
				'donation' => 'Donation'
			);
			$types = apply_filters( 'mycred_dropdown_item_types', $types );

			echo '<select name="' . $this->field_name( $name ) . '" id="' . $this->field_id( $name ) . '">';
			echo '<option value="">' . __( 'Select', 'mycred' ) . '</option>';
			foreach ( $types as $code => $cname ) {
				echo '<option value="' . $code . '"';
				if ( isset( $this->prefs[ $name ] ) && $this->prefs[ $name ] == $code ) echo ' selected="selected"';
				echo '>' . $cname . '</option>';
			}
			echo '</select>';
		}

		/**
		 * Countries Dropdown Options
		 * @since 0.1
		 * @version 1.0
		 */
		function list_option_countries( $selected = '' ) {
			$countries = array (
				"US"  =>  "UNITED STATES",
				"AF"  =>  "AFGHANISTAN",
				"AL"  =>  "ALBANIA",
				"DZ"  =>  "ALGERIA",
				"AS"  =>  "AMERICAN SAMOA",
				"AD"  =>  "ANDORRA",
				"AO"  =>  "ANGOLA",
				"AI"  =>  "ANGUILLA",
				"AQ"  =>  "ANTARCTICA",
				"AG"  =>  "ANTIGUA AND BARBUDA",
				"AR"  =>  "ARGENTINA",
				"AM"  =>  "ARMENIA",
				"AW"  =>  "ARUBA",
				"AU"  =>  "AUSTRALIA",
				"AT"  =>  "AUSTRIA",
				"AZ"  =>  "AZERBAIJAN",
				"BS"  =>  "BAHAMAS",
				"BH"  =>  "BAHRAIN",
				"BD"  =>  "BANGLADESH",
				"BB"  =>  "BARBADOS",
				"BY"  =>  "BELARUS",
				"BE"  =>  "BELGIUM",
				"BZ"  =>  "BELIZE",
				"BJ"  =>  "BENIN",
				"BM"  =>  "BERMUDA",
				"BT"  =>  "BHUTAN",
				"BO"  =>  "BOLIVIA",
				"BA"  =>  "BOSNIA AND HERZEGOVINA",
				"BW"  =>  "BOTSWANA",
				"BV"  =>  "BOUVET ISLAND",
				"BR"  =>  "BRAZIL",
				"IO"  =>  "BRITISH INDIAN OCEAN TERRITORY",
				"BN"  =>  "BRUNEI DARUSSALAM",
				"BG"  =>  "BULGARIA",
				"BF"  =>  "BURKINA FASO",
				"BI"  =>  "BURUNDI",
				"KH"  =>  "CAMBODIA",
				"CM"  =>  "CAMEROON",
				"CA"  =>  "CANADA",
				"CV"  =>  "CAPE VERDE",
				"KY"  =>  "CAYMAN ISLANDS",
				"CF"  =>  "CENTRAL AFRICAN REPUBLIC",
				"TD"  =>  "CHAD",
				"CL"  =>  "CHILE",
				"CN"  =>  "CHINA",
				"CX"  =>  "CHRISTMAS ISLAND",
				"CC"  =>  "COCOS (KEELING) ISLANDS",
				"CO"  =>  "COLOMBIA",
				"KM"  =>  "COMOROS",
				"CG"  =>  "CONGO",
				"CD"  =>  "CONGO, THE DEMOCRATIC REPUBLIC OF THE",
				"CK"  =>  "COOK ISLANDS",
				"CR"  =>  "COSTA RICA",
				"CI"  =>  "COTE D'IVOIRE",
				"HR"  =>  "CROATIA",
				"CU"  =>  "CUBA",
				"CY"  =>  "CYPRUS",
				"CZ"  =>  "CZECH REPUBLIC",
				"DK"  =>  "DENMARK",
				"DJ"  =>  "DJIBOUTI",
				"DM"  =>  "DOMINICA",
				"DO"  =>  "DOMINICAN REPUBLIC",
				"EC"  =>  "ECUADOR",
				"EG"  =>  "EGYPT",
				"SV"  =>  "EL SALVADOR",
				"GQ"  =>  "EQUATORIAL GUINEA",
				"ER"  =>  "ERITREA",
				"EE"  =>  "ESTONIA",
				"ET"  =>  "ETHIOPIA",
				"FK"  =>  "FALKLAND ISLANDS (MALVINAS)",
				"FO"  =>  "FAROE ISLANDS",
				"FJ"  =>  "FIJI",
				"FI"  =>  "FINLAND",
				"FR"  =>  "FRANCE",
				"GF"  =>  "FRENCH GUIANA",
				"PF"  =>  "FRENCH POLYNESIA",
				"TF"  =>  "FRENCH SOUTHERN TERRITORIES",
				"GA"  =>  "GABON",
				"GM"  =>  "GAMBIA",
				"GE"  =>  "GEORGIA",
				"DE"  =>  "GERMANY",
				"GH"  =>  "GHANA",
				"GI"  =>  "GIBRALTAR",
				"GR"  =>  "GREECE",
				"GL"  =>  "GREENLAND",
				"GD"  =>  "GRENADA",
				"GP"  =>  "GUADELOUPE",
				"GU"  =>  "GUAM",
				"GT"  =>  "GUATEMALA",
				"GN"  =>  "GUINEA",
				"GW"  =>  "GUINEA-BISSAU",
				"GY"  =>  "GUYANA",
				"HT"  =>  "HAITI",
				"HM"  =>  "HEARD ISLAND AND MCDONALD ISLANDS",
				"VA"  =>  "HOLY SEE (VATICAN CITY STATE)",
				"HN"  =>  "HONDURAS",
				"HK"  =>  "HONG KONG",
				"HU"  =>  "HUNGARY",
				"IS"  =>  "ICELAND",
				"IN"  =>  "INDIA",
				"ID"  =>  "INDONESIA",
				"IR"  =>  "IRAN, ISLAMIC REPUBLIC OF",
				"IQ"  =>  "IRAQ",
				"IE"  =>  "IRELAND",
				"IL"  =>  "ISRAEL",
				"IT"  =>  "ITALY",
				"JM"  =>  "JAMAICA",
				"JP"  =>  "JAPAN",
				"JO"  =>  "JORDAN",
				"KZ"  =>  "KAZAKHSTAN",
				"KE"  =>  "KENYA",
				"KI"  =>  "KIRIBATI",
				"KP"  =>  "KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF",
				"KR"  =>  "KOREA, REPUBLIC OF",
				"KW"  =>  "KUWAIT",
				"KG"  =>  "KYRGYZSTAN",
				"LA"  =>  "LAO PEOPLE'S DEMOCRATIC REPUBLIC",
				"LV"  =>  "LATVIA",
				"LB"  =>  "LEBANON",
				"LS"  =>  "LESOTHO",
				"LR"  =>  "LIBERIA",
				"LY"  =>  "LIBYAN ARAB JAMAHIRIYA",
				"LI"  =>  "LIECHTENSTEIN",
				"LT"  =>  "LITHUANIA",
				"LU"  =>  "LUXEMBOURG",
				"MO"  =>  "MACAO",
				"MK"  =>  "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF",
				"MG"  =>  "MADAGASCAR",
				"MW"  =>  "MALAWI",
				"MY"  =>  "MALAYSIA",
				"MV"  =>  "MALDIVES",
				"ML"  =>  "MALI",
				"MT"  =>  "MALTA",
				"MH"  =>  "MARSHALL ISLANDS",
				"MQ"  =>  "MARTINIQUE",
				"MR"  =>  "MAURITANIA",
				"MU"  =>  "MAURITIUS",
				"YT"  =>  "MAYOTTE",
				"MX"  =>  "MEXICO",
				"FM"  =>  "MICRONESIA, FEDERATED STATES OF",
				"MD"  =>  "MOLDOVA, REPUBLIC OF",
				"MC"  =>  "MONACO",
				"MN"  =>  "MONGOLIA",
				"MS"  =>  "MONTSERRAT",
				"MA"  =>  "MOROCCO",
				"MZ"  =>  "MOZAMBIQUE",
				"MM"  =>  "MYANMAR",
				"NA"  =>  "NAMIBIA",
				"NR"  =>  "NAURU",
				"NP"  =>  "NEPAL",
				"NL"  =>  "NETHERLANDS",
				"AN"  =>  "NETHERLANDS ANTILLES",
				"NC"  =>  "NEW CALEDONIA",
				"NZ"  =>  "NEW ZEALAND",
				"NI"  =>  "NICARAGUA",
				"NE"  =>  "NIGER",
				"NG"  =>  "NIGERIA",
				"NU"  =>  "NIUE",
				"NF"  =>  "NORFOLK ISLAND",
				"MP"  =>  "NORTHERN MARIANA ISLANDS",
				"NO"  =>  "NORWAY",
				"OM"  =>  "OMAN",
				"PK"  =>  "PAKISTAN",
				"PW"  =>  "PALAU",
				"PS"  =>  "PALESTINIAN TERRITORY, OCCUPIED",
				"PA"  =>  "PANAMA",
				"PG"  =>  "PAPUA NEW GUINEA",
				"PY"  =>  "PARAGUAY",
				"PE"  =>  "PERU",
				"PH"  =>  "PHILIPPINES",
				"PN"  =>  "PITCAIRN",
				"PL"  =>  "POLAND",
				"PT"  =>  "PORTUGAL",
				"PR"  =>  "PUERTO RICO",
				"QA"  =>  "QATAR",
				"RE"  =>  "REUNION",
				"RO"  =>  "ROMANIA",
				"RU"  =>  "RUSSIAN FEDERATION",
				"RW"  =>  "RWANDA",
				"SH"  =>  "SAINT HELENA",
				"KN"  =>  "SAINT KITTS AND NEVIS",
				"LC"  =>  "SAINT LUCIA",
				"PM"  =>  "SAINT PIERRE AND MIQUELON",
				"VC"  =>  "SAINT VINCENT AND THE GRENADINES",
				"WS"  =>  "SAMOA",
				"SM"  =>  "SAN MARINO",
				"ST"  =>  "SAO TOME AND PRINCIPE",
				"SA"  =>  "SAUDI ARABIA",
				"SN"  =>  "SENEGAL",
				"CS"  =>  "SERBIA AND MONTENEGRO",
				"SC"  =>  "SEYCHELLES",
				"SL"  =>  "SIERRA LEONE",
				"SG"  =>  "SINGAPORE",
				"SK"  =>  "SLOVAKIA",
				"SI"  =>  "SLOVENIA",
				"SB"  =>  "SOLOMON ISLANDS",
				"SO"  =>  "SOMALIA",
				"ZA"  =>  "SOUTH AFRICA",
				"GS"  =>  "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS",
				"ES"  =>  "SPAIN",
				"LK"  =>  "SRI LANKA",
				"SD"  =>  "SUDAN",
				"SR"  =>  "SURINAME",
				"SJ"  =>  "SVALBARD AND JAN MAYEN",
				"SZ"  =>  "SWAZILAND",
				"SE"  =>  "SWEDEN",
				"CH"  =>  "SWITZERLAND",
				"SY"  =>  "SYRIAN ARAB REPUBLIC",
				"TW"  =>  "TAIWAN, PROVINCE OF CHINA",
				"TJ"  =>  "TAJIKISTAN",
				"TZ"  =>  "TANZANIA, UNITED REPUBLIC OF",
				"TH"  =>  "THAILAND",
				"TL"  =>  "TIMOR-LESTE",
				"TG"  =>  "TOGO",
				"TK"  =>  "TOKELAU",
				"TO"  =>  "TONGA",
				"TT"  =>  "TRINIDAD AND TOBAGO",
				"TN"  =>  "TUNISIA",
				"TR"  =>  "TURKEY",
				"TM"  =>  "TURKMENISTAN",
				"TC"  =>  "TURKS AND CAICOS ISLANDS",
				"TV"  =>  "TUVALU",
				"UG"  =>  "UGANDA",
				"UA"  =>  "UKRAINE",
				"AE"  =>  "UNITED ARAB EMIRATES",
				"GB"  =>  "UNITED KINGDOM",
				"US"  =>  "UNITED STATES",
				"UM"  =>  "UNITED STATES MINOR OUTLYING ISLANDS",
				"UY"  =>  "URUGUAY",
				"UZ"  =>  "UZBEKISTAN",
				"VU"  =>  "VANUATU",
				"VE"  =>  "VENEZUELA",
				"VN"  =>  "VIET NAM",
				"VG"  =>  "VIRGIN ISLANDS, BRITISH",
				"VI"  =>  "VIRGIN ISLANDS, U.S.",
				"WF"  =>  "WALLIS AND FUTUNA",
				"EH"  =>  "WESTERN SAHARA",
				"YE"  =>  "YEMEN",
				"ZM"  =>  "ZAMBIA",
				"ZW"  =>  "ZIMBABWE"
			);
			$countries = apply_filters( 'mycred_list_option_countries', $countries );
			
			foreach ( $countries as $code => $cname ) {
				echo '<option value="' . $code . '"';
				if ( $selected == $code ) echo ' selected="selected"';
				echo '>' . $cname . '</option>';
			}
		}

		/**
		 * US States Dropdown Options
		 * @since 0.1
		 * @version 1.0
		 */
		function list_option_us_states( $selected = '', $non_us = false ) {
			$states = array (
				"AL"  =>  "Alabama",
				"AK"  =>  "Alaska",
				"AZ"  =>  "Arizona",
				"AR"  =>  "Arkansas",
				"CA"  =>  "California",
				"CO"  =>  "Colorado",
				"CT"  =>  "Connecticut",
				"DC"  =>  "D.C.",
				"DE"  =>  "Delaware",
				"FL"  =>  "Florida",
				"GA"  =>  "Georgia",
				"HI"  =>  "Hawaii",
				"ID"  =>  "Idaho",
				"IL"  =>  "Illinois",
				"IN"  =>  "Indiana",
				"IA"  =>  "Iowa",
				"KS"  =>  "Kansas",
				"KY"  =>  "Kentucky",
				"LA"  =>  "Louisiana",
				"ME"  =>  "Maine",
				"MD"  =>  "Maryland",
				"MA"  =>  "Massachusetts",
				"MI"  =>  "Michigan",
				"MN"  =>  "Minnesota",
				"MS"  =>  "Mississippi",
				"MO"  =>  "Missouri",
				"MT"  =>  "Montana",
				"NE"  =>  "Nebraska",
				"NV"  =>  "Nevada",
				"NH"  =>  "New Hampshire",
				"NJ"  =>  "New Jersey",
				"NM"  =>  "New Mexico",
				"NY"  =>  "New York",
				"NC"  =>  "North Carolina",
				"ND"  =>  "North Dakota",
				"OH"  =>  "Ohio",
				"OK"  =>  "Oklahoma",
				"OR"  =>  "Oregon",
				"PA"  =>  "Pennsylvania",
				"RI"  =>  "Rhode Island",
				"SC"  =>  "South Carolina",
				"SD"  =>  "South Dakota",
				"TN"  =>  "Tennessee",
				"TX"  =>  "Texas",
				"UT"  =>  "Utah",
				"VT"  =>  "Vermont",
				"VA"  =>  "Virginia",
				"WA"  =>  "Washington",
				"WV"  =>  "West Virginia",
				"WI"  =>  "Wisconsin",
				"WY"  =>  "Wyoming"
			);
			$states = apply_filters( 'mycred_list_option_us', $states );

			$outside = __( 'Outside US', 'mycred' );
			if ( $non_us == 'top' ) echo '<option value="">' . $outside . '</option>';
			foreach ( $states as $code => $cname ) {
				echo '<option value="' . $code . '"';
				if ( $selected == $code ) echo ' selected="selected"';
				echo '>' . $cname . '</option>';
			}
			if ( $non_us == 'bottom' ) echo '<option value="">' . $outside . '</option>';
		}

		/**
		 * Months Dropdown Options
		 * @since 0.1
		 * @version 1.0
		 */
		function list_option_months( $selected = '' ) {
			$months = array (
				"01"  =>  __( 'January', 'mycred' ),
				"02"  =>  __( 'February', 'mycred' ),
				"03"  =>  __( 'March', 'mycred' ),
				"04"  =>  __( 'April', 'mycred' ),
				"05"  =>  __( 'May', 'mycred' ),
				"06"  =>  __( 'June', 'mycred' ),
				"07"  =>  __( 'July', 'mycred' ),
				"08"  =>  __( 'August', 'mycred' ),
				"09"  =>  __( 'September', 'mycred' ),
				"10"  =>  __( 'October', 'mycred' ),
				"11"  =>  __( 'November', 'mycred' ),
				"12"  =>  __( 'December', 'mycred' )
			);

			foreach ( $months as $number => $text ) {
				echo '<option value="' . $number . '"';
				if ( $selected == $number ) echo ' selected="selected"';
				echo '>' . $text . '</option>';
			}
		}

		/**
		 * Years Dropdown Options
		 * @since 0.1
		 * @version 1.0
		 */
		function list_option_card_years( $selected = '', $number = 16 ) {
			$yy = date_i18n( 'y' );
			$yyyy = date_i18n( 'Y' );
			$count = 0;
			$options = array();

			while ( $count <= (int) $number ) {
				$count ++;
				if ( $count > 1 ) {
					$yy++;
					$yyyy++;
				}
				$options[ $yy ] = $yyyy;
			}

			foreach ( $options as $key => $value ) {
				echo '<option value="' . $key . '"';
				if ( $selected == $key ) echo ' selected="selected"';
				echo '>' . $value . '</option>';
			}
		}

		/**
		 * IPN - Has Required Fields
		 * @since 1.4
		 * @version 1.0
		 */
		function IPN_has_required_fields( $required_fields = array(), $method = 'REQUEST' ) {
			$missing = 0;
			foreach ( $required_fields as $field_key ) {
				if ( $method == 'POST' ) {
					if ( ! isset( $_POST[ $field_key ] ) )
						$missing ++;
				}
				elseif ( $method == 'GET' ) {
					if ( ! isset( $_GET[ $field_key ] ) )
						$missing ++;
				}
				elseif ( $method == 'REQUEST' ) {
					if ( ! isset( $_REQUEST[ $field_key ] ) )
						$missing ++;
				}
				else {
					if ( ! isset( $method[ $field_key ] ) )
						$missing ++;
				}
			}
			
			if ( $missing > 0 )
				$result = false;
			else
				$result = true;
			
			$result = apply_filters( 'mycred_buycred_IPN_missing', $result, $required_fields, $this->id );
			
			return $result;
		}

		/**
		 * IPN - Is Valid Call
		 * @since 1.4
		 * @version 1.0
		 */
		function IPN_is_valid_call() {
			return false;
		}

		/**
		 * IPN - Is Valid Sale
		 * @since 1.4
		 * @version 1.1
		 */
		function IPN_is_valid_sale( $sales_data_key = '', $cost_key = '', $transactionid_key = '', $method = '' ) {

			if ( $method == 'POST' )
				$post_id = $_POST[ $sales_data_key ];
			elseif ( $method == 'GET' )
				$post_id = $_GET[ $sales_data_key ];
			else
				$post_id = $_REQUEST[ $sales_data_key ];

			$pending_payment = $this->get_pending_payment( $post_id );
			if ( $pending_payment === false ) return false;

			$result = true;
			
			if ( $method == 'POST' )
				$price = $_POST[ $cost_key ];
			elseif ( $method == 'GET' )
				$price = $_GET[ $cost_key ];
			else
				$price = $_REQUEST[ $cost_key ];
				
			if ( $result === true && $pending_payment['cost'] != $price ) {
				$result = false;
			}

			if ( $result === true && isset( $this->prefs['currency'] ) && $this->prefs['currency'] != $pending_payment['currency'] ) {
				$result = false;
			}

			if ( $method == 'POST' )
				$transaction_id = $_POST[ $transactionid_key ];
			elseif ( $method == 'GET' )
				$transaction_id = $_GET[ $transactionid_key ];
			else
				$transaction_id = $_REQUEST[ $transactionid_key ];

			if ( $result === true && ! $this->transaction_id_is_unique( $transaction_id ) ) {
				$result = false;
			}
			
			$result = apply_filters( 'mycred_buycred_valid_sale', $result, $sales_data_key, $cost_key, $transactionid_key, $method, $this );
			
			if ( $result === true )
				return $decoded_data;
		
			return $result;
		}

		/**
		 * Complete Payment
		 * @since 1.4
		 * @version 1.4
		 */
		function complete_payment( $pending_payment = array(), $transaction_id = '' ) {
			$reference = 'buy_creds_with_' . str_replace( array( ' ', '-' ), '_', $this->id );
			$sales_data = array(
				$pending_payment['to'],
				$pending_payment['from'],
				$pending_payment['amount'],
				$pending_payment['cost'],
				$pending_payment['currency'],
				$pending_payment['ctype']
			);

			$point_type = $pending_payment['ctype'];
			$mycred = mycred( $point_type );
			$data = array( 'ref_type' => 'user', 'txt_id' => $transaction_id, 'sales_data' => implode( '|', $sales_data ) );

			$reply = false;

			if ( ! $mycred->has_entry( $reference, $pending_payment['from'], $pending_payment['to'], $data, $pending_payment['ctype'] ) ) {
				add_filter( 'mycred_get_email_events', array( $this, 'email_notice' ), 10, 3 );
				$reply = $mycred->add_creds(
					$reference,
					$pending_payment['to'],
					$pending_payment['amount'],
					$this->get_log_entry( $pending_payment['to'], $pending_payment['from'] ),
					$pending_payment['from'],
					$data,
					$pending_payment['ctype']
				);
				remove_filter( 'mycred_get_email_events', array( $this, 'email_notice' ), 10, 2 );
			}

			return apply_filters( 'mycred_buycred_complete_payment', $reply, $transaction_id, $this );
		}

		/**
		 * Email Notice Add-on Support
		 * @since 1.5.4
		 * @version 1.0
		 */
		function email_notice( $events, $request ) {

			if ( substr( $request['ref'], 0, 15 ) == 'buy_creds_with_' )
				$events[] = 'buy_creds|positive';

			return $events;

		}

		/**
		 * Trash Pending Payment
		 * @since 1.5.3
		 * @version 1.0
		 */
		function trash_pending_payment( $payment_id ) {

			if ( is_numeric( $payment_id ) )
				$post = get_post( $payment_id );
			else
				$post = get_page_by_title( $payment_id, OBJECT, 'buycred_payment' );

			if ( isset( $post->ID ) )
				wp_trash_post( $post->ID );

		}
	}
}
?>