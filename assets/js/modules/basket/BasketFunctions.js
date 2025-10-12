let basket_items = document.querySelector( '.basket-items-container' );
let error_notice_wrapper = document.querySelector( '.error-notice-wrapper' );
let error_notice = document.querySelector( '.product-error-notices' );
let add_to_basket_btn = document.querySelector( '.add-to-basket-btn' );
let get_basket_total_price = document.querySelector( '.get-basket-total' );
let loading_overlay = document.querySelector( '.filter-loading-overlay' );

async function getBasketTotal() {

    try {

        const response = await fetch( search_vars.root_url + '/wp-json/wc/store/v1/cart/' );

        if ( !response.ok ) {

            throw new Error( 'Failed to fetch basket total' );

        }

        const results = await response.json();
        get_basket_total_price.innerHTML = formatTotalPrice(results.totals, 'total_items');

        if ( results.items_count > 0 ) {

            document.querySelector( '.nav-basket-counter' ).classList.add( 'active' );
            document.querySelector( '.nav-basket-counter' ).innerText = parseInt( results.items_count );

        } else {

            document.querySelector( '.nav-basket-counter' ).classList.remove( 'active' );
            
        }

    } catch (e) {

        console.warn(e);

    }

}

function formatTotalPrice( totals, key = 'total_items' ) {

    const rawValue = totals[key];
    const adjustedValue = Number(rawValue) / Math.pow( 10, totals.currency_minor_unit );

    // Format using Intl.NumberFormat
    return new Intl.NumberFormat( 'en-GB', {

        style: 'currency',
        currency: totals.currency_code,
        minimumFractionDigits: totals.currency_minor_unit,
        maximumFractionDigits: totals.currency_minor_unit

    } ).format( adjustedValue );

}

function formatPrice( prices ) {

    // Parse raw price from string to number and adjust using precision
    const rawPrice = Number( prices.raw_prices.price );
    const precisionDivisor = Math.pow( 10, prices.raw_prices.precision );
    const adjustedPrice = rawPrice / precisionDivisor;

    // Format using Intl.NumberFormat for proper currency formatting
    return new Intl.NumberFormat( 'en-GB', {
        
        style: 'currency',
        currency: prices.currency_code,
        minimumFractionDigits: prices.currency_minor_unit,
        maximumFractionDigits: prices.currency_minor_unit

    } ).format( adjustedPrice );

}

async function getBasketResults() {

    try {

    const response = await fetch( search_vars.root_url + '/wp-json/wc/store/v1/cart/items' );

    if ( !response.ok ) {

        throw new Error('Failed to fetch basket items');

    }

    const results = await response.json();
    console.log(response)
    console.log(results)

        basket_items.innerHTML = `

        ${ results.map( result => 
            
            `<div class="basket-item-wrapper">
            
                <div class="basket-item">

                    <a href="${result.permalink}" class="basket-item-image">
                        <img src="${result.images[0].src}"> 
                    </a>
                        
                    <div class="basket-item-info d-grid">

                        <a href="${result.permalink}" >
                            <h3>${result.name.replace('&#8211;', '<br>')}</h3>
                        </a>
                        
                        <span>Quantity: ${result.quantity}</span>
                
                        <div class="basket-item-price d-flex">
                            <span class="basket-menu-price">${formatPrice(result.prices)}</span>
                            <button class="basket-menu-delete" data-key="${result.key}"></button>
                        </div>
                    
                    </div>
                    
                </div>
            </div>
            `
            ).join( "" )
        }
        `;

        dispatchBasketUpdatedEvent();

    } catch ( e ) {

        console.warn( e );

    }

}

function dispatchBasketUpdatedEvent() {

    const event = new CustomEvent( 'basketUpdated' );
    document.dispatchEvent( event) ;

}

async function onDeleteBasketItem( itemKey ) {

    try {

        loading_overlay.style.display = 'flex';

        const response = await fetch( search_vars.root_url + `/wp-json/wc/store/v1/cart/remove-item?key=${itemKey}`, {

            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Nonce': storeApiNonce
            }

        });

        if ( !response.ok ) {

            throw new Error(`Error ${response.status}: ${response.statusText}`);

        }

        await getBasketTotal();
        await getBasketResults();

        loading_overlay.style.display = 'none';


    } catch( error ) {

        console.error( 'Failed to remove item:', error) ;

    }
    
}

function errorMessages( code, message ) {

    console.log(code)
    let message_to_display = '';

    switch( code ) {

        case 'woocommerce_rest_product_partially_out_of_stock':

            message_to_display = `You cannot add more than the maximum quantity (${add_to_basket_btn.dataset.quantity}) to your basket`;

        break;

        case 'woocommerce_rest_invalid_nonce':

            message_to_display = `Your session has expired - please refresh`;

        break;

        default:

            message_to_display = `${message}`;

        break;


    }

    console.log(message_to_display)

    return message_to_display;

}

async function onAddBasketItem( itemID, quantity ) {

    try {

        const response = await fetch( search_vars.root_url + `/wp-json/wc/store/v1/cart/add-item?id=${itemID}&quantity=${quantity}`, {

            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Nonce': storeApiNonce
            }

        });

        const result = await response.json();
        // console.log(response)
         console.log(result)

        if ( !response.ok ) {

            console.error( 'Failed to add item:', result.message || 'Unknown error', result );

            error_notice.innerHTML = errorMessages( result.code, result.message );
            error_notice_wrapper.classList.add( 'active' );
            return;
          

        }

        await getBasketTotal();
        await getBasketResults();
        document.querySelector( '.overlay' ).classList.add( 'active' );
        document.querySelector( '.basket-menu' ).classList.add( 'active' );
        document.querySelector( '.basket-btn' ).classList.add( 'active' );

    } catch( error ) {

        console.error( 'Failed to add item:', error ) ;

    }

}


export { getBasketTotal, getBasketResults, onDeleteBasketItem, onAddBasketItem};