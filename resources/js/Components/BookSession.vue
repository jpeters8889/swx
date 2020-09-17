<template>
    <div class="flex">
        <div v-if="isBookable"
             class="rounded p-2 m-1 cursor-pointer transition-bg block flex flex-col justify-center items-center"
             :class="backgroundClass" @click="openModal">
            <span class="mb-1">{{ groupSession.session.human_start_time }}</span>
            <span class="text-xs text-center" v-html="tooltip"></span>
        </div>

        <modal v-if="showModal" @click.self="showModal = false">
            <h2 class="text-xl text-center font-semibold leading-none mb-1">{{ group.name }}</h2>
            <h3 class="text-center leading-none mb-4">
                {{ formatDate(group.date, 'dddd Do MMM') }},
                {{ groupSession.session.human_start_time }} - {{ groupSession.session.human_end_time }}
            </h3>

            <template v-if="!loading">
                <p class="text-lg text-sw-red text-center mb-2 font-semibold" v-if="groupSession.session.weigh_only">
                    This session is a short weigh and go session, there will be no normal group activities.
                </p>

                <p class="text-lg text-center mb-2">
                    Please enter your name and phone number below to register for this session.
                </p>

                <p class="text-lg text-center mb-2 text-sw-red font-semibold"
                   v-if="failed && !errors.sessionFull && !errors.conflict && !errors.sameday">
                    Sorry, there was a problem booking you onto this session, please try again or select another
                    session...
                </p>

                <p class="text-lg text-center mb-2 text-sw-red font-semibold" v-if="errors.sessionFull">
                    Sorry, this session is full, please choose another one.
                </p>

                <p class="text-lg text-center mb-2 text-sw-red font-semibold" v-if="errors.conflict">
                    Sorry, you're already booked on this session!
                </p>

                <template v-if="errors.sameday">
                    <p class="text-lg text-center text-sw-red font-semibold mb-2">
                        Sorry, you're already booked onto a session on the same day as this one!
                    </p>
                    <p class="text-lg text-center text-sw-blue font-semibold mb-2 hover:underline">
                        <a href="/lookup">
                            Can't remember what you're booked on? Click here to enter your email and find out!
                        </a>
                    </p>
                </template>

                <div class="my-3">
                    <input type="text" v-model="fields.name" placeholder="Your name..."
                           class="border border-grey p-2 rounded w-98" @keyup.enter="submitBooking()"/>

                    <span class="text-sw-red font-semibold mt-1 text-sm" v-if="errors.name">
                        Please enter your name.
                    </span>
                </div>

                <div class="my-3">
                    <input type="email" v-model="fields.email" placeholder="Your email address..."
                           class="border border-grey p-2 rounded w-98" @keyup.enter="submitBooking()"/>

                    <span class="text-sw-red font-semibold mt-1 text-sm" v-if="errors.email">
                        Please enter your email.
                    </span>

                    <span class="text-sw-red font-semibold mt-1 text-sm" v-if="errors.validEmail">
                        Please enter a valid email address.
                    </span>
                </div>

                <div class="my-3">
                    <input v-model="fields.phone" type="tel" placeholder="Your phone number..."
                           class="border border-grey p-2 rounded w-98" @keyup.enter="submitBooking()"/>

                    <span class="text-sw-red font-semibold mt-1 text-sm" v-if="errors.phone">
                        Please enter your phone number.
                    </span>
                </div>

                <p class="mb-3" v-if="!groupSession.session.weigh_only">
                    Anyone attending group (Including children) must book onto a session. Please only bring
                    children if absolutely necessary as spaces are taken from members to accommodate them.
                </p>

                <div class="flex justify-between leading-none text-xl">
                    <a class="bg-sw-red rounded p-2 text-semibold text-white" :href="'/'+group.slug">
                        Cancel
                    </a>

                    <button class="bg-sw-green rounded p-2 text-semibold text-white" @click.prevent="submitBooking()">
                        Confirm
                    </button>
                </div>

                <p v-if="announcement" class="mt-3 text-center font-semibold" v-text="announcement.announcement"></p>
            </template>

            <template v-if="loading">
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
import * as moment from 'moment';

export default {
    props: {
        announcement: {
            required: false,
        },
        group: {
            required: true,
            type: Object,
        },
        groupSession: {
            required: true,
            type: Object,
        },
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
            sameday: false,
            name: false,
            email: false,
            phone: false,
            validEmail: false,
        }
    }),

    methods: {
        formatDate(date, format = 'Do MMM') {
            return moment(date).format(format);
        },

        openModal() {
            if (this.groupSession.bookings_count === this.groupSession.session.capacity) {
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

            app().request().post(`${this.group.slug}/${this.groupSession.id}`, this.fields).then(() => {
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
            if (this.today !== this.formatDate(this.group.date)) {
                return true;
            }

            if (this.formatDate('01-01-2020 ' + this.groupSession.session.session_start, 'Hmm') > this.now) {
                return true
            }

            return false;
        },

        backgroundClass: function () {
            if (this.groupSession.bookings_count === this.groupSession.session.capacity) {
                return ['bg-sw-red', 'hover:bg-sw-red-80'];
            }

            if (this.groupSession.session.weigh_only) {
                return ['bg-sw-purple', 'hover:bg-sw-purple-80', 'text-white'];
            }

            if (this.groupSession.bookings_count >= this.groupSession.session.capacity_threshold) {
                return ['bg-sw-blue', 'hover:bg-sw-blue-80'];
            }

            return ['bg-sw-green', 'hover:bg-sw-green-80'];
        },

        tooltip: function () {
            if (this.groupSession.bookings_count === this.groupSession.session.capacity) {
                return 'Fully Booked';
            }

            let prefix = '';

            if (this.groupSession.session.weigh_only) {
                prefix = '(Weigh Only Session)<br/><br/>'
            }

            if (this.groupSession.bookings_count >= this.groupSession.session.capacity_threshold) {
                return `${prefix}Low Availability<br/>(${this.remainingSlots} spaces available)`;
            }

            return `${prefix}Good Availability<br/>(${this.remainingSlots} spaces available)`;
        },

        remainingSlots: function () {
            return this.groupSession.session.capacity - this.groupSession.bookings_count;
        }
    }
}
</script>
