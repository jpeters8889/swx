<template>
    <ul class="my-2">
        <li v-for="member in members">
            {{ member.name }}
            <template v-if="member.phone">
                - {{ member.phone }}
            </template>
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
