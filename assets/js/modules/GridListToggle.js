class GridListToggle {

    constructor() {

        this.shop = document.querySelector( ".shop" )
        this.product_grid = document.querySelector(".product-grid")
        this.grid_view_btn = document.getElementById( "grid-view-btn" )
        this.list_view_btn = document.getElementById( "list-view-btn" )

        this.events()
  
    }
  
    events() {

        if( this.product_grid && this.shop ){
            
            this.grid_view_btn.addEventListener( 'click', () => this.showGrid() )
            this.list_view_btn.addEventListener( 'click', () => this.showList() )
    
        }
     
    }
  
    showGrid() {
  
      this.product_grid.classList.remove( "list-view" )
      this.grid_view_btn.classList.add( "active" );
      this.list_view_btn.classList.remove( "active" ); 
  
    }

    showList() {
  
        this.product_grid.classList.add( "list-view" )
        this.list_view_btn.classList.add( "active" );
        this.grid_view_btn.classList.remove( "active" );
    }
  
  }
  
  export default GridListToggle