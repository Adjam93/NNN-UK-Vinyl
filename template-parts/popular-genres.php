<?php

$cat_args = array(

    'taxonomy'   => "product_cat",
    'orderby'    => 'name',
    'hide_empty' => 0,
);

$product_categories = get_terms( $cat_args );

$args = array(

    'limit'  => 6,
    'status' => 'publish',
    'category' => array ( sanitize_text_field( $product_categories[0]->slug ) ),

);

$products = wc_get_products( $args );
$category_info = get_term_by( 'slug', sanitize_text_field( $product_categories[0]->slug ), 'product_cat' );

if ( ! empty( $products ) ) : ?>

<p><?php echo $category_info->description ?></p> 
        
<div class="featured-genre-records"> 

   <?php foreach ( $products as $product ) : ?>

        <div class="featured-record">
            <a href="<?php echo site_url() . "/" . $product->slug ?>"><img src="<?php echo wp_get_attachment_image_src( $product->image_id, 'full' )[0] ?>" class="record-img"></a>
            <div class="record-desc">
                <h3><a href="<?php echo site_url() . "/" . $product->slug ?>"><?php echo $product->name ?></a></h3>
            </div>  
        </div>  

    <?php endforeach; ?>

</div>

<a class="view-all-btn" href="<?php echo site_url() . "/" . "product-category" . "/" . $category_info->slug ?>">View All</a>       

<?php endif; ?>