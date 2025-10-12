class MenuBasket {

    constructor() {

      this.headerOverlay = document.querySelector( '.header-overlay' );
      this.overlay = document.querySelector( '.overlay' );
      this.basketMenu = document.querySelector( '.basket-menu' );
      this.basketBtn = document.querySelector( '.basket-btn' );
      this.closeBasketBtn = document.querySelector( '.close-basket-menu' );
      this.recordSearch = document.querySelector( '.record-search' );
      
      this.events();
  
    }
  
    events() {

      this.basketBtn.addEventListener( 'click', () => this.showBasketMenu() );
      this.closeBasketBtn.addEventListener( 'click', () => this.hideBasketMenu() );
      this.headerOverlay.addEventListener( 'click', () => this.hideBasketMenu() );
      this.overlay.addEventListener( 'click', () => this.hideBasketMenu() );

    }
  
    showBasketMenu() {
  
      this.basketBtn.classList.toggle( 'active' );
      this.basketMenu.classList.toggle( 'active' );
      this.headerOverlay.classList.toggle( 'active' );
      this.overlay.classList.toggle( 'active' );
      document.body.classList.toggle( 'overflow-hidden' );
      this.recordSearch.classList.toggle( 'basket-active' );
  
    }

    hideBasketMenu() {

      this.basketBtn.classList.remove( 'active' );
      this.basketMenu.classList.remove( 'active' );
      this.headerOverlay.classList.remove( 'active' );
      this.overlay.classList.remove( 'active' );
      document.body.classList.remove( 'overflow-hidden' );
      this.recordSearch.classList.remove( 'basket-active' );

    }
  
  }
  
export default MenuBasket