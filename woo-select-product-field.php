<?php
/**
 * Plugin Name:          Woo Select Product Field
 * Description:          A block to demonstrate extending the Product Editor
 * Version:              0.1.0
 * Requires at least:    6.2
 * WC requires at least: 7.8
 * Requires PHP:         7.4
 * Author:               The WordPress Contributors
 * License:              GPL-3.0+
 * License URI:          https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:          woo-select-product-field
 *
 * @package              extension
 */

use Automattic\WooCommerce\Admin\BlockTemplates\BlockTemplateInterface;
use Automattic\WooCommerce\Admin\Features\ProductBlockEditor\ProductTemplates\ProductFormTemplateInterface;
use Automattic\WooCommerce\Admin\Features\ProductBlockEditor\BlockRegistry;


/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function woo_select_product_field_woo_select_product_field_block_init() {
	if ( isset( $_GET['page'] ) && $_GET['page'] === 'wc-admin' ) {
		BlockRegistry::get_instance()->register_block_type_from_metadata( __DIR__ . '/build' );
	}
}
add_action( 'init', 'woo_select_product_field_woo_select_product_field_block_init' );

function woo_select_product_field_woo_select_product_field_add_block_to_product_editor( BlockTemplateInterface $template ) {
	if ( $template instanceof ProductFormTemplateInterface && 'simple-product' === $template->get_id() ) {
		$basic_details = $template->get_section_by_id( 'basic-details' );

		if ( $basic_details ) {
			$basic_details->add_block(
				[
					'id' 	     => 'extension-woo-select-product-field--colors',
					'order'	     => 40,
					'blockName'  => 'extension/woo-select-product-field',
					'attributes' => [
						'title'    => __( 'Color' ),
						'help'     => __( 'Select the color.' ),
						'message'  => 'Woo Select Product Field',
						'property' => 'meta_data.woo_color',
						'options'  => [
							[
								'label' => 'Red',
								'value' => 'red',
							],
							[
								'label' => 'Blue',
								'value' => 'blue',
							],
							[
								'label' => 'Yellow',
								'value' => 'yellow',
							],
						],
					]
				]
			);

			$basic_details->add_block(
				[
					'id' 	     => 'extension-woo-select-product-field--shapes',
					'order'	     => 40,
					'blockName'  => 'extension/woo-select-product-field',
					'attributes' => [
						'title'    => __( 'Shapes' ),
						'help'     => __( 'Select the shapes.' ),
						'message'  => 'Woo Select Product Field',
						'multiple' => true,
						'property' => 'meta_data.woo_shapes',
						'options'  => [
							[
								'label' => 'Circle',
								'value' => 'circle',
							],
							[
								'label' => 'Square',
								'value' => 'square',
							],
							[
								'label' => 'Triangle',
								'value' => 'triangle',
							],
						],
					]
				]
			);
		}
	}
}
add_filter( 'woocommerce_block_template_register', 'woo_select_product_field_woo_select_product_field_add_block_to_product_editor', 100 );
