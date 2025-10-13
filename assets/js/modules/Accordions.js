class Accordions {

    constructor() {
       
        this.accordion_slide_btns = document.querySelectorAll( '.accordion-btn' );
        this.accordion_slide_content = document.querySelectorAll( '.accordion-content' );

        this.events()
  
    }
  
    events() {

        this.accordion_slide_btns.forEach( btn => { 

            btn.addEventListener( 'click', () => {

                this.accordion_slide_content.forEach( content => {

                    if( btn.dataset.accordion == content.dataset.accordion ) {
            
                        btn.classList.toggle( 'active' );
                        btn.parentNode.classList.toggle( 'active' );

                        btn.classList.contains( 'active' ) ? 
                        btn.setAttribute( 'aria-expanded', true ) :
                        btn.setAttribute( 'aria-expanded', false );

                        content.classList.toggle( 'active' );
                    }

                });
                
            });

        });
     
    }
  
}
  
export default Accordions