<template>
    <div class="alert">
        <slot name="content"></slot>
    </div>
</template>

<script>
    export default {
        props: ['alertClass'],
    }
</script>
