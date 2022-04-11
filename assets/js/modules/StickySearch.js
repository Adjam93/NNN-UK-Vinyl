class StickySearch {

    constructor() {

        this.header = document.querySelector( "header" )
        this.searchBox = document.querySelector(".record-search");
        this.searchInput = document.getElementById( "records-search" )
        this.searchResults = document.querySelector( ".header-search-results" )
   

        this.stickyOptions = {
            rootMargin:  "-100px 0px 0px 0px"
        }

        this.events()
        this.observedItems()

    }
  
    events() {
  
        this.stickyOnScroll = new IntersectionObserver( this.intersectionCallback, this.stickyOptions )

        document.addEventListener('click', function(e){   

            //|| document.activeElement.parentElement.classList.contains('result-desc')

            if ( document.querySelector( ".header-search-results" ).contains( e.target ) || document.getElementById( "records-search" ).contains( e.target )
                    || document.activeElement.id == "records-search" ){

                // Clicked in box
                //console.log(document.activeElement)

            } else{

                // Clicked outside the box
                document.querySelector( ".header-search-results" ).classList.remove( "show-results" )
                document.querySelector( ".search-overlay" ).style.display = "none"

            }

        })



    }

    intersectionCallback( entries, stickyOnScroll ) {

        entries.forEach( entry => {

            if ( !entry.isIntersecting ) {

                entry.target.classList.add("fixed");

            } 
            else {

                entry.target.classList.remove("fixed");
                
            }

        })

    }

    observedItems() {  

        this.stickyOnScroll.observe( this.header )
        
    }
  
}
  
export default StickySearch