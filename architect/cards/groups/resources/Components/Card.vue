<template>
    <div>
        <div class="flex flex-col">
            <div v-for="group in groups" class="bg-blue-100 p-2 rounded my-2">
                <h3 class="text-xl text-gray-900 mb-2 font-semibold">{{ group.name }}</h3>
                <h4 class="text-gray-700 font-semibold text-lg">Sessions</h4>

                <div class="flex flex-col lg:flex-row lg:justify-between lg:-mx-2">
                    <div v-for="session in group.sessions" class="bg-gray-100 rounded p-2 my-2 lg:w-1/2 lg:mx-2">
                        <div class="flex justify-between">
                            <div class="flex flex-col mb-2">
                                <strong class="font-semibold">Day</strong>
                                {{ session.day.day }}
                            </div>
                            <div class="flex flex-col mb-2">
                                <strong class="font-semibold">Time</strong>
                                {{ session.human_start_time }} - {{ session.human_end_time }}
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <strong class="font-semibold">Upcoming Session</strong>
                            <a class="font-semibold text-blue-500 hover:underline cursor-pointer" v-tooltip="'View List'">
                                {{ session.upcoming_session_member_count }}/{{ session.capacity }}
                            </a>
                        </div>
                        <div class="flex flex-col mt-2">
                            <a class="bg-blue-500 p-2 rounded text-white font-semibold text-center cursor-pointer transition-colour hover:bg-blue-400">
                                Manage Session
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            data: Object | Array,
            labels: Object | Array,
        },

        data: () => ({
            groups: [],
        }),

        mounted() {
            window.Architect.request().get('/external/groups/list').then((response) => {
                this.groups = response.data;
            })
        }
    }
</script>
