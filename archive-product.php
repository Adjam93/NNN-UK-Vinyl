<?php 

    get_header(); 

    $genres = array();
    $formats = array();
    $decades = array();

    $genre_args = array(
        'taxonomy'   => 'product_cat',
        'orderby'    => 'name',
        'hide_empty' => 0,
    );

    $product_categories = get_terms( $genre_args );

    foreach ( $product_categories as $cat ) {

        if ( $cat->term_id == 16 || $cat->term_id == 15 ) {
            continue; // skip 'uncategorized'
        }
        
        $genres[] = array(

            'name' =>  $cat->name, 
            'slug' =>  $cat->slug
        );
    
    }

    wp_reset_query(); 

    $format_args = array(
        'taxonomy'   => 'pa_format',
        'orderby'    => 'name',
        'hide_empty' => 0,
    );

    $product_formats = get_terms( $format_args );

    foreach ( $product_formats as $format ) {
        
        $formats[] = array(
            'name' =>  $format->name, 
            'slug' =>  $format->slug,
            'format_found' => false
        );
    
    }

    wp_reset_query(); 

    $decade_args = array(
        'taxonomy'   => 'pa_decade',
        'orderby'    => 'name',
        'hide_empty' => 0,
    );

    $product_decades = get_terms( $decade_args );

    foreach ( $product_decades as $decade ) {
        
        $decades[] = array(
            'name' =>  $decade->name, 
            'slug' =>  $decade->slug,
            'decade_found' => false
        );
    
    }

    wp_reset_query();

    $currentGenres = array();
    $currentFormats = array();
    $currentDecades = array();

    if ( isset( $_GET['genre'])  ) {

        $currentGenres = explode( ',', $_GET['genre']);

    }

    if ( isset( $_GET['attributes'] ) ) {

        $attributes = $_GET['attributes'];

        foreach ( $attributes as $key => $attribute ) {

            if( $key == 'format' ) {

                $currentFormats = explode( ',', $attribute );

            }
      
            if( $key == 'decade' ) {

                $currentDecades = explode( ',', $attribute );

            }
      
        }

    }

    $sort_value = '';
    $sort_label = '';
    if ( isset( $_GET['sort_by'] ) ) {

        $sort_by = $_GET['sort_by'];
    
        switch( $_GET['sort_by'] ) {
    
            case 'latest':
                $sort_label = 'latest';
                $sort_value = 'latest';
            break;
    
            case 'price-low-to-high':
                $sort_label = 'Price: Lowest';
                $sort_value = 'price-low-to-high';
            break;
    
            case 'price-high-to-low':
                $sort_label = 'Price: Highest';
                $sort_value = 'price-high-to-low';
            break;

            case 'band-asc':
                $sort_label = 'Band: A - Z';
                $sort_value = 'band-asc';
            break;

            case 'band-desc':
                $sort_label = 'Band: Z - A';
                $sort_value = 'band-desc';
            break;

            case 'title-asc':
                $sort_label = 'Title: A - Z';
                $sort_value = 'title-asc';
            break;

            case 'title-desc':
                $sort_label = 'Title: A - Z';
                $sort_value = 'title-desc';
            break;
        }
    
    }

?>

<main>

    <div class="mobile-filter-overlay">
        <div class="mobile-filter-menu">

            <div class="filter-menu-title">
                <span class="fs-large">Filter</span>
                <button class="close-filter-menu"><?= file_get_contents( get_template_directory_uri() . '/images/svg/close.svg' ) ?></button>
            </div>

            <div class="filter-menu-cats">

                <div class="filter-menu-cat filter-section" data-type="genre">
                    <button class="filter-menu-btn">Genre <?= file_get_contents(  get_template_directory_uri() . '/images/svg/arrow-down.svg' )?></button>
                    <div class="filter-menu-options">
                        <div>
                            <?php foreach ( $genres as $genre ) : ?>
                
                                <button class="mobile-product-filter-btn <?= in_array( $genre['slug'], $currentGenres ) ? 'active' : '' ?>" data-type="genre" data-option="<?= $genre['slug'] ?>">
                                    <span><?= ucwords( $genre['name'] ) ?></span>
                                </button>
                            
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="filter-menu-cat">
                    <button class="filter-menu-btn">Format <?= file_get_contents(  get_template_directory_uri() . '/images/svg/arrow-down.svg' )?></button>
                    <div class="filter-menu-options">
                        <div>
                            <?php foreach ( $formats as $format ) : ?>
                    
                                <button class="mobile-product-filter-btn <?= in_array( $format['slug'], $currentFormats ) ? 'active' : '' ?>" data-type="attributes[format]" data-option="<?= $format['slug'] ?>">
                                    <span><?= ucwords( $format['name'] ) ?></span>
                                </button>
                            
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="filter-menu-cat">
                    <button class="filter-menu-btn">Decades <?= file_get_contents(  get_template_directory_uri() . '/images/svg/arrow-down.svg' )?></button>
                    <div class="filter-menu-options">
                        <div>
                            <?php foreach ( $decades as $decade ) : ?>
                    
                                <button class="mobile-product-filter-btn <?= in_array( $decade['slug'], $currentDecades ) ? 'active' : '' ?>" data-type="attributes[decade]" data-option="<?= $decade['slug'] ?>">
                                    <span><?= ucwords( $decade['name'] ) ?></span>
                                </button>
                            
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="filter-menu-cat mobile-price">
                    <button class="filter-menu-btn">Price <?= file_get_contents(  get_template_directory_uri() . '/images/svg/arrow-down.svg' )?></button>
                    <div class="filter-menu-options">
                        <div>
                            <div class="price-box d-grid">
                                <label for="price-from-mobile">From</label>
                                <input type="text" name="price-from" id="price-from-mobile" class="price-input price-from" data-price-submit="mobile" placeholder="£0.00"
                                       value="<?= isset( $_GET['min-price'] ) ? $_GET['min-price'] : '' ?>" />
                            </div>
                            <div class="price-box d-grid mb-1">
                                <label for="price-to-mobile">To</label>
                                <input type="text" name="price-to" id="price-to-mobile" class="price-input price-to" data-price-submit="mobile" placeholder="£"
                                      value="<?= isset( $_GET['max-price'] ) ? $_GET['max-price'] : '' ?>" />
                            </div>
                            <button data-price-submit="mobile" class="check-price-btn check-price-btn-mobile bg-black colour-white">Submit</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="content-grid">

        <div class="product-genres filter-section" data-type="genre">

            <?php foreach ( $genres as $genre ) : ?>
            
                <button class="product-genre-btn product-filter-btn <?= in_array( $genre['slug'], $currentGenres ) ? 'active' : '' ?>" data-type="genre" data-option="<?= $genre['slug'] ?>">
                    <span class="genre-name"><?= ucwords( $genre['name'] ) ?></span><span class="genre-check"><span class="checked">&#10003;</span></span>
                </button>
            
            <?php endforeach; ?>

            <?php wp_reset_query(); ?>

        </div>

        <div class="filters-sort">

            <div class="filter-dropdowns">
            
                <div class="filter-dropdown mobile">
                    <button class="mobile-filter filter-type">Filter <?= file_get_contents(  get_template_directory_uri() . '/images/svg/filter.svg' )?></button>
                </div>

                <div class="filter-dropdown filter-section" data-type="attributes[format]">
                    <button class="filter-type">Format <?= file_get_contents(  get_template_directory_uri() . '/images/svg/arrow-down.svg' )?></button>
                    <div class="filter-options">
                        <div class="filter-options-wrapper">
                            <?php foreach ( $formats as $format ) : ?>
                
                                <button class="product-filter-btn <?= in_array( $format['slug'], $currentFormats ) ? 'active' : '' ?>" data-type="attributes[format]" data-option="<?= $format['slug'] ?>">
                                    <span class="genre-name"><?= ucwords( $format['name'] ) ?></span>
                                </button>
                        
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="filter-dropdown filter-section" data-type="attributes[decade]">
                    <button class="filter-type">Decade <?= file_get_contents( get_template_directory_uri() . '/images/svg/arrow-down.svg' )?></button>
                    <div class="filter-options">
                        <div class="filter-options-wrapper">
                            <?php foreach ( $decades as $decade ) : ?>
                        
                                <button class="product-filter-btn <?= in_array( $decade['slug'], $currentDecades ) ? 'active' : '' ?>" data-type="attributes[decade]" data-option="<?= $decade['slug'] ?>">
                                    <span><?= ucwords( $decade['name'] ) ?></span>
                                </button>
                            
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="filter-dropdown">
                    <button class="filter-type price-filter">Price <?= file_get_contents(  get_template_directory_uri() . '/images/svg/arrow-down.svg' )?></button>
                    <div class="filter-options">
                        <div class="price-filters">
                            <div class="price-box">
                                <label for="price-from-desktop">From</label>
                                <input type="text" name="price-from" id="price-from-desktop" class="price-input price-from" data-price-submit="desktop" placeholder="£0.00" 
                                 value="<?= isset( $_GET['min-price'] ) ? $_GET['min-price'] : '' ?>" />
                            </div>
                            <div class="price-box">
                                <label for="price-to-desktop">To</label>
                                <input type="text" name="price-to" id="price-to-desktop" class="price-input price-to" data-price-submit="desktop" placeholder="£" 
                                       value="<?= isset( $_GET['max-price'] ) ? $_GET['max-price'] : '' ?>" />
                            </div>
                            <button data-price-submit="desktop" class="check-price-btn check-price-btn-desktop">Submit</button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="sort-dropdown">
           
                <div class="filter-dropdown">
                    <button class="filter-type sort-btn" style="min-height: 50px">
                        <span class="sort-label">Sort By</span> 
                        <span class="sort-btn-label" data-sort-value="<?= $sort_value ? $sort_value : 'Latest' ?>">
                            <?= $sort_label ? $sort_label : 'Latest' ?>
                        </span>
                        <?= file_get_contents( get_template_directory_uri() . '/images/svg/arrow-down.svg' ) ?>
                    </button>
                    <div class="filter-options">
                        <div class="sort-options">
                            <button class="sort-option-btn" data-sort="latest" data-sort-label="Latest">Latest</button>
                            <button class="sort-option-btn" data-sort="price-low-to-high" data-sort-label="Price: Lowest">Price: Lowest</button>
                            <button class="sort-option-btn" data-sort="price-high-to-low" data-sort-label="Price: Highest">Price: Highest</button>
                            <button class="sort-option-btn" data-sort="band-asc" data-sort-label="Band: A - Z">Band: A - Z</button>
                            <button class="sort-option-btn" data-sort="band-desc" data-sort-label="Band: Z - A">Band: Z - A</button>
                            <button class="sort-option-btn" data-sort="title-asc" data-sort-label="Title: A - Z">Title: A - Z</button>
                            <button class="sort-option-btn" data-sort="title-desc" data-sort-label="Title: Z - A">Title: Z - A</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="selected-filters">
            <div class="selected-filters-wrapper">
               
            </div>
            <button class="clear-all-btn" title="Remove all filters" aria-label="remove all filters">Remove All</button>
        </div>

        <div class="results-sort">

            <div>
                <span class="num-of-results">Finding results...</span>               
            </div>

            <div class="grid-list-sort">
                <button id="grid-view" class="results-view-btn active"><?= file_get_contents(  get_template_directory_uri() . '/images/svg/grid.svg' )?></button>
                <button id="list-view" class="results-view-btn"><?= file_get_contents(  get_template_directory_uri() . '/images/svg/list.svg' )?></button>
            </div>

        </div>


        <div class="products-grid">
            <div class="skeleton-wrapper product-page">
                <div class="skeleton-loader d-grid product-page gap-2">
                    <div class="skeleton-col rounded-border-10">
                        <span class="skeleton skeleton-img rounded-border-top-10" style="--ratio: 1 / .75;"></span>
                        <div class="d-grid gap-050 padding-1">
                            <span class="skeleton" style="--height: 30px; --width: 100px"></span>
                            <span class="skeleton" style="--height: 30px; --width: 100%"></span>
                            <span class="skeleton" style="--height: 30px; --width: 75px"></span>
                        </div>
                    </div>
                    <div class="skeleton-col rounded-border-10">
                        <span class="skeleton skeleton-img rounded-border-top-10" style="--ratio: 1 / .75;"></span>
                        <div class="d-grid gap-050 padding-1">
                            <span class="skeleton" style="--height: 30px; --width: 100px"></span>
                            <span class="skeleton" style="--height: 30px; --width: 100%"></span>
                            <span class="skeleton" style="--height: 30px; --width: 75px"></span>
                        </div>
                    </div>
                    <div class="skeleton-col rounded-border-10">
                        <span class="skeleton skeleton-img rounded-border-top-10" style="--ratio: 1 / .75;"></span>
                        <div class="d-grid gap-050 padding-1">
                            <span class="skeleton" style="--height: 30px; --width: 100px"></span>
                            <span class="skeleton" style="--height: 30px; --width: 100%"></span>
                            <span class="skeleton" style="--height: 30px; --width: 75px"></span>
                        </div>
                    </div>
                    <div class="skeleton-col rounded-border-10">
                        <span class="skeleton skeleton-img rounded-border-top-10" style="--ratio: 1 / .75;"></span>
                        <div class="d-grid gap-050 padding-1">
                            <span class="skeleton" style="--height: 30px; --width: 100px"></span>
                            <span class="skeleton" style="--height: 30px; --width: 100%"></span>
                            <span class="skeleton" style="--height: 30px; --width: 75px"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="products-grid-container"></div>
        </div>

        <div>
            <ul class="product-pagination"></ul>
        </div>

    </div>

</main>

<?php get_footer(); ?>