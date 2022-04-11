import axios from "axios"

class RecordSearch {

    constructor() {
  
      this.resultsDiv = document.querySelector( ".header-search-results" )
      this.searchField = document.getElementById( "records-search" )
      this.searchOverlay = document.querySelector( ".search-overlay" )
  
      this.previousValue
      this.typingTimer
  
      this.events()
  
    }
  
    events() {
  
      this.searchField.addEventListener( "keyup", () => this.typingLogic(event) )
      this.searchField.addEventListener( "focus", () => this.onFocus() )

    }

    
    typingLogic( event ) {
  
      if ( event.keyCode == "27" ) {

        this.searchField.blur()
        this.resultsDiv.classList.remove( "show-results" )
        this.searchOverlay.style.display = "none"

      }

      if ( this.searchField.value != this.previousValue ) {
  
        clearTimeout( this.typingTimer )
  
        if ( this.searchField.value ) {
         
            this.resultsDiv.classList.add( "show-results" )

            if( this.searchField.value.length < 3 ) {

                this.resultsDiv.classList.add( "show-results" )
                this.searchOverlay.style.display = "flex"
               // this.resultsDiv.innerHTML = '<div class="spinner-loader">Searching... (please enter at least 3 or more characters)</div>'
                this.resultsDiv.innerHTML = ''
               // this.resultsDiv.insertAdjacentHTML('beforeend', '<div class="spinner-loader">Searching... (please enter at least 3 or more characters)</div>')

            }
  
          //Search starts at 3 characters
          if( this.searchField.value.length > 2 ) {
          
              this.typingTimer = setTimeout( this.getSearchResults.bind( this ), 750 )
  
          } 

          if( this.searchField.value.length >= 3 ) {
  
              this.searchOverlay.style.display = "flex"

              //this.resultsDiv.innerHTML = '<div class="spinner-loader">Searching... (please enter at least 3 or more characters)</div>'
             // this.resultsDiv.insertAdjacentHTML('beforeend', '<div class="spinner-loader">Searching... (please enter at least 3 or more characters)</div>');
              //this.typingTimer = setTimeout( this.getSearchResults.bind( this ), 750 )
  
          } 
         
  
        } else {
  
          this.resultsDiv.classList.remove( "show-results" )
          this.searchOverlay.style.display = "none"

        }
        
      }
  
      this.previousValue = this.searchField.value
  
    }
  
    onFocus() {

      if ( this.searchField.value.length > 0 ) {

        this.resultsDiv.classList.add( "show-results" )

      }

      if ( this.searchField.value && this.searchField.value.length <=2  ) {

        this.searchOverlay.style.display = "flex"

      }


    }
  
    /* SET SEARCH LIMIT (e.g. 24) - IF NUMBER OF RESULTS = LIMIT SHOW VIEW ALL BUTTON, WHICH REDIRECTS TO SEARCH PAGE WITH CHOSEN SEARCH TERM  */


    async getSearchResults() {
  
      try {
  
       // http://nnn-uk-vinyl.local/wp-json/wp/v2/product?search=division
        const response = await axios.get( search_vars.root_url + "/wp-json/product/v1/search?term=" + this.searchField.value )
  
       // const response = await fetch("http://movie-api.local/wp-json/wp/v2/movie?categories=" + dataAttribute)
        //const data = response.json()
        const results = response.data
  
        this.searchOverlay.style.display = "none"
        let records = results.recordInfo
        let searchURL = search_vars.root_url + "/?s=" + this.searchField.value

        console.log(records.length)

          this.resultsDiv.innerHTML = `
  
            ${ records.length ? '' : '<p class="no-results">No products found for that search.</p>' }

            ${ records.map( record => 
                
                `<div class="container">
                    <div class="result-content">
                        <a href="${ record.permalink }"><img src="${ record.image }" class="poster"></a>
                        <div class="result-desc">
                            <h3><a href="${ record.permalink }">${ record.title }</a></h3>
                            <p>${ record.description }</p>
                            <span> £${ record.price }</span>
                        </div>  
                    </div>  
                </div>
                `
                ).join( "" )
            }
      
            ${ records.length == 3 ? '<div class="view-all"><a class="view-all-results" href="' + searchURL +'">View All Records</a></div>' : '' }

          ` 

      } catch ( e ) {
  
        console.log( e )
  
      }
  
    }
  
  }
  
export default RecordSearch