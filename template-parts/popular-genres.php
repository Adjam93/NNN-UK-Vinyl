<?php

$cat_args = array(
    'taxonomy'   => "product_cat",
    'orderby'    => 'name',
    'hide_empty' => 0,
);

$product_categories = get_terms( $cat_args );

if ( !empty( $product_categories ) ) : ?>      

   <?php foreach ( $product_categories as $cat ) :

        $is_main_featured_genre = get_term_meta( $cat->term_id, 'main_featured_genre', true );
        $is_featured_genre = get_term_meta( $cat->term_id, 'featured_genre', true );

        $cat_thumb_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
        $genre_img = wp_get_attachment_image_src( $cat_thumb_id, 'full' );

        //$genre_slug = $cat->slug;
        $genre_name = $cat->name;
        $genre_url = site_url() . '/shop?genre=' . $cat->slug;

    ?>

        <?php if( !$is_main_featured_genre && $is_featured_genre ) : ?>

            <a href="<?= $genre_url ?>">
                <img src="<?= $genre_img[0] ?>">
                <h3 class="fs-large"><?= $genre_name ?></h3>
            </a>

        <?php endif; ?>

    <?php endforeach; ?>

<?php endif; ?>