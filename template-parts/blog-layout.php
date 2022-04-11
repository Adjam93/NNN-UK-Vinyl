<?php  

    $image_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', TRUE ); 
    //echo $args['arg2'];

?>

<div class="blog-card">

    <a class="blog-card__link" href="<?php echo the_permalink(); ?>">
            <!-- <img class="blog-profile-picture" src="<?php echo get_template_directory_uri() . '/profile.jpg'  ?>" alt="Author Profile Picture" height="64" width="64" /> -->
            <h2 class="blog-card__title"><?php the_title(); ?></h2>
        </a>

    <?php  if ( has_post_thumbnail() ) : ?>

        <a class="blog-card__thumbnail" href="<?php echo the_permalink();?>">

        <!-- REWATCH VIDEO ON SRCSET-->
            <!-- <picture class="">
                <source srcset="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ) ?>" media="(min-width: 1200px)">
                <source srcset="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'large' ) ?>" media="(min-width: 760px)">
                <img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'medium_large' ) ?>" alt="<?php echo $image_alt ?>" />
            </picture> -->

            <figure class="post-thumbnail">
                <?php the_post_thumbnail( 'post-thumbnail', ['class' => 'blog-card__thumbnail-img'] ); ?>
            </figure>
           
        </a> 

    <?php endif; ?>

 

    <div class="blog-card__meta">

        <div class="blog-card__profile-meta"> 
            <span class="blog-card__post-author"><?php the_author(); ?></span>
            <span class="blog-card__post-date"><?php the_time( 'jS F, Y' ); ?></span>
            <span class="blog-card__post-cats"><i class="fa fa-folder-open-o" style="margin-right: 5px"></i><?php echo get_the_category_list( ', ' ); ?></span>
        </div>

        <?php if( has_excerpt() ) : ?>

            <p class="blog-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 30 ); ?></p>

        <?php else : ?>
            
            <p class="blog-card__excerpt"><?php echo wp_trim_words( get_the_content(), 30 ); ?></p>

        <?php endif; ?>
            
        <a class="blog-card__read-more-btn" href="<?php echo the_permalink(); ?>">Read More</a> 
    </div>


</div>