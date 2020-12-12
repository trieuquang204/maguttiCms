<template>
    <div class="btn-group mb-2">
        <button type="button" class="btn btn-info">
            <slot name="label"></slot>
            <input type="checkbox" class="checkbox-inline" v-model="allSelected" @change="setStatus"/>
        </button>
        <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            <span class="sr-only">Toggle</span>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <drop-down-item :status="true"  @action="actionSelect">Select All</drop-down-item>
            <drop-down-item :status="false" @action="actionSelect">Deselect All</drop-down-item>
        </div>
    </div>
</template>
<script>
    import dropDownItem from './DropDownItemComponent'
    export default {
        components: {dropDownItem},
        props: ['allSelected'],
        methods: {
            setStatus() {
                this.actionSelect(this.allSelected)
            },
            actionSelect(status) {
                this.$emit('actionForParent',status)
            }
        }
    }
</script>
