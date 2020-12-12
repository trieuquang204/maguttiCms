<template>
    <span>
      <side-bar-items v-for="(item, index) in items"  :key="index" :currentSection = currentSection :item="item"></side-bar-items>
    </span>
</template>
<script>
    import SideBarItems from './SideBarItems'
    import {HTTP} from '../../mixins/http-common';
    import helper     from '../../mixins/helper';
    export default {
        mixins: [helper],
        components: {
            SideBarItems,
        },
        // Fetches posts when the component is created.
        created() {
            this.fetchData();
            this.currentSection = this.getCurrentModel();
        },
        data() {
            return {
                items:null,
                currentSection:null
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
               return window._SERVER_PATH+'/admin/api/nav-bar';
            },
            refresh({data}) {
                this.items = data.data
            },
            vai(data) {
                alert(data)
            },
        },
    }
</script>
