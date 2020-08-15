<template>
    <div class="bg-black-80 fixed top-0 left-0 w-screen h-screen flex justify-center items-center"
         @click.self="close()">
        <div class="w-11/12 max-w-modal bg-sw-green rounded-lg p-1">
            <div class="bg-grey-lightest p-2 flex flex-col rounded relative">
                <div v-if="closeable"
                     class="absolute pt-2 pr-2 top-0 right-0 text-black-50 hover:text-black transition-colour text-sm cursor-pointer"
                     @click="close()">
                    <font-awesome-icon :icon="['fas', 'times']"></font-awesome-icon>
                </div>

                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        closeable: {
            type: Boolean,
            default: false,
        }
    },

    methods: {
        close() {
            if (!this.closeable) {
                return;
            }

            this.$root.$emit('close-modal');
        }
    }
}
</script>
