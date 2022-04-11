<?php get_header(); ?>


<div class="hero-section">

    <div class="inner"></div>

    <div class="hero-cta">

        <h1>Records, Tapes and CDs</h1>

        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
            Ut enim ad minim veniam, quis nostrud exercitation ullamco.  
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </p>

        <div class="cta-btn"><a href="#latest-records">View Records - Test Update</a></div>

    </div>

    <div class="hero-img">
        <img src="<?php echo get_template_directory_uri() . '/images/hero.png' ?>" alt="">
    </div>

</div>

<main>

    <div class="container">

        <div class="latest-records" id="latest-records">

            <h2 class="latest">Latest Records</h2>

            <div class="records-grid">

            <?php get_template_part( 'template-parts/recent', 'records' )?>
                
            </div>
        </div>

    </div>

    <div class="delivery-banner">Information on delivery, payments etc......</div>

    <div class="container">

        <h2 class="genres-heading">Popular Genres</h2>

        <div class="popular-genres">
        <div class="loading"><img src="<?php echo get_template_directory_uri() . '/images/711.gif' ?>" /></div>

            <div class="sidebar">

                    <ul>    

                        <?php 
                        
                            $args = array(
                                'taxonomy'   => "product_cat",
                                'orderby'    => 'name',
                                'hide_empty' => 0,
                            );

                            $product_categories = get_terms( $args );
                            $first_cat = true;

                            foreach ( $product_categories as $cat ) : 

                                $category_thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                                $image_url = wp_get_attachment_url( $category_thumbnail_id );

                                if ( $cat->term_id == 16 || $cat->term_id == 15 ) {
                                    continue; // skip 'uncategorized'
                                }
                            ?>

                            <?php  if ( $first_cat ) : ?>

                                <li class="genre-list-item active"><img src="<?php echo $image_url ?>" /><a class="genre-filter-cat active" data-category="<?= $cat->slug ?>" href="<?= get_category_link( $cat->term_id ); ?>"><? echo ucwords( $cat->name ) ?></a></li>
                                <?php  $first_cat = false; ?>   

                            <?php else : ?>
                               
                                <li class="genre-list-item"><img src="<?php echo $image_url ?>" /><a class="genre-filter-cat" data-category="<?= $cat->slug ?>" href="<?= get_category_link( $cat->term_id ); ?>"><? echo ucwords( $cat->name ) ?></a></li>
                        

                            <?php endif; endforeach; ?>

                            <?php wp_reset_query();  // Restore global post data  ?> 

                    </ul>
                </div>

                <div class="featured-genre">
                   
                    <?php get_template_part( 'template-parts/popular', 'genres' )?>

                </div>               

        </div>
        
    </div>

</main>

<?php get_footer(); ?>