import {HTTP} from '../../../mixins/http-common';
import notifier from '../../../mixins/notifier';

export default {
    mixins: [notifier],
    data() {
        return {
            baseUrl: window.urlAjaxHandler+"/api/store/",
            hasError: false,
        }
    },
    methods: {

        addProductToCart() {
            return HTTP.post(this.url(), {
                    product_code: this.product.code,
                    quantity: this.quantity
                })
                .then(this.refreshCart)
                .catch(e => {
                    //self.errors.push(e)
                    this.notifyError(e)
                })
        },
        updateItemQuantity(q, id) {
            return HTTP.post(this.update_url(), {
                    id: id,
                    quantity: q
                 })
                .catch(e => {
                    this.notifyError(e)
                })
        },
        deleteItem(id) {
            return HTTP.post(this.delete_url(), {id})
                .then(this.updateCartItems)
                .catch(e => {
                      this.notifyError(e)
                })
        },
        refreshCart({data}) {
            window.$cartBus.$emit('ADD_ITEM_TO_CART', data.data)
            this.modalOpen = true;
        },
        gotToCart() {
            location.href= window.urlAjaxHandler+'/cart';
        },
        updateCartItems({data}) {
            window.$cartBus.$emit('DELETE_ITEM_FROM_CART', data.data)
            this.notify(data.msg)
        },
        delete_url() {
            return `${this.baseUrl}cart-item-remove`;
        },
        update_url() {
            return `${this.baseUrl}cart-item-update`;
        },
    },
}