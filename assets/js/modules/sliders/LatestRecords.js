import { gsap } from "gsap";
import { Draggable } from "gsap/Draggable";
import { InertiaPlugin } from "gsap/InertiaPlugin";
gsap.registerPlugin( Draggable, InertiaPlugin );

class LatestRecordsSlider {

    constructor() {

        this.slider = document.querySelector(".records-grid");
        this.maxDrag = this.slider.scrollWidth - this.slider.offsetWidth;
        this.progressBar = document.querySelector('.progress-bar');
        this.record_width = document.querySelector( '.record img' ).clientWidth + 32; //32 = 2em gap: (16px(x2))

        this.prev = document.getElementById('prev-btn');
        this.next = document.getElementById('next-btn');

        this.latest_records_slider();
    }
  
    latest_records_slider() {

        let drag_carousel = Draggable.create(this.slider, {
            type: "x",
            inertia: true,
            allowContextMenu: true,
            bounds: {
              maxX: 0,
              minX: this.slider.clientWidth - this.slider.scrollWidth
            },
            onDrag: () => {

                const progress = Math.abs(drag_carousel.x) / this.maxDrag; // 0 to 1
                gsap.set(this.progressBar, { width: `${progress * 100}%` });
                this.prev.disabled = true;
                this.next.disabled = true;

            },
            onThrowUpdate: () => { 
               
                const progress = Math.abs(drag_carousel.x) / this.maxDrag;
                gsap.set(this.progressBar, { width: `${progress * 100}%` });
            },
            onThrowComplete: () => {
                this.prev.disabled = false;
                this.next.disabled = false;
            },

          })[0];

          document.getElementById( 'prev-btn' ).addEventListener( 'click', (e) => {
            
                gsap.to( this.slider, { 

                  x: `+=${this.record_width}`, 
                  duration: 0.3, 
                   onUpdate: () => { 
                        drag_carousel.applyBounds();
                        const progress = Math.abs(drag_carousel.x) / this.maxDrag; // 0 to 1
                        gsap.set(this.progressBar, { width: `${progress * 100}%` });
                   } 

                });
            
            
          });

          document.getElementById( 'next-btn' ).addEventListener( 'click', (e) => {
              
               gsap.to( this.slider, { 
                 x: `+=-${this.record_width}`, 
                 duration: 0.3, 
                 onUpdate: () => { 
                    drag_carousel.applyBounds();
                    const progress = Math.abs(drag_carousel.x) / this.maxDrag;
                    gsap.set(this.progressBar, { width: `${progress * 100}%` });
                } 
               
               });
              
        });
  
    }
  
}
  
export default LatestRecordsSlider