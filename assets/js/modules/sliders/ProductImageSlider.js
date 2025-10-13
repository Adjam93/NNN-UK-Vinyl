import { gsap } from "gsap";
import { Draggable } from "gsap/Draggable";
import { InertiaPlugin } from "gsap/InertiaPlugin";
gsap.registerPlugin( Draggable, InertiaPlugin );

class ProductImageSlider {

    constructor() {

        this.wrapper = document.querySelector( '.slides-wrapper' );
        this.slides = document.querySelectorAll( '.slide' );
        this.thumbs = document.querySelectorAll( '.thumb' );
        this.mainSlider = document.querySelector( '.main-slider' );

        this.current = 0;
        this.total = this.slides.length;
        this.slideWidth = this.wrapper.offsetWidth;
        this.thumbDraggable, this.imageSlider;

        this.totalThumbsWidth = this.thumbs[0].getBoundingClientRect().width * this.thumbs.length;
        let gapWidth = 16 * ( this.thumbs.length - 1);
        this.scrollWidth = Math.ceil( this.totalThumbsWidth + gapWidth );
        console.log(this.scrollWidth)

        this.imageSlider = Draggable.create( this.wrapper, {
            type: "x",
            //inertia: true,
            bounds: {
                minX: this.wrapper.clientWidth - this.wrapper.scrollWidth,
                maxX: 0 // Prevent dragging past the last image
            },
           onDragEnd: () => {

                const dir = this.imageSlider.getDirection('x'); // returns "left", "right" or null
                console.log('Direction:', dir);

                let newIndex;
                if( dir === 'left' ) {
                    newIndex = Math.round( ( -this.imageSlider.x + 250) / this.slideWidth );
                }
                else {
                    newIndex = Math.round( ( -this.imageSlider.x - 250) / this.slideWidth );
                }
               
                this.goToSlide( newIndex );
                    
            }

        })[0];

        this.events();

    }

    events () {

        this.thumbs.forEach( ( thumb, idx ) => {

            thumb.addEventListener( 'click', () => {

                this.goToSlide( idx, true, thumb )

            });
        
        });

    }
  
    goToSlide( index, animate = true ) {

        if ( index < 0 || index >= this.total ) return;

        gsap.to( this.wrapper, {
            x: -index * this.slideWidth,
            duration: animate ? 0.5 : 0,
            ease: "power2.out"
        });

        console.log(this.thumbs[index], this.total);

        this.thumbs.forEach( t => t.classList.remove( 'active' ) );
        this.thumbs[index].classList.add( 'active' );
        this.current = index;

    }
  
}
  
export default ProductImageSlider