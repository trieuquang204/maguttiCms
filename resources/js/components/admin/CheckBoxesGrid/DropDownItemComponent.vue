<template>
    <a class="dropdown-item" href="#" @click.prevent="action"><slot>Select Item</slot></a>
</template>
<script>
    export default {
        props: ['status'],
        methods: {
            action(e) {
               this.$emit('action',this.status)
            }
        }
    }
</script>
