<template>
    <div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" v-model="message" v-bind:name="name">
            <div class="input-group-append">
                <span class="input-group-text" :class=classErrorObject>{{remainingCount}}</span>
                <clear-btn @reset="clearInput" class="input-group-text"></clear-btn>
            </div>
        </div>
        <div v-if="hasError" class="float-left" :class=classErrorObject >Max length exceeded</div>
    </div>
</template>
<script>
    import counterChars from '../../mixins/chars-counter';
    import clearBtn from './partial/ClearInputBtnComponent';
    export default {
        mixins: [counterChars],
        components: {clearBtn},
        data() {
            return {
                message:'',
            }
        },
        mounted() {
            this.message=this.input_text;
            this.countdown();
        },
    }
</script>
