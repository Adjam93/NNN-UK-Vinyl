import axios from "axios"

class RecordSearch {

    constructor() {
  
      this.mainOverlay = document.querySelector( '.overlay');
      this.headerOverlay = document.querySelector( '.header-overlay');
      this.headerSearchResults = document.querySelector( '.header-search-results' );
      this.searchWrapper = document.querySelector( '.search-wrapper' );
      this.resultsContainer = document.querySelector( '.header-results-container' );
      this.productResults = document.querySelector( '.product-results-container' );
      this.pageResults = document.querySelector( '.page-results-container' );
      
      this.basketBtn = document.querySelector( '.basket-btn' );
      this.openSearchBtn = document.querySelector( '.open-search-btn' );
      this.closeSearchBtn = document.querySelector( '.close-search' );
      this.recordSearchBox = document.querySelector( '.record-search' );
      this.mobileMenu = document.querySelector( '.mobile-menu' );
      this.menuBurger = document.querySelector( '.nav-menu-burger' );

      this.searchField = document.getElementById( 'records-search-input' );
      this.searchLabel = document.querySelector( '.record-search-label' );
      this.searchPlaceholder = document.querySelector( '.search-placeholder' );
      this.overlays = [ this.mainOverlay, this.headerOverlay ]
      this.skeletonWrappers = document.querySelectorAll( '.skeleton-wrapper' );

      let at992 = window.matchMedia( '( min-width: 992px )' );
      this.per_page = at992.matches ? 9 : 5;
  
      this.previousValue;
      this.typingTimer;
  
      this.events();
  
    }
  
    events() {
  
      this.searchField.addEventListener( "keyup", () => this.typingLogic(event) );
      this.searchField.addEventListener( "focus", () => this.onFocus() );
      this.searchFieldClick();
      this.overlayClicks();
      this.openSearchBox();
      this.closeSearchBox();

    }

    openSearchBox() {

      this.openSearchBtn.addEventListener( 'click', () => {

        this.recordSearchBox.classList.add( 'active' );
        this.closeSearchBtn.classList.add( 'active' );
        this.mobileMenu.classList.remove( 'open' );
        this.menuBurger.classList.remove( 'open' );

      });

    }

    closeSearchBox() {

      this.closeSearchBtn.addEventListener( 'click', () => {

        this.searchClose();

      });

    }
    
    typingLogic( event ) {
  
      if ( event.keyCode == "27" ) {

        this.searchField.blur();

      }

      if ( this.searchField.value !== this.previousValue ) {
  
        clearTimeout( this.typingTimer )
  
        if ( this.searchField.value ) {

            if( this.searchField.value.length < 3 ) {

              this.resultsContainer.classList.remove( 'show-results' );
              this.searchPlaceholder.style.display = 'block';
              this.productResults.innerHTML = '';
              this.pageResults.innerHTML = '';
              this.skeletonWrappers.forEach( wrapper => { wrapper.style.display = 'none' } );

            }
  
          //Search starts at 3 characters
          if( this.searchField.value.length > 2 ) {
          
            this.skeletonWrappers.forEach( wrapper => { wrapper.style.display = 'block' } );
            this.productResults.innerHTML = '';
            this.pageResults.innerHTML = '';
            this.resultsContainer.classList.add( 'show-results' );
            this.searchPlaceholder.style.display = 'none';
            this.searchActive();

            this.typingTimer = setTimeout( this.getSearchResults.bind( this ), 750 );
  
          } 

        } else {
  
          
          this.skeletonWrappers.forEach( wrapper => { wrapper.style.display = 'none' } );
          this.searchPlaceholder.style.display = 'block';
          this.productResults.innerHTML = '';
          this.pageResults.innerHTML = '';

        }
        
      }
  
      this.previousValue = this.searchField.value
  
    }

    searchActive() {

      this.basketBtn.classList.add( 'search-active' );
      this.searchWrapper.classList.add( 'active' );
      this.closeSearchBtn.classList.add( 'active' );
      this.searchLabel.style.display = "none";
      this.headerSearchResults.classList.add( "show-search" );
      this.mainOverlay.classList.add( 'active' );
      this.headerOverlay.classList.add( 'active' );

      document.querySelector( '.header-items-wrapper' ).setAttribute( 'inert', true );
      document.querySelector( 'main' ).setAttribute( 'inert', true );
      document.querySelector( 'footer' ).setAttribute( 'inert', true );

    }

    searchClose() {

      this.recordSearchBox.classList.remove( 'active' );
      this.basketBtn.classList.remove( 'search-active' );
      this.searchWrapper.classList.remove( 'active' );
      this.closeSearchBtn.classList.remove( 'active' );

      if( this.searchField.value.length == 0 ) {

        this.searchLabel.style.display = "block";

      }

      this.headerSearchResults.classList.remove( "show-search" );
      this.mainOverlay.classList.remove( 'active' );
      this.headerOverlay.classList.remove( 'active' );

      document.querySelector( '.header-items-wrapper' ).removeAttribute( 'inert' );
      document.querySelector( 'main' ).removeAttribute( 'inert' );
      document.querySelector( 'footer' ).removeAttribute( 'inert' );

    }

    onFocus() {

      this.searchLabel.style.display = "none";

    }
  
    searchFieldClick() {

      this.searchField.addEventListener( 'click', () => {

        this.searchActive();

      })
     
    }

    overlayClicks() {

      this.overlays.forEach( overlay => {

        overlay.addEventListener( 'click', () => {

          this.searchClose();

        })

      })
      
    }

    async getSearchResults() {
  
      try {

        const products_response = await axios.get( search_vars.root_url + "/wp-json/product/v1/products?search_query=" + this.searchField.value + '&per_page=' + this.per_page );
        const pages_response = await axios.get( search_vars.root_url + "/wp-json/wp/v2/pages?search=" + this.searchField.value + '&per_page=5' );

        this.skeletonWrappers.forEach( wrapper => { wrapper.style.display = 'none' } );
        let products_data = products_response.data;
        let showMoreRecords = false

        if( products_data.totalRecords > 9 ) {

          showMoreRecords = true;
            
        }

        let records = products_data.recordsInfo;

          this.productResults.innerHTML = `
  
            ${ records.length ? '' : '<p class="no-results">No products found for that search</p>' }

            ${ records.map( record => 
                
                `<div class="result-content">
                      <img src="${ record.image }">
                      <div class="result-desc">
                          <h3>
                            <span class="band-name">${ record.band_name }</span>
                            <br>
                            <span class="record-name">${ record.record_name }</span>
                          </h3>
                          <span class="record-price"> £${ record.price }</span>
                      </div>  
                      <a href="${ record.permalink }"></a>
                  </div>
                `
                ).join( "" )
            }

            ${ showMoreRecords ? `<a class="view-all-products-btn" href=${ search_vars.root_url + '/shop?search_query='+ this.searchField.value }>All Products &#62;</a>` : '' }
          ` 

          let pages_data = pages_response.data;
          let showMorePages = false
        
          if( pages_data.length > 3 ) {

            showMorePages = true;
            pages_data = pages_data.slice( 0, 3 );
            
          }

          this.pageResults.innerHTML = `
    
              ${ pages_data.length ? '' : '<p class="no-results">No pages found</p>' }

              <ul class="d-grid gap-050">
                ${ pages_data.map( page => 
                    `<li>
                        <a class="d-block c-black" href="${page.link}">${page.title.rendered}</a>
                      </li>`
                  ).join( "" )
                }

                ${ showMorePages ? '<li class="font-weight-500"><a class="d-block c-black" href="#">More Pages &#62;</a></li>' : '' }
              </ul>
            ` 

      } catch ( e ) {
  
        console.log( e );
  
      }
  
    }
  
  }
  
export default RecordSearch;