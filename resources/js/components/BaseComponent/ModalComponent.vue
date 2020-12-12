<template>
    <transition>
        <div class="vue-modal-backdrop" v-show="show" @click.stop.prevent="dismiss">
            <div class="vue-modal">
                <div class="vue-modal-header">
                    <h5 class="vue-modal-header-caption">
                        <slot name="modal-header">Modal Header</slot>
                    </h5>
                </div>
                <div class="vue-modal-body">
                    <slot name="modal-body"></slot>
                </div>
                <div class="text-right vue-modal-footer">
                    <slot name="modal-footer" :closeModal="dismiss">
                        <button @click="dismiss" type="button" class="btn btn-primary btn-block">
                            Close
                        </button>
                    </slot>
                </div>
                <i class="fas fa-times fa-1x vue-modal-close" @click="dismiss"></i>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        props: {
            show: { required: true },
                preventBackgroundScrolling: { default: true }
        },
        data() {
            return {
                item: {},
            }
        },
        created() {
            const escapeHandler = e => {
                if (e.key === "Escape" && this.show) {
                    this.dismiss()
                }
            }
            document.addEventListener("keydown", escapeHandler)
            this.$once("hook:destroyed", () => {
                document.removeEventListener("keydown", escapeHandler)
            })
        },
        watch: {
            show: {
                immediate: true,
                handler: function(show) {
                    if (show) {
                        this.preventBackgroundScrolling &&
                        document.body.style.setProperty("overflow", "hidden")
                    } else {
                        this.preventBackgroundScrolling &&
                        document.body.style.removeProperty("overflow")
                    }
                }
            }
        },
        methods: {
            dismiss() {
                this.$emit("close")
            },
        }
    }
</script>
<style>
    .vue-modal-backdrop {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow: auto;
        padding: 2rem;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 20000;
    }

    .vue-modal {
        position: relative;
        margin-left: auto;
        margin-right: auto;
        width: 25rem;
        max-width: 95%;
        margin-top: 0rem;
        background-color: #fff;
        border-radius: 0.15rem;
        padding: 1rem 1.5rem;
        -webkit-box-shadow: 0 15px 30px 0 rgba(0, 0, 0, 0.11),
        0 5px 15px 0 rgba(0, 0, 0, 0.08);
        box-shadow: 0 15px 30px 0 rgba(0, 0, 0, 0.11),
        0 5px 15px 0 rgba(0, 0, 0, 0.08);

    }
    .vue-modal-close {
        position: absolute;
        top: 8px;
        right: 10px
    }

    .vue-modal-header {
        padding: 0 0 0.3rem 0;
        margin: 0;
        border-bottom: 1px solid #465366;
    }

    .vue-modal-body {
    }

    .vue-modal-footer {
    }

</style>

