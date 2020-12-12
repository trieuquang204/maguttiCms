<template>
    <a  class="nav-link dropdown-toggle"
        id="shoppingDropdownMenuLink"
        :data-toggle="(this.isMobile)?'':'dropdown'"
        aria-haspopup="true" aria-expanded="false">
        <i :class="this.icon"></i>
        <span v-show="this.counter"
              class="shopping-cart-count badge badge-danger">{{this.counter}}</span>
    </a>
</template>
<script>
    export default {
        props: ['icon', 'cart_url', 'counter','isMobile'],
    }
</script>
