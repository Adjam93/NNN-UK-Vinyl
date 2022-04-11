<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>

<div <?php wc_product_class( '', $product ); ?>>
	

	<div class="product-column">

		<div class="product-image">
			<a href="<?php echo get_the_permalink() ?>"> <?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?></a>
		</div>

		<!-- <div class="product-content"> -->

			<div class="product-title"> 
				<a href="<?php echo get_the_permalink() ?>"><?php do_action( 'woocommerce_shop_loop_item_title' ); ?></a>
			</div>

			<div itemprop="description" class="list-description">
            	<?php

				$post_excerpt = apply_filters( 'woocommerce_short_description', $product->get_short_description() );
				
				$allowed_html = array(

					'p' => array(),
					'em' => array(),
					'strong' => array(),
					'b' => array(),
				);

				//$post_excerpt = wp_strip_all_tags( $post_excerpt );
				$post_excerpt = wp_kses( $post_excerpt, $allowed_html );

				$excerpt_symbols_count_max = 400;
				$excerpt_symbols_count = strlen( $post_excerpt );

				$post_excerpt = mb_substr( $post_excerpt, 0, $excerpt_symbols_count_max );

				if ( $excerpt_symbols_count > $excerpt_symbols_count_max ) {
					$post_excerpt .= ' ...';
				}

				echo $post_excerpt;

				//echo substr( apply_filters( 'woocommerce_short_description', $product->get_short_description() ), 0,200 ); echo '...'; */
				
				
				?>
        	</div>

			<div class="product-price">
				<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
			</div>

		<!-- </div> -->

	</div>

</div>
