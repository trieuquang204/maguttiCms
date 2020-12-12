<template>
    <div class="input-group" >
        <div class="input-group-prepend" @click="decrease" v-if="!hideDecreaseBtn"
             @mousedown="counstinuosDecrement"
             @mouseup="timeoutClear"
             >
            <span class="input-group-text">-</span>
        </div>
        <input type="number"
               :min="min"
               :max="max"
               :step="step"
               v-model.number="quantity"
               @change="change"
               @paste="paste"
               autocomplete="off"
               class="form-control text-center"
               v-on:input="$emit('input', $event.target.value)"
               v-bind:class="{ 'text-danger': isActive }"
        >
        <div class="input-group-append" @click="increase"
             @mouseup="timeoutClear"
             @mousedown="counstinuosIncrement"
             v-if="!hideIncreaseBtn">
            <span class="input-group-text">+</span>
        </div>
    </div>
</template>
<script>
    import _ from 'lodash'

    export default {
        props: {
            max: {
                type: Number,
                default: Infinity,
            },
            min: {
                type: Number,
                default: 1,
            },
            step: {
                type: Number,
                default: 1,
            },
            qty: {
                type: Number,
                default: 1,
            },
            hideDecreaseBtn: {
                type: Boolean,
                default: false,
            },
            hideIncreaseBtn: {
                type: Boolean,
                default: false,
            },

        },
        data() {
            return {
                quantity: {
                    type: Number,
                    default: 1,
                },
                item: {},
                timer:null,
                isActive: false,
            }
        },
        created() {
            this.quantity = this.qty;
            this.notifyUpdate = _.debounce(this.notifyUpdate, 500)
        },
        methods: {
            url() {
                return `${this.baseUrl}cart-item-add`;
            },

            decrease() {
                let {quantity} = this;
                if (isNaN(quantity)) {
                    quantity = this.min;
                }
                quantity -= this.step;
                if(quantity < this.min) quantity= this.min;
                this.quantity = quantity
                this.emitEvent();
            },
            increase() {
                let {quantity} = this;
                if (isNaN(quantity)) {
                    quantity = this.min;
                }
                quantity += this.step;
                this.quantity= quantity;
                this.emitEvent();
            },

            round(value, step) {
                step || (step = 1.0);
                let inv = 1.0 / step;
                //let number = Math.round(value * inv) / inv;
                return Math.round(value * 100) / 100;
            },

           emitEvent(){
                if(this.quantity>=this.max) this.quantity =this.max;
                else this.quantity= this.round(this.quantity,this.step);
                this.$emit('input', this.quantity);
                this.notifyUpdate(this.quantity);
            },
            change(event) {
                this.quantity = Math.min(this.max, Math.max(this.min, event.target.value));
                this.quantity=this.round(this.quantity,this.step)
                this.emitEvent();
            },
            paste(event) {
                this.quantity = Math.min(this.max, Math.max(this.min, event.target.value));
                this.quantity=this.round(this.quantity,this.step)
                this.emitEvent();
            },
            counstinuosIncrement(event) {
                const self = this;
                this.timer = setTimeout(function() {
                    self.increase();
                    self.counstinuosIncrement();
                }, 200);
            },
            counstinuosDecrement(event) {
                const self = this;
                this.timer = setTimeout(function() {
                    self.decrease();
                    self.counstinuosDecrement();
                }, 200);
            },
            timeoutClear(event) {
                clearTimeout(this.timer);
            },
            notifyUpdate()  {
                let msg = `Im fired  every ${this.quantity}`
                console.log(msg );
                this.isActive=!this.isActive;
            }
        }
    }
</script>