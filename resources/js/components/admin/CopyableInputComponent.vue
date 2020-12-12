<template>
    <div>
        <div class="input-group">
            <input ref="input"
                   type="text"
                   onkeyup=""
                   :readonly=isReadonly
                   :id="id"
                   :data-list-value="data_list_value"
                   :data-list-name="data_list_name"
                   class="form-control"
                   v-model.trim="message" v-bind:name="name">
            <div class="input-group-append">
                <copy-btn @copy="copyInput" :class="btn_class" class="btn-info " ></copy-btn>
            </div>
        </div>
    </div>
</template>
<script>
    import copyBtn from './partial/CopyInputBtnComponent';

    export default {
        components: {copyBtn},
        data() {
            return {
                message: '',
                isReadonly: false
            }
        },
        props:{
                name:String,
                input_text:String,
                readonly:{
                    type:Boolean,
                    default:false
                },
                btn_class:{
                    type:String,
                    default:'input-group-text',
                },
                id:{
                    type:String,
                    default:null
                },
                data_list_value:{
                    type:String,
                    default:null
                },
                data_list_name:{
                    type:String,
                    default:null
                },

        },
        methods: {
            copyInput: function () {
                let testingCodeToCopy = this.$refs.input
                testingCodeToCopy.setAttribute('type', 'text')
                testingCodeToCopy.select();
                let textCopied = testingCodeToCopy.value;
                try {
                    let successful = document.execCommand('copy');
                    let msg = successful ? 'successful' : 'unsuccessful';
                    let alertMsg = `Text ${textCopied}  was copied  ${msg} `

                    $.notify(alertMsg, 'success');
                } catch (err) {
                    $.notify('Oops, unable to copy');
                }
                /* unselect the range */
                //testingCodeToCopy.setAttribute('type', 'hidden')
                window.getSelection().removeAllRanges()
            }
        },
        mounted() {
            this.$nextTick(function () {
                if (this.readonly != '') {
                    this.isReadonly = this.readonly
                }
                this.message = this.input_text;
            });
        },

    }
</script>
