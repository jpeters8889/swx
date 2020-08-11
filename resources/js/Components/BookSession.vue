<template>
    <div>
        <div v-if="isBookable" class="rounded p-2 m-1 cursor-pointer transition-bg block flex flex-col justify-center items-center"
             :class="backgroundClass" @click="openModal">
            <span class="mb-1"><slot></slot></span>
            <span class="text-xs text-center" v-html="tooltip"></span>
        </div>

        <div v-if="showModal" @click.self="showModal = false"
             class="bg-black-80 fixed top-0 left-0 w-screen h-screen flex justify-center items-center">
            <div class="w-11/12 max-w-modal bg-sw-green rounded-lg p-1">
                <div class="bg-grey-lightest p-2 flex flex-col rounded">
                    <h2 class="text-xl text-center font-semibold leading-none mb-1">{{ groupName }}</h2>
                    <h3 class="text-center leading-none mb-4">
                        {{ groupDate }},
                        <slot></slot>
                    </h3>

                    <template v-if="!loading">
                        <p class="text-lg text-center mb-2">
                                Please enter your name and phone number below to register for this session.
                        </p>

                        <p class="text-lg text-center mb-2 text-sw-red font-semibold" v-if="failed && !errors.sessionFull && !errors.conflict">
                            Sorry, there was a problem booking you onto this session, please try again or select another
                            session...
                        </p>

                        <p class="text-lg text-center mb-2 text-sw-red font-semibold" v-if="errors.sessionFull">
                            Sorry, this session is full, please choose another one.
                        </p>

                        <p class="text-lg text-center mb-2 text-sw-red font-semibold" v-if="errors.conflict">
                            Sorry, you're already booked on this session!
                        </p>

                        <div class="my-3">
                            <input type="text" v-model="fields.name" placeholder="Your name..."
                                   class="border border-grey p-2 rounded w-98"/>

                            <span class="text-sw-red font-semibold mt-1 text-sm" v-if="errors.name">
                                Please enter your name.
                            </span>
                        </div>

                        <div class="my-3">
                            <input type="email" v-model="fields.email" placeholder="Your email address..."
                                   class="border border-grey p-2 rounded w-98"/>

                            <span class="text-sw-red font-semibold mt-1 text-sm" v-if="errors.email">
                                Please enter your email.
                            </span>

                            <span class="text-sw-red font-semibold mt-1 text-sm" v-if="errors.validEmail">
                                Please enter a valid email address.
                            </span>
                        </div>

                        <div class="my-3">
                            <input v-model="fields.phone" type="tel" placeholder="Your phone number..."
                                   class="border border-grey p-2 rounded w-98"/>

                            <span class="text-sw-red font-semibold mt-1 text-sm" v-if="errors.phone">
                                Please enter your phone number.
                            </span>
                        </div>

                        <p class="mb-3">
                            Anyone attending group (Including children) must book onto a session. Please only bring
                            children if absolutely necessary as spaces are taken from members to accommodate them.
                        </p>

                        <div class="flex justify-between leading-none text-xl">
                            <a class="bg-sw-red rounded p-2 text-semibold text-white" :href="'/'+groupSlug">
                                Cancel
                            </a>

                            <button class="bg-sw-green rounded p-2 text-semibold text-white" @click="submitBooking()">
                                Confirm
                            </button>
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
            today: {
                type: String,
                required: true,
            },
            now: {
                type: Number,
                required: true,
            },
            sessionStart: {
                type: Number,
                required: true,
            },
            groupStartAt: {
                type: String,
                required: true,
            },
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
            failed: false,

            fields: {
                name: '',
                email: '',
                phone: '',
            },

            errors: {
                sessionFull: false,
                conflict: false,
                name: false,
                email: false,
                phone: false,
                validEmail: false,
            }
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
                Object.keys(this.errors).forEach((key) => {
                    this.errors[key] = false;
                })

                this.failed = false;
                this.loading = true;

                app().request().post(`${this.groupSlug}/${this.groupSessionId}`, this.fields).then((response) => {
                    window.location.href = '/thanks';
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
        },

        computed: {
            isBookable: function () {
                if(this.today !== this.groupDate) {
                    return true;
                }
                
                if(this.sessionStart > this.now) {
                    return true
                }
                
                return false;
            },
        
            backgroundClass: function () {
                if (this.currentCount === this.capacity) {
                    return ['bg-sw-red', 'hover:bg-sw-red-80'];
                }

                if (this.currentCount >= this.capacityThreshold) {
                    return ['bg-sw-blue', 'hover:bg-sw-blue-80'];
                }

                return ['bg-sw-green', 'hover:bg-sw-green-80'];
            },

            tooltip: function () {
                if (this.currentCount === this.capacity) {
                    return 'Fully Booked';
                }

                if (this.currentCount >= this.capacityThreshold) {
                    return `Low Availability<br/>(${this.remainingSlots} spaces available)`;
                }

                return `Good Availability<br/>(${this.remainingSlots} spaces available)`;
            },

            remainingSlots: function() {
                return this.capacity - this.currentCount;
            }
        }
    }
</script>
