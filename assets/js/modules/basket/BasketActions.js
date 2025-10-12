
import { getBasketTotal, getBasketResults, onDeleteBasketItem, onAddBasketItem } from './BasketFunctions';

class BasketActions  {

    constructor() {
   
        this.basket_delete_btns = '';

        this.add_to_basket_btn = document.querySelector( '.add-to-basket-btn' );
        this.error_notice_wrapper = document.querySelector( '.error-notice-wrapper' );
        this.addBasketItem();

        this.qtyPlus = document.querySelector( '.qty-plus' );
        this.qtyMinus = document.querySelector( '.qty-minus' );
        this.quantity_input = document.querySelector( '.qty-input' );
        this.controlQuantity();

        this.events()
    }
  
    events() {

        //Events that happen on every page load - get basket total & results
        this.updateBasket();

        //Refresh delete buttons after the basket data has been recieved
        document.addEventListener( 'basketUpdated', () => {

            this.basket_delete_btns = document.querySelectorAll( '.basket-menu-delete' );
            console.log(this.basket_delete_btns)
            this.deleteBasketItem(); 
            
        });

    }

    async updateBasket() {

        await getBasketTotal();
        await getBasketResults();

    }

    deleteBasketItem() {

        if( this.basket_delete_btns ) {

            this.basket_delete_btns.forEach( btn => {

                btn.addEventListener( 'click', () => {

                    onDeleteBasketItem( btn.dataset.key );

                });

            });

        }

    }

    addBasketItem() {

        if( this.add_to_basket_btn ) {

            this.add_to_basket_btn.addEventListener( 'click', () => {

                this.error_notice_wrapper.classList.remove( 'active' );
                let quantity = this.quantity_input ? this.quantity_input.dataset.currentQuantity : this.add_to_basket_btn.dataset.quantity;
                onAddBasketItem( this.add_to_basket_btn.dataset.product_id, quantity );

            });

        }

    }


    controlQuantity() {

        if( this.qtyMinus ) {

            this.qtyMinus.addEventListener( 'click', () => {

                let decreaseQuantity = parseInt( this.quantity_input.dataset.currentQuantity );
                const min = parseInt( this.quantity_input.dataset.min );
                if ( decreaseQuantity > min ) {
                    
                    decreaseQuantity -= 1;
                    this.quantity_input.setAttribute( 'data-current-quantity', decreaseQuantity );
                    this.quantity_input.innerText = String( decreaseQuantity );

                }

            })

        }

        if( this.qtyPlus ) {

            this.qtyPlus.addEventListener( 'click', () => {

                let increaseQuantity = parseInt( this.quantity_input.dataset.currentQuantity );
                const max = parseInt( this.quantity_input.dataset.max );
                if ( increaseQuantity < max ) {
                    
                    increaseQuantity += 1;
                    this.quantity_input.setAttribute( 'data-current-quantity', increaseQuantity );
                    this.quantity_input.innerText = String( increaseQuantity );

                }

            })

        }

    }
  
}
  
export default BasketActions;