<template>
    <div>
        <div>
            <div class="flex flex-col">
                <div v-for="group in groups" class="bg-blue-100 p-2 rounded my-2">
                    <h3 class="text-xl text-gray-900 mb-2 font-semibold">{{ group.name }}</h3>

                    <div v-for="(groupSessions, date) in group.processedGroups">
                        <h4 class="text-gray-700 font-semibold text-lg">
                            {{ formatDate(date) }}
                        </h4>

                        <div class="flex flex-col lg:flex-row lg:justify-between lg:-mx-2 lg:flex-wrap">
                            <div v-for="groupSession in groupSessions"
                                 class="p-2 lg:w-1/2">
                                <div class="bg-gray-100 rounded p-2 flex justify-between">
                                    <div class="flex flex-col mb-2">
                                        <strong class="font-semibold">Time</strong>
                                        {{ groupSession.session.human_start_time }} - {{
                                            groupSession.session.human_end_time
                                        }}
                                    </div>
                                    <div class="flex flex-col mb-2 text-right">
                                        <strong class="font-semibold">Bookings</strong>
                                        <a class="font-semibold text-blue-500 hover:underline cursor-pointer"
                                           v-tooltip="'View List'"
                                           @click="viewBookings(groupSession, group.name)">
                                            {{ groupSession.bookings_count }}/{{ groupSession.session.capacity }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="text-gray-700 font-semibold text-lg mt-4">View Session History</h4>

                    <ul class="my-2">
                        <li v-for="session in group.sessions" class="cursor-pointer hover:underline font-semibold"
                            @click="viewSessionHistory(session.id, group.name)">
                            {{ session.day.day }}'s, {{ session.human_start_time }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <portal to="modal" v-if="showMemberModal">
            <modal title="Member List" id="member-list">
                <div class="w-full bg-gray-100 p-2">
                    <p class="font-semibold text-lg">
                        Member List for {{ viewedName }}, {{ formatDate(viewedSession.date) }} - {{
                            viewedSession.session.human_start_time
                        }}
                    </p>

                    <p>
                        <a :href="'/admin/api/external/groups/printBookings/'+viewedSession.id" target="_blank">Printer
                            Friendly List</a>
                    </p>

                    <groups-member-list :group-session-id="viewedSession.id"></groups-member-list>
                </div>
            </modal>
        </portal>

        <portal to="modal" v-if="showSessionDetail">
            <modal title="Session History" id="session-history">
                <div class="w-full bg-gray-100 p-2">
                    <div class="absolute top-0 right-0 p-1 leading-none text-xl cursor-pointer"
                         @click="showSessionDetail = false">
                        <font-awesome-icon :icon="['fas', 'times']"></font-awesome-icon>
                    </div>

                    <session-history :group-name="viewedName" :session-id="sessionId"></session-history>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
import SessionHistory from "./SessionHistory";

export default {
    components: {SessionHistory},

    props: {
        data: Object | Array,
        labels: Object | Array,
    },

    data: () => ({
        groups: [],

        viewedSession: null,
        viewedName: null,
        showMemberModal: false,

        showSessionDetail: false,
        sessionId: null,
    }),

    mounted() {
        Architect.$on('modal-close', (modal) => {
            if (modal.id === 'member-list') {
                this.showMemberModal = false;
            }

            if (modal.id === 'session-history') {
                this.showSessionDetail = false;
            }
        });

        Architect.request().get('/external/groups/list').then((response) => {
            this.groups = response.data;

            this.groups.map((group) => {
                let processedGroups = {};

                group.group_sessions.forEach((groupSession) => {
                    if (!Object.keys(processedGroups).includes(groupSession.date)) {
                        this.$set(processedGroups, groupSession.date, []);
                    }

                    processedGroups[groupSession.date].push(groupSession);
                });

                Object.keys(processedGroups).forEach((key) => {
                    processedGroups[key] = processedGroups[key].sort((a, b) => parseInt(a.session.start_at.split(':')[0]) - parseInt(b.session.start_at.split(':')[0]))
                });

                group.processedGroups = processedGroups;
            });
        });
    },

    methods: {
        formatDate(date, format = 'Do MMMM YYYY') {
            return moment(date).format(format);
        },

        viewBookings(groupSession, name) {
            if (groupSession.members_count === 0) {
                return;
            }

            this.viewedName = name;
            this.viewedSession = groupSession;
            this.showMemberModal = true;
        },

        viewSessionHistory(id, name) {
            this.viewedName = name
            this.sessionId = id;
            this.showSessionDetail = true;
        }
    }
}
</script>
