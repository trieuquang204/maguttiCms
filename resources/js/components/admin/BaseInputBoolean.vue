<template>
    <div class="form-group col-12 col-sm-6  ">
        <p>{{label}}</p>
        <div class="btn-group">
            <button type="button"
                    class="btn btn-default " :class="{ active: this.content }" @click="toggle(1)">
                {{label_yes}}
            </button>
            <button type="button" class="btn btn-default" @click="toggle(0)" :class="{ active: !this.content }">
                {{label_no}}
            </button>
        </div>
        <input class="form-control"
               :type="type"
               :value="content"
               :placeholder="placeholder"
               @input="$emit('update:content', this.isEnabled)"
        >
    </div>
</template>
<script>
    export default {
        props: {
            label_yes: {
                type: String,
                default: 'YES'
            },
            label_no: {
                type: String,
                default: 'NO'
            },
            label: String,
            placeholder: String,
            cssInput: String,
            content: Number,
            type: String,
        },
        data() {
            return {
                isEnabled: false
            }
        }
        ,
        created() {
            this.isEnabled = this.content;
        },
        methods: {
            toggle: function (value) {
                this.content = value;
                this.isEnabled = this.content;
                this.$emit('update:content', value);
            }
        }
    }
</script>
