<?php get_header(); ?>

<div class="hero-section">

    <div class="hero-cta">
        <div class="hero-box">
            <h1>Preloved Vinyl, Tapes & CDs</h1>

            <p>
                From Pop to Punk - expand your collection with some of the best rarities and must-haves from a trader with over 40 years experience collecting and selling.
            </p>

            <div class="browse-btn ">
                <a class="cta-btn" href="<?= home_url() . '/shop' ?>">Browse Records</a>
            </div>
        </div>
    </div>

   <img class="hero-img" src="<?php echo get_template_directory_uri() . '/images/home-hero-img.png' ?>" alt="">

</div>

<main>

    <div class="content-grid latest-records-content">

        <h2 class="latest fs-xl">Latest Records</h2>

        <div class="latest-records" id="latest-records">

            <div class="records-grid">

                <?php get_template_part( 'template-parts/recent', 'records' ); ?>
                
            </div>
        </div>

        <div class="progress-arrows">
            
           <div class="position-relative">
                <div class="progress-bar" style="width: 8%"></div>
                <div class="full-progress-bar"></div>
            </div> 

            <div class="d-flex arrows">
                <button id="prev-btn">
                    <span class="d-grid">
                       <?= file_get_contents( get_template_directory_uri() . '/images/svg/arrow-left.svg' ) ?>
                    </span>
                </button>
                <button id="next-btn">
                    <span class="d-grid">
                        <?= file_get_contents( get_template_directory_uri() . '/images/svg/arrow-right.svg' ) ?>
                    </span>
                </button>
            </div>

        </div>

    </div>

    <div class="delivery-banner">Information on delivery, payments etc......</div>

    <div class="content-grid">

        <h2 class="genres-heading fs-xl">Popular Genres</h2>

        <div class="featured-genres">
                   
            <div class="main-featured-genre">
                <?php 

                    $args = array(
                        'taxonomy'   => "product_cat",
                        'hide_empty' => 0,
                        'meta_key'=>'main_featured_genre',
                        'orderby' => 'meta_value_num'
                    );
                
                    $feat_genre = get_terms( 'product_cat', $args );

                    foreach( $feat_genre as $genre ) : 
                    
                        $is_main_featured_genre = get_term_meta( $genre->term_id, 'main_featured_genre', true );
                        $cat_thumb_id = get_term_meta( $genre->term_id, 'thumbnail_id', true );
                        $genre_img = wp_get_attachment_image_src( $cat_thumb_id, 'full' );
                        $genre_name = $genre->name;
                        $genre_url = site_url() . '/product-category/' . $genre->slug;                
                    
                    ?>
                    
                        <?php if( $is_main_featured_genre ) : ?>
                            <a href="<?= site_url() . '/shop?genre=' . $genre->slug; ?>">
                                <img src="<?= $genre_img[0] ?>">
                                <h3 class="fs-xl"><?= $genre_name ?></h3>
                            </a>
                        <?php endif; ?>

                    <?php endforeach; wp_reset_query(); ?>

            </div>

            <div class="sub-genres">

                <?php get_template_part( 'template-parts/popular', 'genres' ); ?> 

            </div>            

        </div>
        
    </div>

</main>

<?php get_footer(); ?>