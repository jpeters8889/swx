<template>
    <div>
        <div class="p-4 flex flex-col text-white font-semibold text-center sm:items-center cursor-pointer" @click="viewModal = true">
            Click here to view and manage your previous bookings.
        </div>

        <modal closeable v-if="viewModal">
            <template v-if="!loading && !done">
                <p>
                    To view and manage your previous bookings enter your email address below and we'll email you a link
                    to view your bookings.
                </p>

                <div class="my-3">
                    <input type="email" v-model="email" placeholder="Your email address..."
                           class="border border-grey p-2 rounded w-98"/>

                    <span class="text-sw-red font-semibold mt-1 text-sm" v-if="errors.email">
                                Please enter your email.
                            </span>

                    <span class="text-sw-red font-semibold mt-1 text-sm" v-if="errors.validEmail">
                                Please enter a valid email address.
                            </span>
                </div>

                <div class="flex justify-between leading-none text-xl">
                    <a class="bg-sw-red rounded p-2 text-semibold text-white" @click="close()">
                        Cancel
                    </a>

                    <button class="bg-sw-green rounded p-2 text-semibold text-white" @click.prevent="submitLookup()">
                        Submit
                    </button>
                </div>
            </template>

            <template v-if="done && !loading">
                <p>Thanks, please check your email to manage your bookings.</p>

                <div class="flex justify-center leading-none text-xl">
                    <a class="bg-sw-green rounded p-2 text-semibold text-white" @click="close()">
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
        </modal>
    </div>
</template>

<script>
export default {
    data: () => ({
        viewModal: false,

        loading: false,
        done: false,

        email: '',

        errors: {
            email: false,
            validEmail: false,
        }
    }),

    mounted() {
        this.$root.$on('close-modal', () => {
            this.close();
        })
    },

    methods: {
        close() {
            this.loading = false;
            this.done = false;
            this.email = '';
            this.viewModal = false;
        },

        submitLookup() {
            Object.keys(this.errors).forEach((key) => {
                this.errors[key] = false;
            })

            this.loading = true;

            app().request().post('/lookup', {email: this.email}).then((response) => {
                this.done = true;
            }).catch((response) => {
                Object.keys(response.data.errors).forEach((key) => {
                    this.errors[key] = true;
                });

                if (response.data.errors.email && response.data.errors.email[0] === 'validation.email') {
                    this.errors.email = false;
                    this.errors.validEmail = true;
                }

                this.failed = true;
            }).finally(() => {
                this.loading = false;
            })
        }
    }
}
</script>
