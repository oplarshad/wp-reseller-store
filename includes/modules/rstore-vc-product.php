<?php
/**
 * GoDaddy Reseller Store product module class.
 *
 * Handles the Reseller store product shortcode map for Visual Composer.
 *
 * @class    Reseller_Store/Modules/VCProduct
 * @package  WPBakeryShortCode
 * @category Class
 * @author   GoDaddy
 * @since    1.6.0
 */

namespace Reseller_Store\Modules;

if ( ! defined( 'ABSPATH' ) ) {

	// @codeCoverageIgnoreStart
	exit;
	// @codeCoverageIgnoreEnd
}

class VCProduct extends \WPBakeryShortCode {

	/**
	 * @method __construct
	 * @since 1.6.0
	 */
	function __construct() {
		add_action( 'init', array( $this, 'vc_mapping' ) );
	}

	/**
	 * Visual composer shortcode mapping implementation.
	 *
	 * @method vc_mapping
	 *
	 * @since 1.6.0`
	 */
	public function vc_mapping() {

		vc_map(
			array(
				'name'        => __( 'Product', 'reseller-store' ),
				'base'        => 'rstore_product',
				'description' => __( 'Display a product post.', 'reseller-store' ),
				'category'    => __( 'Reseller Store', 'reseller-store' ),
				'params'      => array(

					array(
						'type'       => 'dropdown',
						'holder'     => 'div',
						'class'      => 'text-class',
						'heading'    => __( 'Product', 'reseller-store' ),
						'param_name' => 'post_id',
						'value'      => $this->get_product_list(),
						'weight'     => 1,
						'group'      => __( 'General', 'reseller-store' ),
					),

					array(
						'type'       => 'dropdown',
						'holder'     => 'div',
						'class'      => 'text-class',
						'heading'    => __( 'Image Size', 'reseller-store' ),
						'param_name' => 'image_size',
						'value'      => array(
							__( 'Original resolution', 'reseller-store' ) => 'full',
							__( 'Thumbnail', 'reseller-store' ) => 'thumbnail',
							__( 'Medium resolution', 'reseller-store' ) => 'medium',
							__( 'Large resolution', 'reseller-store' ) => 'large',
							__( 'Hide image', 'reseller-store' ) => 'none',
						),
						'group'      => 'Display',
					),

					array(
						'type'        => 'textfield',
						'holder'      => 'div',
						'class'       => 'text-class',
						'heading'     => __( 'Button', 'reseller-store' ),
						'param_name'  => 'button_label',
						'value'       => __( 'Add to cart', 'reseller-store' ),
						'description' => __( 'Leave blank to hide button', 'reseller-store' ),
						'group'       => 'Display',
					),

					array(
						'type'       => 'checkbox',
						'holder'     => 'div',
						'class'      => 'text-class',
						'heading'    => __( 'Show product title', 'reseller-store' ),
						'param_name' => 'show_title',
						'value'      => [ __( 'Hide', 'reseller-store' ) => 0 ],
						'group'      => 'Display',
					),
					array(
						'type'       => 'checkbox',
						'holder'     => 'div',
						'class'      => 'text-class',
						'heading'    => __( 'Show post content', 'reseller-store' ),
						'param_name' => 'show_content',
						'value'      => [ __( 'Hide', 'reseller-store' ) => 0 ],
						'group'      => 'Display',
					),
					array(
						'type'       => 'checkbox',
						'holder'     => 'div',
						'class'      => 'text-class',
						'heading'    => __( 'Show product price', 'reseller-store' ),
						'param_name' => 'show_price',
						'value'      => [ __( 'Hide', 'reseller-store' ) => 0 ],
						'group'      => 'Display',
					),
					array(
						'type'       => 'checkbox',
						'holder'     => 'div',
						'class'      => 'text-class',
						'heading'    => __( 'Redirect to cart after adding item', 'reseller-store' ),
						'param_name' => 'redirect',
						'value'      => [ __( 'No', 'reseller-store' ) => 0 ],
						'group'      => 'Redirect',
					),
					array(
						'type'       => 'textfield',
						'holder'     => 'div',
						'class'      => 'text-class',
						'heading'    => __( 'Cart Link', 'reseller-store' ),
						'param_name' => 'text_cart',
						'value'      => __( 'Continue to cart', 'reseller-store' ),
						'group'      => 'Redirect',
					),
				),
			)
		);

	}

	/**
	 * Retrieve reseller products.
	 *
	 * @return array Products posts.
	 * @since 1.6.0
	 */
	private function get_product_list() {

		$query = new \WP_Query(
			[
				'post_type'   => \Reseller_Store\Post_Type::SLUG,
				'post_status' => 'publish',
				'nopaging'    => true, // get a list of every product.
			]
		);

		$default = __( 'Select product...', 'reseller-store' );

		$products = [
			$default => -1,
		];

		while ( $query->have_posts() ) {

			$query->the_post();

			$id = get_the_ID();

			$products[ esc_html( get_the_title() ) ] = strval( $id );

		}

		wp_reset_postdata();

		return $products;
	}
}

new VCProduct();
