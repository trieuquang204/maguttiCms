<template>
    <div class="dropdown-item" >
        <div class="shopping-cart-item">
            <img :src="item.product.thumb_image">
            <div class="shopping-cart-item-body">
                <b>{{item.product.code}} - {{item.product.title}}</b>
                <div>Qt:{{item.quantity}}</div>
                <div>{{$t('store.cart.table.price')}}: {{item.product.price | currency}}</div>
                <i class="fas fa-trash shopping-cart-delete"
                   @click.prevent.stop="deleteHandler"></i>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['item','index'],
        methods: {
            deleteHandler: function() {
                this.$emit('delete-item')
            }
        }
    }
</script>
