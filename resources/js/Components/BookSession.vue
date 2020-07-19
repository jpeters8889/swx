<template>
    <div>
        <div class="rounded p-2 m-1 cursor-pointer transition-bg block" :class="backgroundClass"
             v-tooltip.bottom-start="tooltip" @click="openModal">
            <slot></slot>
        </div>

        <div v-if="showModal" @click.self="showModal = false"
             class="bg-black-80 fixed top-0 left-0 w-screen h-screen flex justify-center items-center">
            <div class="w-11/12 max-w-modal bg-sw-green rounded-lg p-1">
                <div class="bg-grey-lightest p-2 flex flex-col">
                    <h2 class="text-xl text-center text-semibold leading-none mb-1">{{ groupName }}</h2>
                    <h3 class="text-center leading-none mb-4">
                        {{ groupDate }},
                        <slot></slot>
                    </h3>

                    <template v-if="!loading && !booked">
                        <p class="text-lg text-center mb-2">
                            <template v-if="newMember">
                                Please enter your name and phone number below to register for this session, as a new
                                member please make sure you've confirmed with the consultant first.
                            </template>

                            <template v-else>
                                Please enter your name below to register for this session.
                            </template>
                        </p>

                        <p class="text-lg text-center mb-2 text-sw-red font-semibold" v-if="failed">
                            Sorry, there was a problem booking you onto this session, please try again or select another session...
                        </p>

                        <input type="text" v-model="name" placeholder="Your name..." class="border border-grey my-3 p-2 rounded w-98"/>
                        <input v-if="newMember" v-model="phone" type="tel" placeholder="Your phone number..."
                               class="border border-grey my-3 p-2 rounded w-98"/>

                        <div class="flex flex-col-reverse justify-center">
                            <a class="bg-sw-red rounded p-2 text-semibold text-white" :href="'/'+groupSlug">
                                Cancel
                            </a>

                            <button class="bg-sw-green rounded mb-2 p-2 text-semibold text-white" @click="submitBooking()">
                                Confirm
                            </button>
                        </div>
                    </template>

                    <template v-if="booked">
                        <p class="text-lg text-center mb-2">
                            Thank you, you're now booked on this session!
                        </p>

                        <div class="flex flex-col-reverse justify-center">
                            <a class="bg-sw-red rounded p-2 text-semibold text-white" href="/">
                                Close
                            </a>
                        </div>
                    </template>

                    <template v-if="loading">
                        <div class="flex justify-center items-center">
                            <div class="m-4 text-6xl">
                                <font-awesome-icon :icon="['fas', 'spinner']" spin></font-awesome-icon>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            groupSessionId: {
                type: Number,
                required: true,
            },
            groupSlug: {
                type: String,
                required: true,
            },
            groupName: {
                type: String,
                required: true
            },
            groupDate: {
                type: String,
                required: true,
            },
            newMember: {
                type: Boolean,
                required: true,
            },
            capacity: {
                type: Number,
                required: true,
            },
            capacityThreshold: {
                type: Number,
                required: true,
            },
            currentCount: {
                type: Number,
                required: true,
            }
        },

        data: () => ({
            showModal: false,
            loading: false,
            booked: false,
            failed: false,
            name: '',
            phone: null,
        }),

        methods: {
            openModal() {
                if (this.currentCount === this.capacity) {
                    app().error('Sorry, this Session is full, please choose another Session...')
                    return;
                }

                this.showModal = true;
            },

            submitBooking() {
                this.booked = false;
                this.failed = false;
                this.loading = true;

                app().request().post(`${this.groupSlug}/${this.groupSessionId}`, {
                    name: this.name,
                    phone: this.phone,
                }).then((response) => {
                    if (response.status === 200) {
                        this.booked = true;
                        return;
                    }

                    this.failed = true;
                }).catch(() => {
                    this.failed = true;
                }).finally(() => {
                    this.loading = false;
                })
            }
        },

        computed: {
            backgroundClass: function () {
                if (this.currentCount === this.capacity) {
                    return ['bg-sw-red', 'hover:bg-sw-red-80'];
                }

                if (this.newMember) {
                    return ['bg-sw-green', 'hover:bg-sw-green-80'];
                }

                if (this.currentCount >= this.capacityThreshold) {
                    return ['bg-sw-blue-dark', 'hover:bg-sw-blue-dark-80'];
                }

                return ['bg-sw-blue', 'hover:bg-sw-blue-80'];
            },

            tooltip: function () {
                if (this.currentCount === this.capacity) {
                    return 'Sorry, this Session is full';
                }

                if (this.newMember) {
                    return 'New Member Introductory Session';
                }

                if (this.currentCount >= this.capacityThreshold) {
                    return 'This Session is nearly full!';
                }

                return 'Click to book now!';
            }
        }
    }
</script>
