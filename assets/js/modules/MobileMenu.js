class MobileMenu {

  constructor() {

    this.menuIcon = document.querySelector( '.nav-menu-burger' )
    this.mobileMenu = document.querySelector( '.mobile-menu' )

    this.events()

  }

  events() {

    this.menuIcon.addEventListener( 'click', ( ) => this.toggleTheMenu( ) );
  
  }

  toggleTheMenu() {

    this.mobileMenu.classList.toggle( 'open' )
    this.menuIcon.classList.toggle( 'open' )

  }

}

export default MobileMenu