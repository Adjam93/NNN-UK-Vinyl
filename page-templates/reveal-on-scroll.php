<?php
/*

Template Name: Reveal on Scroll

*/

get_header();

?>

<main>

  <?php

      $mainQuery = new WP_Query( 
        array(
          'post_type' => array( 'product' ),
          's' => sanitize_text_field( $data['term'] ),
          'posts_per_page' => -1,
        )
      );

      //var_dump($mainQuery);

      $query = new WC_Product_Query( array(
        'orderby' => 'date',
        'order' => 'DESC',
    
      ) );


    $products = $query->get_products();

    echo "<pre>";
    print_r($products[0]->image_id);
    echo "</pre>";

    echo "<ul>";
    if (!empty($products)) {
      foreach ($products as $product) {
  
        
          echo "<li> " . $product->name. "</li>";
      }
  }
  echo "</ul>";


    //var_dump($products);


    $args = array(

      'post_type' => 'product',
      'limit'  => -1,
      'staus' => 'publish',
      
  );
  
  $products = wc_get_products( $args );

  echo "<pre>";
    print_r($products);
  echo "</pre>";



    ?>






    <div class="page-container">
      <!-- 
        <picture class="image">
            <source srcset="<?php echo get_template_directory_uri() . '/images/dog-crop-large.jpg' ?>" media="(min-width: 1200px)">
            <source srcset="<?php echo get_template_directory_uri() . '/images/dog-crop-medium.jpg' ?>" media="(min-width: 760px)">
            <img src="<?php echo get_template_directory_uri() . '/images/dog-crop-small.jpg' ?>" alt="Puppy in the sand" />
        </picture> -->

        <div class="col fade-in">
            <h3>Lorem, ipsum.</h3>
            <p>
              Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vitae
              maiores fuga eos provident voluptas perferendis.
            </p>
          </div>

            <div class="block" style="height: 1000px"></div>
          
        <div class="col fade-in">
            <h3>Lorem, ipsum.</h3>
            <p>
              Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vitae
              maiores fuga eos provident voluptas perferendis.
            </p>
          </div>

          <div class="more-stuff-grid">
            <img
                src="https://unsplash.it/400"
                alt=""
                class="slide-in from-left"
            />
            <p class="slide-in from-right">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis fugit,
                quae beatae vero sit magni quaerat id ratione. Dolor optio unde amet
                omnis sapiente neque cumque consequuntur reiciendis deserunt.
                Dolorem vero exercitationem consequuntur, eligendi cupiditate
                debitis facilis quibusdam magni. Eveniet.
            </p>
        </div>


    </div>


</main>


<?php get_footer(); ?>