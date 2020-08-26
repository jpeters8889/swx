<template>
    <div>
        <div class="text-blue-700 font-semibold cursor-pointer hover:text-black transition-colour"
             @click="showDetail = true">
            {{ bookingCount }}
        </div>

        <portal to="modal" v-if="showDetail">
            <modal title="Members Bookings">
                <div class="w-full bg-gray-100 p-2">
                    <ul v-if="bookings.length > 0">
                        <li v-for="booking in bookings">
                            {{ booking.group_session.group.name }}, {{ formatDate(booking.group_session.date) }}
                            {{ booking.group_session.session.human_start_time }}
                        </li>
                    </ul>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
export default {
    props: ['id'],

    data: () => ({
        bookingCount: 0,
        showDetail: false,
        bookings: [],
    }),

    mounted() {
        this.getCount();

        Architect.$on('modal-close', () => {
            this.showDetail = false;
        });
    },

    methods: {
        getCount() {
            Architect.request().get(`/external/members/bookingsCount/${this.id}`).then((response) => {
                this.bookingCount = response.data.bookings;
            });
        },

        formatDate(date, format = 'Do MMMM YYYY') {
            return moment(date).format(format);
        },
    },

    watch: {
        id: function () {
            Architect.request().get(`/external/members/bookingsCount/${this.id}`).then((response) => {
                this.bookingCount = response.data.bookings;
            });
        },

        showDetail: function () {
            Architect.request().get(`/external/members/bookings/${this.id}`).then((response) => {
                this.bookings = response.data.bookings;
                console.log(this.bookings);
            });
        }
    }
}
</script>
