<?php  

    $image_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', TRUE ); 

?>


<div class="search-row">

    <div class="search-img">

        <?php  if ( has_post_thumbnail() ) : ?>

            <a class="search-card__thumbnail" href="<?php echo the_permalink();?>">

                <figure class="post-thumbnail">
                    <?php the_post_thumbnail( 'post-thumbnail', ['class' => 'search-card__thumbnail-img'] ); ?>
                </figure>
            
            </a> 

        <?php endif; ?>

       

    </div>

    <div class="search-title">

    <a class="search-card__link" href="<?php echo the_permalink(); ?>">
            <h2 class="search-card__title"><?php the_title(); ?></h2>
        </a>


</div>



    <div class="search-content">

        <span class="search-post-cats"><?php echo get_the_term_list( get_the_ID(), "product_cat" , '', " ", ''); ?></span>

        <?php if( has_excerpt() ) : ?>

            <p class="search-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 30 ); ?></p>

            <?php else : ?>

            <p class="search-card__excerpt"><?php echo wp_trim_words( get_the_content(), 30 ); ?></p>

        <?php endif; ?>

     

    </div>

    <div class="search-read-more">
        <a class="search-card__read-more-btn" href="<?php echo the_permalink(); ?>">View Record</a> 
    </div>

</div>



