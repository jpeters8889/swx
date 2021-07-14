<template>
    <div class="border border-sw-green">
        <div @click="show = !show" class="cursor-pointer p-2 bg-sw-green text-white text-semibold text-lg">
            <slot name="title"></slot>
        </div>

        <div v-if="show" class="p-2">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            show: false
        }),
    }
</script>
