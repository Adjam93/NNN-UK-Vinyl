import $ from 'jquery'

class ShopFilters {

    constructor() {
  
        this.shop = document.querySelector( ".shop" )
        this.sidebar = document.querySelector( ".sidebar-wrapper" )
        this.mobile_filter_btn = document.getElementById( "mobile-filter-btn" )
        this.filter_close_btn = document.querySelectorAll( ".filter-close-btn" )

        this.mutationElement = document.querySelector( ".awf-active-badges-container" )
        this.mutationConfig = { attributes: true, childList: true }
        this.filters = document.querySelector( ".mobile-active-filters" )

        this.events()
        this.observedItems()

    }
  
    events() {

        if( this.sidebar && this.shop ){
            
            this.mobile_filter_btn.addEventListener( 'click', () => this.showFilters() )

            this.filter_close_btn.forEach( closeBtn => {
                closeBtn.addEventListener( 'click', () => this.hideFilters() )
            })

            //this.filter_close_btn.addEventListener( 'click', () => this.hideFilters() )

            this.badgeObserver = new MutationObserver( this.observerCallback )

        }
     
    }
  
    showFilters() {
  
        this.sidebar.classList.add( "open" )
  
    }

    hideFilters() {
  
        this.sidebar.classList.remove( "open" )
    
    }

    observerCallback( mutationsList, observer ) {

        $( ".mobile-active-filters" ).empty()
        $(".awf-active-badges-container").clone( true, true ).contents().appendTo('.mobile-active-filters')

    }

    observedItems() {  

        if( this.sidebar && this.shop ){
            
            this.badgeObserver.observe( this.mutationElement, this.mutationConfig ) 

        }
    }
  
}
  
export default ShopFilters