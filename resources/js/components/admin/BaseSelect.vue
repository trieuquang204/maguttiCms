<template>
    <div class="form-group col-12 col-sm-12  ">
        <p>{{label}}</p>
        <select class="form-control"
                @change="select"
                @input="$emit('update:selected-option', $event.target.value)">
            <option selected="true">Select template</option>
            <option v-for="option in options"
                    :selected="option.id === selectedOption ? 'selected' : ''"
                    :value="option.id">{{ option.title }}</option>
        </select>

    </div>
</template>
<script>
    export default {
        props: {
            label: String,
            cssInput: String,
            options: Array,
            selectedOption:[String, Number]
        },
        data() {
            return {
                selected: null
            }
        },
        methods: {
            select: function (e) {
                this.selected = this.options[e.target.selectedIndex - 1].id;
                console.log(this.selected)
                this.$emit('update:selected-option', this.selected);
            }
        }

    }
</script>
