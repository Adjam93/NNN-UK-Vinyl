<?php 

    get_header(); 

    $image_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', TRUE );
    $srcset = wp_get_attachment_image_srcset( get_post_thumbnail_id(), array( 'medium', 'large' ) );

?>

<main>

    <div class="container">

        <?php if(have_posts()) : ?>

            <?php while(have_posts()) : the_post(); ?>

                <section id="single">

                    <div class="single__header">
                        
                        <h1 class="single__title"><?php the_title(); ?></h1>

                        <div class="single__blog-meta">

                            <div class="single__blog-profile">
                                <img class="single__blog-profile-picture" src="<?php echo get_template_directory_uri() . '/profile.png'  ?>" alt="Author Profile Picture" height="64" width="64" />
                                <span class="single__blog-author"><?php the_author(); ?></span>
                            </div>
                          
                            <div class="single__blog-info"> 
                                    <span class="single__blog-date"><?php the_time('jS F, Y'); ?></span>
                                    <span class="single__blog-cats"><i class="fa fa-folder-open-o"></i><?php echo get_the_category_list( ', '); ?></span>
                            </div>
                                
                        </div>

                        <?php if ( has_post_thumbnail() ) : ?>
                            
                            <figure class="post-thumbnail">
                                <?php the_post_thumbnail( 'post-thumbnail', ['class' => 'single__image'] ); ?>
                                <?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
                                    <figcaption class="wp-caption-text"><?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></figcaption>
                                <?php endif; ?>
                            </figure>
                         
                        <?php endif; ?>

                    </div>

                    <div class="single__body">
                        <?php the_content(); ?>
                    </div>
                   

                </section>

            
            <?php endwhile; ?>

        <?php endif; ?>

    </div>

</main>

<?php get_footer(); ?>