<?php 

    get_header();
    $product = wc_get_product( get_the_ID() );
    $stock_qty = $product->get_stock_quantity();
    $post_thumbnail_id = $product->get_image_id();
    $attachment_ids = $product->get_gallery_image_ids();

    $image_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', TRUE );

    $discogs_data = get_post_meta( get_the_ID(), 'discogs_data_discogs_data', true );
    $record_meta = '';
    if( $discogs_data ) {

        $record_meta = json_decode( $discogs_data, true );

    }

?>

<main>

<div class="container">

    <div class="product-images-and-facts">

        <div class="product-images <?= !empty($attachment_ids) ? 'img-slider' : 'single-img' ?>">

            <div class="product-image-slider">
                <div class="slides-wrapper">

                    <div class="slide"> 
                        <?= woocommerce_get_product_thumbnail('woocommerce_full_size'); ?>
                    </div>

                    <?php foreach( $attachment_ids as $attachment_id ) : ?>

                        <div class="slide"> 
                            <?= wp_get_attachment_image( $attachment_id, 'full' ); ?>
                        </div>
        
                    <?php endforeach; ?> 

                </div>
            </div>

            <div class="thumb-slider-section thumb-count-<?= 1+count($attachment_ids) ?>" data-thumb-count="<?= 1+count($attachment_ids) ?>">
                <div class="thumb-slider-wrapper">
                    <button class="thumb active"> 
                        <?= woocommerce_get_product_thumbnail('woocommerce_full_size'); ?>
                    </button>
                    <?php foreach( $attachment_ids as $attachment_id ) : ?>

                        <button class="thumb"> 
                            <?= wp_get_attachment_image( $attachment_id, 'full' ); ?>
                        </button>
                    <?php endforeach; ?> 
                </div>
            </div>

        </div>

        <div class="key-facts-container">

            <div class="product-key-facts-content">
                    <?php $short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt ); ?>

                    <div class="product-title-meta">
                        <div class="band-name"><?= get_post_meta( $post->ID, 'band_name', true ) ?></div>
                        <h1 class="record-title"><?= get_post_meta( $post->ID, 'record_title', true ) ?></h1>
                    </div>

                    <div class="basket">

                        <p class="price"><?php echo $product->get_price_html(); ?></p>

                        <?php if ( $product->is_purchasable() ) : ?>

                            <!-- Quantity Selector -->
                            <?php if( $stock_qty > 1 ) : ?>
                                
                                <div class="custom-quantity-wrapper">
                                    <button type="button" class="qty-button qty-minus">−</button>
                                    <span class="qty-input" data-current-quantity="1" data-min="<?= $product->get_min_purchase_quantity() ?>" data-max="<?= $product->get_max_purchase_quantity() ?>" >1</span>
                                    <button type="button" class="qty-button qty-plus">+</button>
                                </div>

                            <?php endif; ?>

                            <div class="error-notice-wrapper">
                                <div class="product-error-notices"></div>
                            </div>

                            <button class="add-to-basket-btn cta-btn" data-product_id="<?= esc_attr( $product->get_id() ); ?>"
                                data-product_sku="<?= esc_attr( $product->get_sku() ); ?>" data-quantity="<?= $stock_qty ?>">
                                <span class="filter-loading-overlay rounded-border" style="--spinner-colour: #046db5;">
                                    <span class="spinner-loader"></span>
                                </span>
                                <span>Add to basket</span>
                            </button>

                        <?php endif; ?>

                    </div>

                    <?php if( $record_meta ) : ?>
                        <div class="record-data" style="display: grid;gap: 1em;">

                            <?php 

                                $label_name = $record_meta['labels'][0]['name'] ?? '';
                                $catno = $record_meta['labels'][0]['catno'] ?? '';
                                $country = $record_meta['country'] ?? '';
                                $release_date = $record_meta['release_date'] ?? '';

                            ?>
                            <?php if( $label_name ) : ?>
                                <div>
                                    <strong>Label:</strong> 
                                    <span><?= $label_name . ' - ' . $catno ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if( $country ) : ?>
                                <div>
                                    <strong>Country:</strong> 
                                    <span><?= $country ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if( $release_date ) : ?>
                                <div>
                                    <strong>Release Date:</strong> 
                                    <span><?= $release_date ?></span>
                                </div>
                            <?php endif; ?>
                            
                        
                        </div>
                    <?php endif; ?>

            </div>

            <!-- ADD IF CHECK HERE TO CONDITIONALLY SHOW THIS SECTION -->

            <div class="condition-info">
                <div class="condition-icon">
                    <?= file_get_contents( get_template_directory_uri() . '/images/svg/condition.svg' ) ?>
                    <span>Condition</span>
                </div>
                    <?php for( $i = 1; $i < 5; $i++ ) : ?>

                    <?php if( get_post_meta( $post->ID, 'product_condition_item_'.$i.'_label', true ) ) : ?>

                        <?php if( get_post_meta( $post->ID, 'product_condition_item_'.$i.'_description', true) ) : ?>
                            <div>
                                <strong><?= get_post_meta( $post->ID, 'product_condition_item_'.$i.'_label', true ) ?>:</strong> 
                                <span><?= get_post_meta( $post->ID, 'product_condition_item_'.$i.'_description', true) ?></span>
                            </div>
                        <?php endif; ?>

                    <?php endif; ?>

                <?php endfor; ?>

            </div>

        </div>
        
    </div>

    <div class="overview">

        <h2 class="fs-large mb-0-50">Overview</h2>

        <div class="overview-content">

            <?= apply_filters( 'the_content', $product->get_description() ); ?>
    
            <div class="accordions">
                        
                <div id="tabbed-0" class="accordion <?= empty( $product->get_description() ) ? 'active' : '' ?>">

                    <button id="accordion-0" class="py-4 px-3 accordion-btn <?= empty( $product->get_description() ) ? 'active' : '' ?>" 
                            aria-controls="accordion-section-0" aria-expanded="false" title="Click to view Tracklist" data-accordion="accordion-0">
                            <span>Tracklist</span>
                            <?= file_get_contents( get_template_directory_uri() . '/images/svg/plus.svg' ) ?>							
                    </button>

                    <div role="region" class="accordion-content dropdown-categories px-3 mt-0 <?= empty( $product->get_description() ) ? 'active' : '' ?>" 
                         id="accordion-section-0" data-accordion="accordion-0" aria-labelledby="accordion-0">
                        <div class="accordion-content-inner p-0 gap-0 d-block">
                            <div class="wysiwyg wysiwyg-cms-text">
                                <?php 
                                if (!empty($record_meta['tracklist']) && is_array($record_meta['tracklist'])) {
                                    echo '<ul class="padding-0 margin-0">';
                                    $i = 1;
                                    foreach( $record_meta['tracklist'] as $track ) {

                                        $position = $track['position'] ?? '';
                                        $title = $track['title'] ?? '';
                                        $duration = $track['duration'] ?? '';

                                        if ($position && $title) {
                                            $trackEven = ($i % 2 === 0) ? ' class="track-even"' : '';
                                            echo '<li' . $trackEven . '>';
                                            echo '<span class="track-position">'. esc_html($position) . '</span> : ' . esc_html($title);
                                            echo !empty( $duration ) ? ' (' . esc_html($duration) . ')' : '';
                                            echo '</li>';
                                            $i++;
                                        }

                                    }
                                    echo '</ul>';
                                } 
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                    
                <div id="tabbed-1" class="accordion">

                    <button id="accordion-1" class="py-4 px-3 accordion-btn " aria-controls="accordion-section-1" aria-expanded="false" title="Click to view Delivery" data-accordion="accordion-1">
                            <span>Delivery</span>
                            <?= file_get_contents( get_template_directory_uri() . '/images/svg/plus.svg' ) ?>			
                    </button>

                    <div role="region" class="accordion-content dropdown-categories px-3 mt-0 " id="accordion-section-1" data-accordion="accordion-1" aria-labelledby="accordion-1">
                        <div class="accordion-content-inner p-0 gap-0 d-block">
                            <div class="wysiwyg wysiwyg-cms-text">
                                <p>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="tabbed-2" class="accordion">

                    <button id="accordion-2" class="py-4 px-3 accordion-btn " aria-controls="accordion-section-2" aria-expanded="false" title="Click to view Payment" data-accordion="accordion-2">
                            <span>Payment</span>
                            <?= file_get_contents( get_template_directory_uri() . '/images/svg/plus.svg' ) ?>			
                    </button>

                    <div role="region" class="accordion-content dropdown-categories px-3 mt-0 " id="accordion-section-2" data-accordion="accordion-2" aria-labelledby="accordion-2">
                        <div class="accordion-content-inner p-0 gap-0 d-block">
                            <div class="wysiwyg wysiwyg-cms-text">
                                <p>
                                </p>
                            </div>
                        </div>
                    </div>

                </div> 
                
            </div>

        </div>

    </div>

</main>

<?php get_footer(); ?>