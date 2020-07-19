<template>
    <div v-if="loaded">
        <div>
            <h2 class="text-xl font-semibold text-center mb-2">
                {{ groupName }}, {{ session.day.day }}, {{ session.human_start_time }} - {{ session.human_end_time}}
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
                    <td class="p-2 text-right" @click="viewMemberList(group.id, group.members_count)">
                        {{ group.members_count }}/{{ session.capacity}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <portal to="modal" v-if="showMembers">
            <modal>
                <div class="absolute top-0 right-0 p-2 cursor-pointer" @click="showMembers = false">
                    <font-awesome-icon :icon="['fas', 'times']"></font-awesome-icon>
                </div>

                <div class="w-full">
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

            showMembers: false,
            groupSessionId: 0,
        }),

        mounted() {
            window.Architect.request().get(`/external/groups/session/${this.sessionId}`).then((response) => {
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
                this.showMembers = true;
            },
        }
    }
</script>
