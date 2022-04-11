import axios from "axios"

class RecordCategorySelect {

    constructor() {

        this.openButton = document.querySelectorAll( ".genre-filter-cat" )
        this.resultsDiv = document.querySelector( ".featured-genre" )
        this.loadingScreen = document.querySelector( ".loading" )

        this.events()

    }

    events() {
    
        let dataAttribute
    
        this.openButton.forEach( el => {
    
          dataAttribute = el.getAttribute( 'data-category' )

          el.addEventListener( "click", e => {

            e.preventDefault()
    
            if ( ! el.classList.contains( 'active' ) ) {

                this.loadingScreen.style.display = "grid"
                dataAttribute = el.getAttribute( 'data-category' )
                this.getCategoryResults( dataAttribute )

            }
    
           //Create array of all elements that are not the one that has just been clicked
            const notClickedLinks = Array.from( this.openButton ).filter( ( notClickedLink ) => {
    
                return notClickedLink !== el
    
            } )
    
            //Remove active class from any elements that has it before adding it to the current element clicked
            notClickedLinks.forEach( ( notClickedLink ) => {
    
              notClickedLink.parentNode.classList.remove( 'active' )
              notClickedLink.classList.remove( 'active' )

            } )
          
            el.parentNode.classList.add( 'active' )
            el.classList.add( 'active' )
            
    
          })
    
        })
    
    }

    async getCategoryResults( dataAttribute ) {

    try {

        const response = await axios.get( search_vars.root_url + "/wp-json/product/v1/category?cat_slug=" + dataAttribute )
        const results = response.data

        console.log(results)

        let records = results.recordInfo
        console.log(records)

        this.resultsDiv.innerHTML = `<p>${ records[0].category_desc }</p> <div class="featured-genre-records">

        ${ records.map( record => 
            
            `
                <div class="featured-record">
                    <a href="${ record.permalink }"><img src="${ record.image }" class="record-img"></a>
                    <div class="record-desc">
                        <h3><a href="${ record.permalink }">${ record.title }</a></h3>
                    </div>  
                </div>  
        
            `
            ).join( "" )
        }

        </div>
        <a class="view-all-btn" href="${ records[0].category_link }">View All</a>
        ` 
        this.loadingScreen.style.display = "none"

        } catch ( e ) {

            console.log( e )

        }

    }
  
}
  
export default RecordCategorySelect