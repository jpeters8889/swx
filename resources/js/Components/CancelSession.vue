<template>
    <div>
        <div class="p-2 bg-sw-red text-white font-semibold cursor-pointer text-lg" @click="showModal = true">
            Cancel
        </div>

        <modal v-if="showModal">
            <div class="flex flex-col">
                <template v-if="!loading && !done">
                    <p class="text-lg text-center mb-2">Are you sure you want to cancel this booking?</p>

                    <div class="flex flex-col justify-center leading-none text-xl">
                        <a class="bg-sw-green rounded p-2 mb-2 text-semibold text-white cursor-pointer text-center"
                           @click="showModal = false">
                            No
                        </a>

                        <button class="bg-sw-red rounded p-2 text-semibold text-white text-center" @click.prevent="cancelBooking()">
                            Yes, cancel my booking.
                        </button>
                    </div>
                </template>

                <template v-if="done && !loading">
                    <p>
                        Your booking is now cancelled.
                    </p>

                    <div class="flex justify-center leading-none text-xl">
                        <a class="bg-sw-green rounded p-2 text-semibold text-white cursor-pointer"
                           @click="reload()">
                            Close
                        </a>
                    </div>
                </template>

                <template v-if="loading && !done">
                    <div class="flex justify-center items-center">
                        <div class="m-4 text-6xl">
                            <font-awesome-icon :icon="['fas', 'spinner']" spin></font-awesome-icon>
                        </div>
                    </div>
                </template>
            </div>
        </modal>
    </div>
</template>

<script>
export default {
    props: {
        id: {
            type: Number,
            required: true,
        },
        token: {
            type: String,
            required: true,
        }
    },

    data: () => ({
        showModal: false,
        loading: false,
        done: false,
    }),

    methods: {
        cancelBooking() {
            this.loading = true;

            app().request().delete(`/lookup/${this.token}/${this.id}`)
                .then(() => {
                    this.done = true;
                })
                .catch(() => {
                    app().error('There was an error processing your request.');
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        reload() {
            window.location.reload();
        }
    }
}
</script>
