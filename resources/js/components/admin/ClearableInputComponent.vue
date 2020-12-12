<template>
    <div>
        <div class="input-group mb-3">
            <input type="text" onkeyup="" class="form-control" v-model="message" v-bind:name="name">
            <div class="input-group-append">
                <clear-btn @reset="clearInput" class="input-group-text"></clear-btn>
            </div>
        </div>
    </div>
</template>
<script>
    import clearBtn from './partial/ClearInputBtnComponent';
    export default {
        components: {clearBtn},
        data() {
            return {
                message:'',
            }
        },
        props: ['name','input_text'],
        methods: {
            clearInput: function () {
                this.message='';
            }
        },
        mounted() {
            this.message=this.input_text;
        },

    }
</script>
