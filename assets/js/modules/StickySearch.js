class StickySearch {

    constructor() {

        this.header = document.querySelector( 'header' );
        this.basketBtn = document.querySelector( '.basket-btn' );
        this.searchBox = document.querySelector( '.record-search' );
        this.searchInput = document.getElementById( 'records-search' )
        this.searchResults = document.querySelector( '.header-search-results' )

        this.events()

    }
  
    events() {

        let headerHeight = this.header.clientHeight - 2;
        document.documentElement.style.setProperty( '--overlay-top', headerHeight + 'px' );

        let basketOffset = Math.round( this.basketBtn.getBoundingClientRect().bottom + 14 );
        document.documentElement.style.setProperty( '--basket-menu-top', basketOffset + 'px' );
        
        window.addEventListener( 'resize', () => {
            this.calculateHeaderHeight();
            this.calculateBasketOffset();
        } );

    }

    calculateHeaderHeight() {

        let headerHeight = this.header.clientHeight - 2;
        document.documentElement.style.setProperty( '--overlay-top', headerHeight + 'px' );
       
    }

    calculateBasketOffset() {

        let basketOffset = Math.round( this.basketBtn.getBoundingClientRect().bottom + 14 );
        document.documentElement.style.setProperty( '--basket-menu-top', basketOffset + 'px' );

    }
  
}
  
export default StickySearch