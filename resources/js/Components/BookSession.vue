<template>
    <div>
        <div v-if="isBookable"
             class="rounded p-2 m-1 cursor-pointer transition-bg block flex flex-col justify-center items-center"
             :class="backgroundClass" @click="openModal">
            <span class="mb-1">{{ groupSession.session.human_start_time }}</span>
            <span class="text-xs text-center" v-html="tooltip"></span>
        </div>

        <modal v-if="showModal" @click.self="showModal = false">
            <h2 class="text-xl text-center font-semibold leading-none mb-1">{{ group.name }}</h2>
            <h3 class="text-center leading-none mb-4">
                {{ formatDate(group.date, 'dddd Do MMM') }}, {{ groupSession.session.human_start_time }}
            </h3>

            <template v-if="!loading">
                <p class="text-lg mb-2">
                    Please enter your name and phone number below to register for this session.
                </p>

                <p class="text-lg mb-2 font-semibold" v-if="!this.hasSeats && this.hasWeigh">
                    Please note this session is weigh and go only, there are no seats available.
                </p>

                <p class="text-lg mb-2 font-semibold"
                   v-if="this.hasWeigh && this.hasSeats && !groupSession.has_seat_available">
                    All seats at this session are fully booked, you can only book a weigh and go slot.
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

                <p class="my-3" v-if="!groupSession.session.has_weigh_and_go">
                    Anyone attending at group (including children) must book a place online. Please only
                    bring children if absolutely necessary as spaces are taken from members to accommodate them.
                </p>

                <template v-if="this.hasSeats && this.hasWeigh">
                    <p class="my-3 font-semibold">
                        Are you stopping at group and need a seat, or are you weighing and leaving?
                    </p>

                    <p class="my-3">
                        Anyone stopping at group (including children) must be booked into a seat. Please only bring
                        children if absolutely necessary as spaces are taken from members to accommodate them.
                    </p>

                    <p class="my-3">
                        Where ever possible please always stop to group, it's where you get the best support and
                        motivation from me and your fellow members, but we know that sometimes you can't always stop at
                        group, and now with us having limited places that it can be even more difficult, especially if
                        there's only one session that works for you, so if you can't stop at group today, please let us
                        know, and then that lets someone else book a seat who can stop at group.
                    </p>

                    <div class="mb-3 flex flex-col">
                        <div class="flex cursor-pointer" @click="selectSeat()">
                            <div class="p-1 mr-1">
                                <div class="border rounded-sm h-5 w-5 flex justify-center items-center"
                                     :class="fields.requires_seat === true ? 'border-sw-green text-sw-green' : 'border-grey-off-dark'">
                                    <font-awesome-icon :icon="['fas', 'check']"
                                                       v-if="this.fields.requires_seat === true"></font-awesome-icon>
                                </div>
                            </div>
                            <div class="p-1">
                                <p :class="!groupSession.has_seat_available ? 'text-grey-off-dark line-through' : ''">
                                    I am stopping to group and need a seat.
                                </p>
                            </div>
                        </div>

                        <div class="flex cursor-pointer" @click="selectWeighAndGo()">
                            <div class="p-1 mr-1">
                                <div class="border rounded-sm h-5 w-5 flex justify-center items-center"
                                     :class="fields.requires_seat === false ? 'border-sw-green text-sw-green' : 'border-grey-off-dark'">
                                    <font-awesome-icon :icon="['fas', 'check']"
                                                       v-if="fields.requires_seat === false"></font-awesome-icon>
                                </div>
                            </div>
                            <div class="p-1">
                                <p>I can't stop today so I am weighing and have to leave early.</p>
                            </div>
                        </div>

                        <span class="text-sw-red font-semibold mt-2 text-sm" v-if="errors.requires_seat">
                            Please select an option
                        </span>
                    </div>
                </template>

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
            requires_seat: null,
        },

        errors: {
            sessionFull: false,
            conflict: false,
            sameday: false,
            name: false,
            email: false,
            phone: false,
            validEmail: false,
            requires_seat: false,
        }
    }),

    mounted() {
        if (!this.hasSeats && this.hasWeigh) {
            this.fields.requires_seat = false;
        }

        if (this.hasSeats && !this.hasWeigh) {
            this.fields.requires_seat = true;
        }
    },

    methods: {
        formatDate(date, format = 'Do MMM') {
            return moment(date).format(format);
        },

        openModal() {
            if (this.isFullyBooked) {
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

            app().request().post(`${this.group.slug}/${this.groupSession.id}`, this.fields).then((response) => {
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
        },

        selectSeat() {
            if (!this.hasSeats || !this.groupSession.has_seat_available) {
                app().error('Sorry, this session has no seats available');
                return;
            }

            if (this.fields.requires_seat === true) {
                this.fields.requires_seat = null;
                return;
            }

            this.fields.requires_seat = true;
        },

        selectWeighAndGo() {
            if (!this.hasWeigh || this.has_weigh_available) {
                app().error('Sorry, this seat has no weigh and go spaces available...');
                return;
            }

            if (this.fields.requires_seat === false) {
                this.fields.requires_seat = null;
                return;
            }

            this.fields.requires_seat = false;
        }
    },

    computed: {
        hasSeats: function () {
            return this.groupSession.session.has_seats;
        },

        hasWeigh: function () {
            return this.groupSession.session.has_weigh_and_go;
        },

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
            if (this.isFullyBooked) {
                return ['bg-sw-red', 'hover:bg-sw-red-80'];
            }

            if (!this.hasSeats && this.hasWeigh) {
                return ['bg-sw-purple', 'hover:bg-sw-purple-80', 'text-white'];
            }

            if (this.isLowCapacity) {
                return ['bg-sw-blue', 'hover:bg-sw-blue-80'];
            }

            return ['bg-sw-green', 'hover:bg-sw-green-80'];
        },

        isFullyBooked: function () {
            if (this.hasSeats && this.hasWeigh) {
                return !this.groupSession.has_seat_available && !this.groupSession.has_weigh_available
            }

            if (this.hasSeats && !this.hasWeigh) {
                return !this.groupSession.has_seat_available
            }

            if (!this.hasSeats && this.hasWeigh) {
                return !this.groupSession.has_weigh_available
            }
        },

        isLowCapacity: function () {
            if (this.hasWeigh && this.groupSession.session.weigh_and_go_only && this.groupSession.weigh_slots_taken >= this.groupSession.session.weigh_capacity_threshold) {
                return true;
            }

            if (this.hasSeats && this.groupSession.seats_taken >= this.groupSession.session.seats_threshold) {
                return true;
            }

            return false;
        },

        tooltip: function () {
            if (this.isFullyBooked) {
                return 'Fully Booked';
            }

            if (!this.hasSeats && this.hasWeigh) {
                return `Weigh and Go only, ${this.remainingWeighSlots} spaces available`;
            }

            if (this.hasSeats && this.hasWeigh) {
                return `${this.remainingSeats} seats available,<br/>${this.remainingWeighSlots} weigh and go spaces available`;
            }

            return `${this.remainingSeats} seats available.`;
        },

        remainingSeats: function () {
            return this.groupSession.session.seats - this.groupSession.seats_taken;
        },

        remainingWeighSlots: function () {
            return this.groupSession.session.weigh_and_go_slots - this.groupSession.weigh_slots_taken;
        }
    },
}
</script>
