<template>
    <div class="row">
        <dashboard-item v-for="(item, index) in items" :item="item" :key="index"/>
    </div>
</template>

<script>
    import DashboardItem from './DashboardButtonComponent'
    import {HTTP} from '../../mixins/http-common';
    import helper     from '../../mixins/helper';
    export default {
        mixins: [helper],
        components: {
            DashboardItem,
        },
        // Fetches posts when the component is created.
        created() {
            this.fetchData();
        },
        data() {
            return {
                items:null,
            }
        },
        mounted() {

        },methods: {
            fetchData: function () {
                var self = this;
                return HTTP.get(this.url())
                    .then(this.refresh)
                    .catch(e => {
                        self.errors.push(e)
                        self.showMessage(e.message,self.ERROR_CLASS);
                    })
            },
            url() {
              return window._SERVER_PATH+`/admin/api/dashboard`;
            },
            refresh({data}) {
                this.items = data.data
            },

        }
    }
</script>
