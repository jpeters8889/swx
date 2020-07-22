<template>
    <ul class="my-2 border-t border-blue-200">
        <li class="p-2 border-b border-blue-200 font-semibold text-blue-700 bg-blue-200">
            Name - Phone Number
        </li>
        <li v-for="member in members" class="p-2 border-b border-blue-200">
            <span class="capitalize">{{ member.name }}</span> - {{ member.phone }}
        </li>
    </ul>
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
            members: [],
        }),

        mounted() {
            window.Architect.request().get(`/external/groups/members/${this.groupSessionId}`).then((response) => {
                this.members = response.data;
            })
        }
    }
</script>
