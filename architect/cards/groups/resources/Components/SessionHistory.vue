<template>
    <div v-if="loaded">
        <div>
            <h2 class="text-xl font-semibold text-center mb-2">
                {{ groupName }}, {{ session.day.day }}, {{ session.human_start_time }} - {{ session.human_end_time }}
            </h2>

            <table class="w-full">
                <thead>
                <tr class="bg-blue-500 text-white font-semibold border-b-2 border-white">
                    <th class="text-left w-10/12 p-2 border-r border-white">Date</th>
                    <th class="text-left p-2">Members</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="group in session.group_sessions" class="border-b-2 border-blue-500"
                    :class="group.type === 'past' ? 'bg-red-500' : group.type === 'future' ? 'bg-green-500' : ''">
                    <td class="p-2 border-r border-blue-500">{{ formatDate(group.date) }}</td>
                    <td class="p-2 text-right" @click="viewMemberList(group.id, group.bookings_count)">
                        {{ group.bookings_count }}/{{ session.capacity }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <portal to="secondary-modal" v-if="showBookings">
            <modal title="Member List" id="inner-member-list">
                <div class="w-full bg-gray-100 p-2">
                    <p>
                        <a :href="'/admin/api/external/groups/printBookings/'+groupSessionId" target="_blank">
                            Printer Friendly List
                        </a>
                    </p>

                    <groups-member-list :group-session-id="groupSessionId"></groups-member-list>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
export default {
    props: {
        groupName: {
            type: String,
            required: true,
        },
        sessionId: {
            type: Number,
            required: true,
        }
    },

    data: () => ({
        loaded: false,
        session: {},

        showBookings: false,
        groupSessionId: 0,
    }),

    mounted() {
        Architect.$on('modal-close', (modal) => {
            if (modal.id === 'inner-member-list') {
                this.showBookings = false;
            }
        })

        Architect.request().get(`/external/groups/session/${this.sessionId}`).then((response) => {
            this.session = response.data;
            this.loaded = true;
        });
    },

    methods: {
        formatDate(date, format = 'Do MMMM YYYY') {
            return moment(date).format(format);
        },

        viewMemberList(groupSessionId, count) {
            if (count === 0) {
                return;
            }

            this.groupSessionId = groupSessionId;
            this.showBookings = true;
        },
    }
}
</script>
