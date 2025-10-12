class ShopFilters {

    constructor() {
        
        this.at992 = window.matchMedia( '( min-width: 992px )' );

        this.genre_btns = document.querySelectorAll( '.product-genre-btn' );
        this.filter_types = document.querySelectorAll( '.filter-type' );
        this.mobile_filter_btn = document.querySelector( '.mobile-filter' );
        this.mobile_filter_overlay = document.querySelector( '.mobile-filter-overlay' );
        this.close_mobile_filter_menu = document.querySelector( '.close-filter-menu' );

        this.products_grid = document.querySelector( '.products-grid' );
        this.products_grid_container = document.querySelector( '.products-grid-container' );
        this.skeletonWrapper = document.querySelector( '.skeleton-wrapper.product-page' );
        this.skeletonLoader = document.querySelector( '.skeleton-loader.product-page' );
        this.grid_view_btn = document.getElementById( 'grid-view' );
        this.list_view_btn = document.getElementById( 'list-view' );

        this.filter_menu_btns = document.querySelectorAll( '.filter-menu-btn' );
        this.product_filter_btns = document.querySelectorAll( '.product-filter-btn' );
        this.mobile_product_filter_btns = document.querySelectorAll( '.mobile-product-filter-btn' );

        this.selected_filters = document.querySelector( '.selected-filters' );
        this.selected_filters_wrapper = document.querySelector( '.selected-filters .selected-filters-wrapper' );
        this.selected_filter_btns = '';
        this.clear_all_btn = document.querySelector( '.clear-all-btn' );

        //Price inputs
        this.pricesFrom = document.querySelectorAll( '.price-from' );
        this.pricesTo = document.querySelectorAll( '.price-to' );
        this.isMinPrice = false;
        this.isMaxPrice = false;
        this.minPrice = '';
        this.maxPrice = '';
        this.checkPriceBtns = document.querySelectorAll( '.check-price-btn' );
        this.priceURL = false;

        this.pricesFrom.forEach( from => {

            if( from.value.length > 0 && !isNaN(from.value) ) {

                this.priceURL = true;

                if( from.dataset.priceSubmit == 'desktop' ) {

                    this.set_price_range( document.querySelector( '.check-price-btn-desktop' ), true );

                } else if( from.dataset.priceSubmit == 'mobile' ) {

                    this.set_price_range( document.querySelector( '.check-price-btn-mobile' ), true);

                }

            } 

        });

        this.pricesTo.forEach( to => {
        
            if( to.value.length > 0 && !isNaN(to.value) ) {

                this.priceURL = true;

                if( to.dataset.priceSubmit == 'desktop' ) {

                    this.set_price_range( document.querySelector( '.check-price-btn-desktop' ), true );

                } else if( to.dataset.priceSubmit == 'mobile' ) {

                    this.set_price_range( document.querySelector( '.check-price-btn-mobile' ), true );

                }

            } 

        });

        this.productPagination = document.querySelector( '.product-pagination' );
        this.currentPage = 1;

        this.numberOfResults = document.querySelector( '.num-of-results' );

        this.headerSearchLabel = document.querySelector( '.record-search-label' );
        this.headerSearchField = document.getElementById( 'records-search-input' );
        this.isSearching = false;
        if ( this.headerSearchField && this.headerSearchField.value !== '' ) {

            this.isSearching = true;
      
        }

        //URL params and query
        let url_filters = [];
        this.filters_array = [];
        this.filter_url_params = new URLSearchParams();
        this.queryString = '';

        if( this.at992.matches ) { 

            this.product_filter_btns.forEach( ( filter_btn, index ) => {

                let filter_btn_type = filter_btn.getAttribute( 'data-type' );
                let filter_btn_value = filter_btn.getAttribute( 'data-option' );

                if( filter_btn_type == 'genre' && this.at992.matches ) {

                    filter_btn.classList.add( 'no-select' );
                }

                //Filter buttons are set to 'active' from the $_GET request on the template
                if( filter_btn.classList.contains( 'active' ) ) {

                    this.filters_array.push( { 
                        'filter_type': filter_btn_type, 
                        'filter_settings': { 'value': filter_btn_value, 'selected': true }
                    } );

                    let group = url_filters.find( g => g.filter_btn_type === filter_btn_type );

                    if ( !group ) {
        
                        group = { filter_type: filter_btn_type, values: [] };
                        url_filters.push( group );
                    }
                    
                    group.values.push( filter_btn_value );

                    this.filters_count++;

                } else {

                    this.filters_array.push( { 
                        'filter_type': filter_btn_type, 
                        'filter_settings': { 'value': filter_btn_value, 'selected': false }
                        
                    } );

                }

                if( filter_btn.classList.contains( 'active' ) && !filter_btn.classList.contains( 'no-select' ) ) {
                
                    this.selected_filters.style.display = 'grid';
                    this.selected_filters_wrapper.insertAdjacentHTML( 'afterbegin', 
                        `<button class="selected-filter-btn" 
                                data-type="${filter_btn_type}" 
                                data-option="${filter_btn_value}" aria-label="Remove ${filter_btn.textContent} filter">
                        <span>${filter_btn.textContent}</span>
                        <span class="close-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="12 12 35 35">
                            <path data-name="Path 9036" d="M20.62,20.62,39.38,39.38" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5"/>
                            <path data-name="Path 9037" d="M39.38,20.62,25.31,34.69l-4.69,4.69" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5"/>
                            </svg>
                        </span>
                        </button>`
                    );
        
                    this.selected_filter_btns = document.querySelectorAll( '.selected-filter-btn' );
                    this.selected_filters_click( this.selected_filter_btns );

                }    

            })

        } else {

            this.mobile_product_filter_btns.forEach( ( filter_btn, index ) => {

                let filter_btn_type = filter_btn.getAttribute( 'data-type' );
                let filter_btn_value = filter_btn.getAttribute( 'data-option' );
                
                //Filter buttons are set to 'active' from the $_GET request on the template
                if( filter_btn.classList.contains( 'active' ) ) {

                    this.filters_array.push( { 
                        'filter_type': filter_btn_type, 
                        'filter_settings': { 'value': filter_btn_value, 'selected': true }
                    } );

                    let group = url_filters.find( g => g.filter_btn_type === filter_btn_type );

                    if ( !group ) {
        
                        group = { filter_type: filter_btn_type, values: [] };
                        url_filters.push( group );
                    }
                    
                    group.values.push( filter_btn_value );

                    this.filters_count++;

                } else {

                    this.filters_array.push( { 
                        'filter_type': filter_btn_type, 
                        'filter_settings': { 'value': filter_btn_value, 'selected': false }
                        
                    } );

                }

                if( filter_btn.classList.contains( 'active' ) && !filter_btn.classList.contains( 'no-select' ) ) {
                
                    this.selected_filters.style.display = 'grid';
                    this.selected_filters_wrapper.insertAdjacentHTML( 'afterbegin', 
                        `<button class="selected-filter-btn" 
                                data-type="${filter_btn_type}" 
                                data-option="${filter_btn_value}" aria-label="Remove ${filter_btn.textContent} filter">
                        <span>${filter_btn.textContent}</span>
                        <span class="close-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="12 12 35 35">
                            <path data-name="Path 9036" d="M20.62,20.62,39.38,39.38" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5"/>
                            <path data-name="Path 9037" d="M39.38,20.62,25.31,34.69l-4.69,4.69" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5"/>
                            </svg>
                        </span>
                        </button>`
                    );
        
                    this.selected_filter_btns = document.querySelectorAll( '.selected-filter-btn' );
                    this.selected_filters_click( this.selected_filter_btns );

                }    

            })

        }

        if( this.selected_filter_btns && this.selected_filter_btns.length > 1 ) {

            this.clear_all_btn.style.display = 'block';

        } else {

            this.clear_all_btn.style.display = 'none';

        }

        console.log(this.filters_array)
        console.log(url_filters)
        
        url_filters.forEach( url_filter => {

            this.filter_url_params.set( url_filter.filter_type, url_filter.values.join( ',' ) );
            console.log(this.filter_url_params.toString())

        });
        
        if( this.filter_url_params.size > 0 ) {

            this.isFiltered = true;
            this.queryString = this.filter_url_params.toString().replace(/%2C/g, ',').replace(/%5B/g, '[').replace(/%5D/g, ']');
            console.log(this.queryString)


        }

        this.sort_options = document.querySelectorAll( '.sort-options > button' );
        this.isSorting = true;
        this.sortLabel = document.querySelector( '.sort-btn-label' );
        this.sortBy = this.sortLabel.getAttribute( 'data-sort-value' );


        if ( document.querySelector( '.post-type-archive-product' ) ) {

            this.events();

        }

    }
  
    events() {

        this.getFilteredResults();

        this.selectFilterDropdown();
        this.openMobileFilterMenu();
        this.closeMobileFilterMenu();
        this.gridView();
        this.listView();

        this.select_filter();
        this.select_mobile_filter();
        this.clear_all_filters();

        this.sort_results();
        this.resize_events();

        this.check_price();

        document.addEventListener( 'click', (e) => {

            //Make array of following class names to check instead
            /**
             *  const classNames = ['name1', 'name2']
                if (classNames.some(className => el.classList.contains(className))) {}
             */
            if( e.target.classList.contains( 'filter-type' ) || e.target.classList.contains( 'filter-options-wrapper' ) 
                || e.target.classList.contains( 'price-filters' ) || e.target.classList.contains( 'price-box' ) 
                || e.target.classList.contains( 'price-input' )  || e.target.classList.contains( 'product-filter-btn' ) 
                || e.target.classList.contains( 'sort-options' )   || e.target.classList.contains( 'sort-option-btn' )
                || e.target.classList.contains('sort-label') || e.target.classList.contains('sort-btn-label') ) {

            } else {

                console.log(e.target)
                this.filter_types.forEach( filter => { filter.classList.remove( 'active' ); })

            }

        })
     
    }

    check_price() {

        this.checkPriceBtns.forEach( price_btn => {

            price_btn.addEventListener( 'click', () => {

               this.set_price_range( price_btn );

            })
        })

    }

    set_price_range( price_btn, no_filter ) {

        this.minPrice = 0;
        this.maxPrice = 0;
        
        this.pricesFrom.forEach( from => {
        
            if( price_btn.dataset.priceSubmit == from.dataset.priceSubmit ) {

                if( from.value.length > 0 && !isNaN(from.value) ) {

                    this.isMinPrice = true;
                    this.minPrice = from.value;

                } else {

                    this.isMinPrice = false;

                }

            }
        })

        this.pricesTo.forEach( to => {
        
            if( price_btn.dataset.priceSubmit == to.dataset.priceSubmit ) {

                console.log(to.value)
                if( to.value.length > 0 && !isNaN(to.value) ) {

                    this.isMaxPrice = true;
                    this.maxPrice = to.value;

                } else {

                    this.isMaxPrice = false;

                }

            }
        })

        if( document.querySelector( '.price-selected-btn' ) ) {
            document.querySelector( '.price-selected-btn' ).remove();
        }

        if( this.isMinPrice && !this.isMaxPrice ) {

            this.selected_filters.style.display = 'grid';
            this.selected_filters_wrapper.insertAdjacentHTML( 'beforeend', 
                `<button class="selected-filter-btn price-selected-btn min-price-selected-btn" 
                        data-type="" 
                        data-option="" aria-label="Remove min price of ${this.minPrice} filter">
                <span>From: £${this.minPrice}</span>
                <span class="close-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="12 12 35 35">
                    <path data-name="Path 9036" d="M20.62,20.62,39.38,39.38" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5"/>
                    <path data-name="Path 9037" d="M39.38,20.62,25.31,34.69l-4.69,4.69" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5"/>
                    </svg>
                </span>
                </button>`
            );

            this.selected_filter_btns = document.querySelectorAll( '.selected-filter-btn' );
            this.selected_filters_click( this.selected_filter_btns );

        } else if( this.isMaxPrice && !this.isMinPrice ) {

            this.selected_filters.style.display = 'grid';
            this.selected_filters_wrapper.insertAdjacentHTML( 'beforeend', 
                `<button class="selected-filter-btn price-selected-btn max-price-selected-btn" 
                        data-type="" 
                        data-option="" aria-label="Remove max price of ${this.maxPrice} filter">
                <span>To: £${this.maxPrice}</span>
                <span class="close-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="12 12 35 35">
                    <path data-name="Path 9036" d="M20.62,20.62,39.38,39.38" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5"/>
                    <path data-name="Path 9037" d="M39.38,20.62,25.31,34.69l-4.69,4.69" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5"/>
                    </svg>
                </span>
                </button>`
            );

            this.selected_filter_btns = document.querySelectorAll( '.selected-filter-btn' );
            this.selected_filters_click( this.selected_filter_btns );

        } else if( this.isMaxPrice && this.isMinPrice && this.maxPrice > this.minPrice ) {

            this.selected_filters.style.display = 'grid';
            this.selected_filters_wrapper.insertAdjacentHTML( 'beforeend', 
                `<button class="selected-filter-btn price-selected-btn min-max-price-selected-btn" 
                        data-type="" 
                        data-option="" aria-label="Remove min price of ${this.minPrice} filter">
                <span>From: £${this.minPrice} to £${this.maxPrice}</span>
                <span class="close-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="12 12 35 35">
                    <path data-name="Path 9036" d="M20.62,20.62,39.38,39.38" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5"/>
                    <path data-name="Path 9037" d="M39.38,20.62,25.31,34.69l-4.69,4.69" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5"/>
                    </svg>
                </span>
                </button>`
            );

            this.selected_filter_btns = document.querySelectorAll( '.selected-filter-btn' );
            this.selected_filters_click( this.selected_filter_btns );

        } 

        let remaining_filter_btns = document.querySelectorAll( '.selected-filter-btn' );
        if( remaining_filter_btns.length == 0 ) {

            this.selected_filters.style.display = 'none';
            
        }


        if( !no_filter ){

            this.getFilteredResults();

        }

    }

    resize_events() {

        window.addEventListener( 'resize', () => {

             this.product_filter_btns.forEach( ( filter_btn, index ) => {

                let filter_btn_type = filter_btn.getAttribute( 'data-type' );

                if( filter_btn_type == 'genre' && this.at992.matches ) {

                    filter_btn.classList.add( 'no-select' );

                }

            });
            
        });

    }

    selectFilterDropdown() {

        this.filter_types.forEach( filter => {

            filter.addEventListener( 'click', () => {

                if( ! filter.classList.contains( 'mobile-filter') ) {
                    filter.classList.toggle( 'active' );
                }
           

            })

        })

        this.filter_menu_btns.forEach( filter => {

            filter.addEventListener( 'click', () => {

                filter.parentNode.classList.toggle( 'active' );           

            })

        })
    }
    
    select_filter() {

        this.product_filter_btns.forEach( filter_btn => {

            filter_btn.addEventListener( 'click', () => {

                let filter_btn_type = filter_btn.getAttribute( 'data-type' );
                let filter_btn_value = filter_btn.getAttribute( 'data-option' );
                let selected_filters = [];
                filter_btn.classList.toggle( 'active' );

                this.mobile_product_filter_btns.forEach( btn => {

                    let mobile_btn_value = btn.getAttribute( 'data-option' );

                    if( mobile_btn_value == filter_btn_value ) {

                        btn.classList.toggle( 'active' );

                    }

                })

                this.filter_products( filter_btn, filter_btn_type, filter_btn_value, selected_filters )

            })

        })

    }

    select_mobile_filter() {

        this.mobile_product_filter_btns.forEach( filter_btn => {

            filter_btn.addEventListener( 'click', () => {

                let filter_btn_type = filter_btn.getAttribute( 'data-type' );
                let filter_btn_value = filter_btn.getAttribute( 'data-option' );
                let selected_filters = [];
                filter_btn.classList.toggle( 'active' );

                this.product_filter_btns.forEach( btn => {

                    let product_btn_value = btn.getAttribute( 'data-option' );

                    if( product_btn_value == filter_btn_value ) {

                        btn.classList.toggle( 'active' );

                    }

                })

                this.filter_products( filter_btn, filter_btn_type, filter_btn_value, selected_filters )

            })

        })

    }

    filter_products( filter_btn, filter_btn_type, filter_btn_value, selected_filters ) {

        this.filters_array.forEach( filter => {

            if( filter.filter_type == filter_btn_type  ) {

                if( filter.filter_settings.value == filter_btn_value && filter_btn.classList.contains( 'active' ) ) {

                    filter.filter_settings.selected = true;
                    this.filters_count++;

                } else if( filter.filter_settings.value == filter_btn_value && filter.filter_settings.selected == true ) {

                    filter.filter_settings.selected = false;
                    this.filters_count--;

                }

                if( filter.filter_settings.selected == true ) {

                    selected_filters.push( filter.filter_settings.value );
                    this.filter_url_params.set( filter.filter_type, selected_filters.join(',') );
                    
                } else if ( filter.filter_settings.selected == false && selected_filters.length == 0 ) {

                    this.filter_url_params.delete( filter.filter_type );

                }

            }

        })

        console.log(this.filters_array)
        this.skeletonWrapper.style.display = 'block';
        this.numberOfResults.innerHTML = 'Finding results...';
        this.products_grid_container.innerHTML = '';
        this.queryString = this.filter_url_params.toString().replace(/%2C/g, ',').replace(/%5B/g, '[').replace(/%5D/g, ']');
        this.currentPage = 1;
        this.getFilteredResults();
       
        if( filter_btn.classList.contains( 'active' ) && !filter_btn.classList.contains( 'no-select' ) ) {
            
            this.selected_filters.style.display = 'grid';
            this.selected_filters_wrapper.insertAdjacentHTML( 'beforeend', 
                `<button class="selected-filter-btn" 
                        data-type="${filter_btn_type}" 
                        data-option="${filter_btn_value}" aria-label="Remove ${filter_btn.textContent} filter">
                <span>${filter_btn.textContent}</span>
                <span class="close-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="12 12 35 35">
                    <path data-name="Path 9036" d="M20.62,20.62,39.38,39.38" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5"/>
                    <path data-name="Path 9037" d="M39.38,20.62,25.31,34.69l-4.69,4.69" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5"/>
                    </svg>
                </span>
                </button>`
            );

            this.selected_filter_btns = document.querySelectorAll( '.selected-filter-btn' );
            this.selected_filters_click( this.selected_filter_btns );

        } else {

            if( this.selected_filter_btns ) {

                this.selected_filter_btns.forEach( btn => {

                    if( btn.getAttribute('data-option') == filter_btn_value ) {
                        btn.remove();
                    }

                })

            }
        
        }

        if( this.selected_filter_btns && this.selected_filter_btns.length > 1 ) {

            this.clear_all_btn.style.display = 'block';

        } else {

            this.clear_all_btn.style.display = 'none';

        }

    }

    selected_filters_click( selected_btns ) {

        selected_btns.forEach( btn => {

           btn.addEventListener( 'click', () => {

            this.currentPage = 1;
            let filter_type = btn.getAttribute( 'data-type' );
            let filter_value = btn.getAttribute( 'data-option' );
            let currently_selected_filters = [];

            this.skeletonWrapper.style.display = 'block';
            this.numberOfResults.innerHTML = 'Finding results...';
            this.products_grid_container.innerHTML = '';

            //Update the filters array and URL params after a selected filter is removed
            this.filters_array.forEach( filter => {

                if( filter.filter_type == filter_type ) {

                    if( filter.filter_settings.value == filter_value ) {

                        filter.filter_settings.selected = false;

                    }

                    //There can be multiple matching filter types with different values, so we ensure they are still active
                    if( filter.filter_settings.selected == true ) {

                        currently_selected_filters.push( filter.filter_settings.value );
                        this.filter_url_params.set( filter.filter_type, currently_selected_filters.join(',') );
                        
                    } else if ( filter.filter_settings.selected == false && currently_selected_filters.length == 0 ) {

                        // When selected_filters array is empty delete the filter_type from the URL params
                        this.filter_url_params.delete( filter.filter_type );

                    }

                }

            })

            if( btn.classList.contains( 'min-price-selected-btn' ) ) {

                this.isMinPrice = false;
                this.pricesFrom.forEach( from => { from.value = ''; });

            }

            if( btn.classList.contains( 'max-price-selected-btn' ) ) {

                this.isMaxPrice = false;
                this.pricesTo.forEach( to => { to.value = ''; });

            }

            if( btn.classList.contains( 'min-max-price-selected-btn' ) ) {

                this.isMinPrice = false;
                this.pricesFrom.forEach( from => { from.value = ''; });
                this.isMaxPrice = false;
                this.pricesTo.forEach( to => { to.value = ''; });

            }
           
            this.product_filter_btns.forEach( filter_btn => {

                let filter_btn_value = filter_btn.getAttribute( 'data-option' );

                if( filter_btn_value == filter_value ) {

                    filter_btn.classList.remove( 'active' );
                }
    
            })

            this.mobile_product_filter_btns.forEach( filter_btn => {

                let filter_btn_value = filter_btn.getAttribute( 'data-option' );

                if( filter_btn_value == filter_value ) {

                    filter_btn.classList.remove( 'active' );
                }
    
            })

            btn.remove();

            let remaining_filter_btns = document.querySelectorAll( '.selected-filter-btn' );
            if( remaining_filter_btns.length == 0 ) {

                this.selected_filters.style.display = 'none';

            }

             if( remaining_filter_btns.length > 1 ) {

                this.clear_all_btn.style.display = 'block';

            } else {

                this.clear_all_btn.style.display = 'none';

            }

            this.queryString = this.filter_url_params.toString().replace(/%2C/g, ',');
            this.getFilteredResults();

           })

        })

    }

    clear_all_filters() {

        this.clear_all_btn.addEventListener( 'click', () =>  {

            //Set each filter selection to false
            this.filters_array.forEach( filter => {
    
                filter.filter_settings.selected = false; 

            })

            //Remove the active filters
            if( this.selected_filter_btns.length ) {

                this.selected_filter_btns.forEach( btn => {

                    btn.remove();
    
                });
            } 

            this.product_filter_btns.forEach( filter_btn => { 

                filter_btn.classList.remove( 'active' );

            })

            this.mobile_product_filter_btns.forEach( filter_btn => { 

                filter_btn.classList.remove( 'active' );

            })

            this.isMinPrice = false;
            this.isMaxPrice = false;

            //Reset the filter params
            this.queryString = '';
            this.filter_url_params = new URLSearchParams();
            this.isFiltered = false;

            //Reset pagination
            this.currentPage = 1;

            this.skeletonWrapper.style.display = 'block';
            this.numberOfResults.innerHTML = 'Finding results...';
            this.products_grid_container.innerHTML = '';

            this.selected_filters.style.display = 'none';
            this.getFilteredResults();

        })

    }

    clearShopSearch( clear_btn ) {

        clear_btn.addEventListener( 'click', () => {

            document.querySelector( '.clear-shop-search' ).remove();
            this.isSearching = false;
            this.headerSearchLabel.style.display = 'block';
            this.headerSearchField.value = '';

            this.currentPage = 1;
            this.skeletonWrapper.style.display = 'block';
            this.numberOfResults.innerHTML = 'Finding results...';
            this.products_grid_container.innerHTML = '';
            this.getFilteredResults();

        })

    }

    sort_results() {

        this.sort_options.forEach( option => {

            option.addEventListener( 'click', () => {

                let sort_type = option.getAttribute( 'data-sort' );
                let sort_label = option.getAttribute( 'data-sort-label' );
                this.sortBy = sort_type;
                this.sortLabel.textContent = sort_label;
                this.skeletonWrapper.style.display = 'block';
                this.numberOfResults.innerHTML = 'Finding results...';
                this.products_grid_container.innerHTML = '';
                this.currentPage = 1;
                this.getFilteredResults();

            })

        })


    }

    async getFilteredResults( url_params ) {
  
        try {
    
            const response = await fetch( `${search_vars.root_url}/wp-json/product/v1/products?${this.queryString}&sort_by=${this.sortBy}&page=${this.currentPage}${this.isSearching ? '&search_query=' + this.headerSearchField.value : ''}${this.isMinPrice ? `&min-price=${this.minPrice}` : ''}${this.isMaxPrice ? `&max-price=${this.maxPrice}` : ''}` );
            const data = await response.json(); // Parse JSON even for errors

            if( !response.ok ) {
                // REST API returned an error (e.g. WP_Error from PHP)
                //throw new Error( data.message || 'Unknown error' );

                console.error(data.message); 
                console.error(data.data.code); 
                console.error(data.data.error_type);
                console.error(data.data);
                
            } else {

                console.log(response)
                console.log(data)
                console.log(this.selected_filter_btns.length)

                const results = data;

                let response_url = response.url;
                console.log(response_url)
                let query_string = response_url.split('?')[1]; //Get URL params
                let newUrl = `${window.location.origin}${window.location.pathname}?${query_string}`;
                window.history.pushState({}, '', newUrl);
            
                this.skeletonWrapper.style.display = 'none';
                this.numberOfResults.innerHTML = `Showing ${results.totalRecords} results`;

                if( this.isSearching && !document.querySelector( '.clear-shop-search' ) ) {

                    this.products_grid.insertAdjacentHTML( 'afterbegin', 
                    `<div class="clear-shop-search mb-2 d-flex flex-wrap align-items-center gap-1">
                        <h2><span class="font-weight-400">Searching for: </span><span class="font-weight-600 term">${this.headerSearchField.value}</span></h2>
                        <button class="clear-shop-search-btn d-flex" style="background: transparent;border: none;border-bottom: 2px dotted;border-radius: 0; padding: 0;">
                        <span>Clear</span> 
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="12 12 35 35">
                            <path data-name="Path 9036" d="M20.62,20.62,39.38,39.38" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5"></path><path data-name="Path 9037" d="M39.38,20.62,25.31,34.69l-4.69,4.69" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="1.5"></path>
                        </svg>
                        </button>
                    </div>` );

                    let clearShopBtn = document.querySelector( '.clear-shop-search-btn' );
                    this.clearShopSearch( clearShopBtn );
                }

                let records = results.recordsInfo

                if( records.length > 0 ) {

                    this.products_grid_container.innerHTML = `

                        ${ records.map( record => 
                            
                            `<a class="product-tile" href="${ record.permalink }">

                                <img src="${ record.image }" />

                                <div class="product-title">
                                    <h2 class="fs-small fs-576-base">${ record.band_name }</h2>
                                    <h3 class="fs-small fs-576-base">${ record.record_name }</h3>
                                </div>

                                <div class="short-desc d-none">
                                    ${ record.label ? `<span>Label: ${record.label} ${record.catno ? ` - ${record.catno}` : '' } </span>` : '' }
                                    ${ record.country ? `<span>Country: ${record.country}</span>` : '' }
                                    ${ record.release_date ? `<span>Released: ${record.release_date}</span>` : '' }
                                </div>
                                
                                <div class="add-to-basket">
                                    <span class="fs-medium">£${ record.price }</span>
                                </div>
                                
                            </a>
                            `
                            ).join( "" )
                        }
                    ` 

                this.display_pagination( this.currentPage, results.totalPages );
                if( results.totalPages > 1 ) {

                    this.pagination.style.display = 'flex';

                }

            } else {

                this.products_grid_container.innerHTML = `No Records found for those filters`;
                this.pagination.style.display = 'none';

            }    

        }        

        } catch ( err ) {
    
            console.error('Fetch failed:', err);
            console.error('Fetch failed:', err.message);
            console.error(err.data);


        }
    
      }


      generate_pagination( currentPage, totalPages ) {

        let pagination = [];

        //Add prev button as first item in the array when we are past the first page
        if ( currentPage > 1 ) {

          pagination.push( 'prev' );

        }

        //Always show the first page
        pagination.push(1);
  
        if ( currentPage > 3 ) {

          pagination.push( "..." );

        }
  
        //Add range of pages around the current page
        let startPage = Math.max( 2, currentPage - 1 );
        console.log(startPage)
        console.log((currentPage + 2) )
        let endPage;
        if( currentPage == 1 ) {

            endPage = Math.min( totalPages - 1, currentPage + 3 );

        } else if( currentPage == 2 ) {

          endPage = Math.min( totalPages - 1, currentPage + 2 );

        } else {

          endPage = Math.min( totalPages - 1, currentPage + 1 );

        }
        console.log(endPage)

        for ( let i = startPage; i <= endPage; i++ ) {

          pagination.push( i );

        }
  
        if ( currentPage < totalPages - 2 ) {

          pagination.push( "..." );

        }
  
        //Always show the last page
        if ( totalPages > 1 ) {

          pagination.push( totalPages );

        }

        //Add next button as last item in the array unless we are on the last page
        if ( currentPage !== totalPages ) {

            pagination.push( 'next' );
  
        }
  
        return pagination;

    }

    display_pagination( currentPage, max_pages ) {

        this.productPagination.innerHTML  = '';
        
        if( max_pages > 1 ) {

            let pagination = this.generate_pagination( currentPage, max_pages );
            console.log(pagination)

            pagination.forEach( ( page ) => {

                let li = document.createElement( 'li' );
                let button = document.createElement( 'button' );
            
                if ( page === "..." ) {

                    button.textContent = "...";
                    button.setAttribute( 'tabindex', '-1' );
                    li.classList.add( 'no-page' );

                } else if( page === 'prev' ) {
                
                    li.classList.add( 'filter-page-prev' );
                    button.innerHTML = `<svg aria-label="Previous" width="100" height="100" viewBox="0 0 100 100">
                                            <path class="icon" d="M70,2.5L73.5,6l-44,44l44,44L70,97.5L22.5,50L70,2.5z"></path>
                                        </svg>`;
                    button.classList.add( 'filter-nav-btn' );
                    button.onclick = () => {

                        this.currentPage -= 1;
                        let prev_page = this.currentPage;

                        this.skeletonWrapper.style.display = 'block';
                        this.numberOfResults.innerHTML = 'Finding results...';
                        this.products_grid_container.innerHTML = '';
                        this.getFilteredResults();
                        this.display_pagination( prev_page, max_pages );

                    };

                } else if( page === 'next' ) {

                    li.classList.add( 'filter-page-next' );
                    button.innerHTML = `<svg aria-label="Next" width="100" height="100" viewBox="0 0 100 100">
                                            <path class="icon" d="M30,97.5L26.5,94l44-44l-44-44L30,2.5L77.5,50L30,97.5z"></path>
                                        </svg>`;
                    button.classList.add( 'filter-nav-btn' );
                    button.onclick = () => {

                        this.currentPage += 1;
                        let next_page = this.currentPage;

                        this.skeletonWrapper.style.display = 'block';
                        this.numberOfResults.innerHTML = 'Finding results...';
                        this.products_grid_container.innerHTML = '';
                        this.getFilteredResults();
                        this.display_pagination( next_page, max_pages );

                    };
                
                } else {

                    button.textContent = page;
                    li.className = page === currentPage ? 'active' : '';
                    button.onclick = () => {

                    this.currentPage = page;

                    this.skeletonWrapper.style.display = 'block';
                    this.numberOfResults.innerHTML = 'Finding results...';
                    this.products_grid_container.innerHTML = '';
                    this.getFilteredResults();
                    this.display_pagination( page, max_pages );

                    };
                    

                }

                li.appendChild(button);
                this.productPagination.appendChild(li);

            });

        }

    }

    gridView() {

        this.grid_view_btn.addEventListener( 'click', () => {

            this.grid_view_btn.classList.add( 'active' );
            this.list_view_btn.classList.remove( 'active' );
            this.products_grid.classList.remove( 'list' );
            this.skeletonLoader.classList.remove( 'list' );

        })
    }

    listView() {

        this.list_view_btn.addEventListener( 'click', () => {

            this.list_view_btn.classList.add( 'active' );
            this.grid_view_btn.classList.remove( 'active' );
            this.products_grid.classList.add( 'list' );
            this.skeletonLoader.classList.add( 'list' );

        })

    }

    closeMobileFilterMenu() { 

        this.mobile_filter_overlay.addEventListener( 'click', ( e ) => {

            if ( this.mobile_filter_overlay.classList.contains( 'active' ) && e.target.classList.contains( 'mobile-filter-overlay' ) ) {

                this.mobile_filter_overlay.classList.remove( 'active' );
                document.body.classList.remove( 'fixed' );

            }

        });

        this.close_mobile_filter_menu.addEventListener( 'click', () => {

            if ( this.mobile_filter_overlay.classList.contains( 'active' ) ) {

                this.mobile_filter_overlay.classList.remove( 'active' );
                document.body.classList.remove( 'fixed' );

            }

        });

    }

    openMobileFilterMenu() {

        this.mobile_filter_btn.addEventListener( 'click', () => {

            this.mobile_filter_overlay.classList.add( 'active' );
            document.body.classList.add( 'fixed' );

        });
        
    }
  
}
  
export default ShopFilters