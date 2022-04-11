<?php get_header(); ?>

<main>

    <div class="container">

        <?php 
            $image_sizes = wp_get_registered_image_subsizes();

            foreach ( $image_sizes as $key => $image_size ) {

               // var_dump( "{$key} ({$image_size['width']} x {$image_size['height']})");
                
            } 
        ?>

        <div class="blog-posts">

            <h1 class="blog-posts__title">Latest Posts</h1>
            <div class="blog-container">
                
                <?php if( have_posts() ) : ?>

                <?php while( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'template-parts/blog', 'layout' ); 
                    ?>

                <?php endwhile; ?>

                <?php else: ?>

                    <div class="no-posts">

                    <h1>No Posts Found</h1>

                    </div>

                <?php endif; ?>


                <?php  if( paginate_links() ) : ?> 

                    <div class="pagination">
                        <?php paginate_links(); ?>
                    </div>

                <?php endif; ?>

            </div>

        </div>
    
    </div>

</main>

<?php get_footer(); ?>