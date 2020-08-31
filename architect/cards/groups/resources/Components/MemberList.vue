<template>
    <div>
        <div class="flex flex-col">
            <div class="bg-white rounded p-2 flex flex-col mt-2" v-for="booking in bookings" :key="booking.id"
                 @click.exact="toggleDetails(booking.id)">
                <div class="flex">
                    <div class="flex flex-col flex-1">
                        <strong>{{ booking.member.name }}</strong>
                        <span>{{ booking.member.email }}</span>
                    </div>
                    <div
                        class="flex pr-2 justify-center items-start text-2xl font-thin text-gray-200 hover:text-gray-500 transition-colour">
                        <font-awesome-icon
                            :icon="showDetail === booking.id ? ['fas', 'caret-up'] : ['fas', 'caret-down']"></font-awesome-icon>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="flex flex-col border-t border-gray-200 pt-2 text-xs" v-show="showDetail === booking.id">
                        <div>
                            <strong>Phone:</strong> {{ booking.member.phone }}
                        </div>
                        <div>
                            <strong>Session ID:</strong> {{ booking.group_session_id }}
                        </div>
                        <div>
                            <strong>Booking Date:</strong> {{ formatDate(booking.created_at) }}
                        </div>
                        <div v-if="booking.cancelable">
                            <div
                                class="flex-1 py-1 bg-red-500 text-white text-base text-center rounded-lg font-semibold mt-2 slider-bg max-w-98"
                                @click="cancelBooking(booking)">
                                Cancel Booking
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <portal to="secondary-modal" v-if="cancel.show">
            <modal title="Cancel Booking" id="cancel-booking" :closable="false">
                <div class="w-full bg-gray-100 p-2 flex flex-col">
                    <p>Are you sure you want to cancel this booking for {{ cancel.booking.member.name }}?</p>

                    <div class="flex items-center mt-2">
                        <input type="checkbox" id="notify" v-model="cancel.notify" class="mr-1"/>
                        <label for="notify">Notify Member</label>
                    </div>

                    <div class="flex flex-col">
                        <div
                            class="flex-1 py-1 bg-red-500 text-white text-base text-center rounded-lg font-semibold mt-2 slider-bg"
                            @click="confirmCancel()">
                            Cancel Booking
                        </div>

                        <div
                            class="flex-1 py-1 bg-green-500 text-white text-base text-center rounded-lg font-semibold mt-2 slider-bg"
                            @click="dontCancel()">
                            No, don't cancel
                        </div>
                    </div>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
export default {
    props: {
        groupSessionId: {
            type: Number,
            required: true,
        }
    },

    data: () => ({
        bookings: [],
        showDetail: null,

        cancel: {
            show: false,
            booking: null,
            notify: true,
        }
    }),

    mounted() {
        this.getData();
    },

    methods: {
        getData() {
            Architect.request().get(`/external/groups/bookings/${this.groupSessionId}`).then((response) => {
                this.bookings = response.data;
            })
        },

        toggleDetails(id) {
            if (this.showDetail === id) {
                this.showDetail = null;
                return;
            }

            this.showDetail = id;
        },

        formatDate(date, format = 'DD/MM/YY HH:mm') {
            return moment(date).format(format);
        },

        cancelBooking(booking) {
            this.cancel.booking = booking;
            this.cancel.show = true;
        },

        confirmCancel() {
            Architect.request().post(`/external/groups/deleteBooking/${this.cancel.booking.id}`, {
                notifyMember: this.cancel.notify,
            }).then(() => {
                this.dontCancel();
                Architect.success('Booking Cancelled');
                this.getData();
            });
        },

        dontCancel() {
            this.cancel.show = false;
            this.cancel.notify = true;
            this.cancel.booking = null;
        },
    }
}
</script>
