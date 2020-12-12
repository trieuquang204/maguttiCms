<template>
        <button @click="show = !show" class="btn " :class="[!show ? activeClass : 'btn-danger']">
            <span v-if="show">x</span>
            <span v-if="!show">v</span>
        </button>
</template>

<script>
    export default {
        data() {
            return {
                name:'',
                show:false,
                activeClass: 'btn-success'
            }
        },
        mounted() {

        }
    }
</script>
