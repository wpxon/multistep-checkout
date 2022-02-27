<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// print notices.
wc_print_notices();

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'multistep-checkout' ) ) );
	return;
}
?>

<ol class="one-page-checkout" id="checkoutSteps"> 
	<?php if ( ! is_user_logged_in() ) { ?>
		<li id="opc-login" class="step ">
			<div class="step-title">
				<span class="number">#</span>
				<h3><?php esc_html_e( 'Login', 'multistep-checkout' ); ?></h3> 
			</div>
			<div id="checkout-step-login" class="a-item"  style="display: none;">
				<?php include MSC_PATH . '/woocommerce/checkout/form-login.php'; ?>
				<button type="button" class="button prev-btn" ><span><?php esc_html_e( 'Previous', 'multistep-checkout' ); ?></span></button>
				<button type="button" class="button next-btn" ><span><?php esc_html_e( 'Continue', 'multistep-checkout' ); ?></span></button>
			</div>
		</li>
		<?php
	}

	if ( wc_coupons_enabled() ) {
		?>
		<li id="opc-coupon" class="step">
			<div class="step-title">
				<span class="number">#</span>
				<h3><?php esc_html_e( 'Coupon', 'multistep-checkout' ); ?></h3> 
			</div>
			<div id="checkout-step-coupon" class="a-item"  style="display: none;">
				<?php include MSC_PATH . '/woocommerce/checkout/form-coupon.php'; ?>
				<button type="button" class="button prev-btn" ><span><?php esc_html_e( 'Previous', 'multistep-checkout' ); ?></span></button>
				<button type="button" class="button next-btn" ><span><?php esc_html_e( 'Continue', 'multistep-checkout' ); ?></span></button>
			</div>
		</li>
	<?php } ?>

	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
		<?php if ( $checkout->get_checkout_fields() ) : ?>
			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
			<li id="opc-billing" class="step">
				<div class="step-title">
					<span class="number">#</span>
					<h3><?php esc_html_e( 'Billing', 'multistep-checkout' ); ?></h3> 
				</div>
				<div id="checkout-step-billing" class="a-item" style="display: none;">
					<?php do_action( 'woocommerce_checkout_billing' ); ?>
					<button type="button" class="button prev-btn" ><span><?php esc_html_e( 'Previous', 'multistep-checkout' ); ?></span></button>
					<button type="button" class="button next-btn" ><span><?php esc_html_e( 'Continue', 'multistep-checkout' ); ?></span></button>
				</div>
			</li>
			<li id="opc-shipping" class="step ">
				<div class="step-title">
					<span class="number">#</span>
					<h3><?php esc_html_e( 'Shipping', 'multistep-checkout' ); ?></h3> 
				</div>
				<div id="checkout-step-shipping" class="a-item" style="display: none;">
					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
					<button type="button" class="button prev-btn" ><span><?php esc_html_e( 'Previous', 'multistep-checkout' ); ?></span></button>
					<button type="button" class="button next-btn" ><span><?php esc_html_e( 'Continue', 'multistep-checkout' ); ?></span></button>
				</div>
			</li>
			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
		<?php endif; ?>

		<li id="opc-order-info" class="step ">
			<div class="step-title"> 
				<span class="number">#</span>
				<h3><?php esc_html_e( 'Order Info', 'multistep-checkout' ); ?></h3> 
			</div>
			<div id="checkout-step-order-info" class="a-item" style="display: none;">
				<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?> 
				<div id="order_review" class="woocommerce-checkout-review-order">
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					<button type="button" class="button prev-btn" ><span><?php esc_html_e( 'Previous', 'multistep-checkout' ); ?></span></button>
					<button type="button" class="button next-btn" ><span><?php esc_html_e( 'Continue', 'multistep-checkout' ); ?></span></button>
				</div>
			</div>
		</li>
		<li id="opc-payment-info" class="step ">
			<div class="step-title"> <span class="number">#</span>
				<h3><?php esc_html_e( 'Payment Info', 'multistep-checkout' ); ?></h3> 
			</div>
			<div id="checkout-step-payment-info" class="a-item" style="display: none;">
				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
				<button type="button" class="button prev-btn" ><span><?php esc_html_e( 'Previous', 'multistep-checkout' ); ?></span></button> 
			</div>
		</li> 
	</form>

</ol>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
