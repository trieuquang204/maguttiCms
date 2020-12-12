<template>
    <div class="input-group mb-3">
        <input type="text" onkeyup="" class="form-control" v-model="message" v-bind:name="name">
        <div class="input-group-append">
            <span class="input-group-text" data-toggle="tooltip"
                  data-placement="left" v-bind:title="label">
                  <i class="fas fa-cogs" @click="updateInput"></i>
            </span>
            <clear-btn @reset="clearInput" class="input-group-text"></clear-btn>
        </div>
    </div>
</template>
<script>
    import {HTTP} from './../../mixins/http-common';
    import helper from '../../mixins/helper';
    import clearBtn from './partial/ClearInputBtnComponent';
    export default {
        components: {clearBtn},
        data() {
            return {
                message: '',
                label: 'Genera',
            }
        },
        props: ['name', 'input_text', 'data'],
        mixins: [helper],
        methods: {
            updateInput: function () {
                var self = this;
                return HTTP.post(this.url(), {
                    value: this.message,
                    data: this.data
                })
                .then(this.refresh)
                .catch(e => {
                    self.errors.push(e)
                    self.showMessage(e.message, self.ERROR_CLASS);
                })
            },
            clearInput: function () {
                this.message='';
            },
            url() {
                return '/admin/api/services/generator';
            },
            refresh({data}) {
                this.message = data.data;
            }
        },
        mounted() {
            this.message = this.input_text;
            this.label =(this.data.label!=undefined)?this.data.label:this.label

        },

    }
</script>
