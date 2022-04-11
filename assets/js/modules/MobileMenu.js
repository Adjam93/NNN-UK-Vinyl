class MobileMenu {

  constructor() {

    this.menuIcon = document.querySelector(".menu-icon")
    this.mobileMenu = document.querySelector(".mobile-menu")
    //this.siteHeader = document.querySelector(".site-header")

    this.events()

  }

  events() {

    this.menuIcon.addEventListener("click", () => this.toggleTheMenu())
  
  }

  toggleTheMenu() {

    //this.menuContent.classList.toggle("site-header__menu-content--is-visible")
    this.mobileMenu.classList.toggle("open")
    this.menuIcon.classList.toggle("open")

  }

}

export default MobileMenu