<template>
    <div class="col-xs-12 col-sm-6 col-lg-4">
        <input
            v-model="item.active" :value="item.id"
            :name=" field + '[]'"
            @click="resetSelectAll"
            type="checkbox">
        {{ item.title}}
    </div>
</template>
<script>
    export default {
        props: ['item', 'field'],
        methods: {
            resetSelectAll(e) {
                this.$emit('reset')
            }
        }
    }
</script>
