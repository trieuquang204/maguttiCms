<template>
    <div class="container">
            <alert-box v-if="this.items.length==0" class="alert-info">
                <template #content><h5>{{$t('store.cart.empty')}}</h5></template>
            </alert-box>
            <div v-else class="table-responsive">
                <table  class="table table-hover table-striped cart-resume">
                <thead>
                <tr>
                    <th class="width-10"></th>
                    <th class="width-10">{{$t('store.cart.table.code')}}</th>
                    <th>{{$t('store.cart.table.name')}}</th>
                    <th class="width-10">{{$t('store.cart.table.quantity')}}</th>
                    <th class="width-10">{{$t('store.cart.table.price')}}</th>
                    <th class="width-10">{{$t('store.cart.total')}}</th>
                    <th class="width-10 text-center">{{$t('store.cart.table.actions')}}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,index) in items" :key="index">
                    <td><a :href="item.product.url"><img :src="item.product.thumb_image"></a></td>
                    <td>
                        {{item.product.code}}
                    </td>
                    <td>
                        {{item.product.title}}
                    </td>
                    <td style="width:200px">
                        <!--<input
                            type="number"
                            v-model.lazy="item.quantity"
                            autocomplete="off"
                            v-bind:min="1"
                            @keyup="updateCartItem(item.quantity,item)"
                            @change="updateCartItem(item.quantity,item)"
                        >-->

                        <number-input
                            :hideDecreaseBtn="true"
                            :hideIncreaseBtn="true"
                            :qty="parseInt(item.quantity)"
                            :min="1" v-model="item.quantity" class="input-group-sm "
                            @changeQuantity="updateCartItem(item.quantity,item)"
                            @change="updateCartItem(item.quantity,item)"
                        />
                    </td>
                    <td>{{item.product.price | currency}}</td>
                    <td>{{itemTotal(item) | currency}}</td>
                    <td class="text-center"><i class="fas fa-trash" @click="deleteCartItem(index,item.id)"></i></td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th></th>
                    <th>{{$t('store.cart.total')}}</th>
                    <th></th>
                    <th></th>
                    <th>{{ total | currency}}</th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<script>
    import cartHelper from './mixins/store';
    import alertBox from '../BaseComponent/AlertComponent';
    import numberInput from '../BaseComponent/InputNumberComponent'
    export default {
        mixins: [cartHelper],
        props: ['cartItems'],
        components: {alertBox,numberInput},
        data() {
            return {
                name: '1',
                items: {},
            }
        },
        created() {
            this.items = this.cartItems;
        },
        computed: {
            total: function () {
                let total = 0;
                return this.items.reduce((total, p) => {
                    return total + p.product.price * Math.abs(Math.ceil(p.quantity))
                }, total)
            },
        },
        methods: {
            updateCartItem(q=1, item) {
                if(typeof q !== 'number'|| isNaN(q) || q<1) q=1;
                item.quantity=q;
                this.updateItemQuantity(q, item.id)
            },
            deleteCartItem(index, id) {
                let items = this.items
                let self = this;
                bootbox.setLocale(window._LANG);
                bootbox.confirm("<h5>" + this.$t('store.items.are_you_sure_to_remove') + "</h5>", function (confirmed) {
                    if (confirmed) {
                        items.splice(index, 1);
                        self.deleteItem(id)
                    }
                });
            },
            itemTotal(item){
                return item.product.price* Math.abs(Math.ceil(item.quantity));
            }
        }
    }
</script>
