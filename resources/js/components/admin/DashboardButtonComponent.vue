<template>
    <div class="col-12 col-sm-4 col-md-3 col-lg-2">
        <a :href="item.url" :target="item.target ? item.target : null">
            <div class="button">
                <i :class="item.iconClass"></i>
                <h3>{{item.title}}</h3>
            </div>
        </a>
    </div>
</template>

<script>
    export default {
        props: ['item'],
        data() {
            return {
                show: false,
                activeClass: 'btn-success'
            }
        },

        mounted() {}
    }
</script>
