<template>
    <div>
        <span class="input-group-text" id="basic-addon2" >
            Max Chars: {{maxCount}} - <span class="mx-1 inline-block" :class=classErrorObject > Left:  {{remainingCount}}</span>
            <span v-if="hasError" :class=classErrorObject> (Max length exceeded) </span>
            <clear-btn @reset="clearInput"></clear-btn>
        </span>
        <textarea  class="form-control" v-model="message" v-bind:name="name" rows="8"></textarea>
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
