<template>
    <div class="col-xs-12 bg-light p-3 border rounded">
        <select-all-btn @actionForParent="actionSelect" :allSelected="allSelected">
            <template #label >Select</template>
        </select-all-btn>
        <div class="row">
            <check-box-items v-for="(item, index) in items" :item="item" :key="index" :field="field" @reset="select"/>
        </div>
    </div>
</template>
<script>
    import checkBoxItems from './CheckBoxInputComponent';
    import selectAllBtn  from './SelectAllButtonComponent'
    export default {
        components: {checkBoxItems,selectAllBtn},
        props: ['data', 'field', 'value'],
        data() {
            return {
                items: {},
                selectedItems: [],
                allSelected: false
            }
        },
        mounted() {
            this.selectedItems = this.value;
            this.initSelected();
        },
        methods: {
            selectAll: function () {
                for (let item in this.items) {
                    this.items[item].active = this.allSelected;
                }
            },
            initSelected() {
                let selectedItems = this.value;
                this.items = this.data.map(function (item) {
                    item.active = selectedItems.includes(item.id)
                    return item;
                });
            },
            select: function () {
                this.allSelected = false;
            },
            actionSelect: function (status) {
                this.allSelected = status;
                this.selectAll();
            }
        }
    }
</script>
