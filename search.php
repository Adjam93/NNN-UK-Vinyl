<?php get_header(); ?>

<main>

    <div class="container">

        <div class="search-results">

            
      
                <?php if( have_posts() ) : ?>

                <h1 class="search-page-title">Search Results for - <?php echo get_search_query() ?></h1>

                <div class="search-container">
                

                    <?php while( have_posts() ) : the_post(); ?>

        
                        <?php get_template_part( 'template-parts/records', 'search' ); ?>

                    <?php endwhile; ?>

                <?php else: ?>

                    <div class="no-search-results">

                        <h1>No results found for - <?php echo get_search_query() ?></h1>

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