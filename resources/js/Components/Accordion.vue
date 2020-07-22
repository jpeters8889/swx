<template>
    <div class="border border-sw-red">
        <div @click="show = !show" class="cursor-pointer p-2 bg-sw-red text-white text-semibold">
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
