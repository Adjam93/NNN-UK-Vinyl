<?php 

    // Get 6 most recent product IDs in date descending order.
    $query = new WC_Product_Query( array(
        'limit' => 6,
        'orderby' => 'date',
        'order' => 'DESC',
        'return' => 'ids',
    ) );

    $products = $query->get_products();

    if ( ! empty( $products ) ) :

    foreach ( $products as $product ) : ?>

    <?php 

        $image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $product ), 'full' ); 
        $image_alt = get_post_meta( get_post_thumbnail_id( $product ), '_wp_attachment_image_alt', TRUE );
       // $product_link = $product->slug;

    ?>

    <div class="record">
        <a href="<?php echo get_permalink( $product ) ?>"> <img src="<?php echo $image_src[0]?>" alt="<?php echo $image_alt ?>"> </a>
        <h3><a href="<?php echo get_permalink( $product ) ?>"><?php echo get_the_title( $product ) ?></a></h3>
    </div>

<?php endforeach; endif; ?>