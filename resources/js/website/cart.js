
window.Vue = require('vue');
window.$cartBus = new Vue();

import languageBundle from '@kirschbaum-development/laravel-translations-loader!@kirschbaum-development/laravel-translations-loader';
import VueI18n from 'vue-i18n';
import VueCurrencyFilter from 'vue-currency-filter'

Vue.use(VueI18n);
const i18n = new VueI18n({
    locale: window._LANG,
    messages: languageBundle,
})

Vue.use(VueCurrencyFilter,{
    symbol : window.StoreConfig.currency_symbol,
    thousandsSeparator: window.StoreConfig.thousands_separator,
    fractionCount: window.StoreConfig.decimals,
    fractionSeparator: window.StoreConfig.decimal_separator,
    symbolPosition: 'front',
    symbolSpacing: true
}) // or with custom config

import CartResume  from './../components/cart/CartResumeComponent';
import CartAddItem  from './../components/cart/AddToCartComponent'
import ShoppingCart  from './../components/cart/ShoppingCartComponent'
import Example from './../components/ExampleComponent'

Vue.component('cart-resume', CartResume);
Vue.component('cart-add-item', CartAddItem);
Vue.component('shopping-cart', ShoppingCart);
Vue.component('example', Example);

let app = new Vue({
    el: '#app',
    i18n,
});


window.app =app;;



