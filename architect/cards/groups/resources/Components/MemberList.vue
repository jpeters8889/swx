<template>
    <table class="my-2 w-full bg-white overflow-hidden rounded-b-lg">
        <tr class="p-1 font-semibold text-blue-700 bg-blue-200">
            <th class="text-left p-1 border-r border-blue-400">Name</th>
            <th class="text-left p-1 border-r border-blue-400">Email Address</th>
            <th class="text-left p-1">Phone Number</th>
        </tr>
        <tr v-for="booking in bookings" class="p-1 border-t border-blue-400">
            <td class="capitalize p-1 border-r border-blue-400">
                {{ booking.member.name }}
            </td>
            <td class="p-1 border-r border-blue-200">{{ booking.member.email }}</td>
            <td class="p-1">{{ booking.member.phone }}</td>
        </tr>
    </table>
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
    }),

    mounted() {
        Architect.request().get(`/external/groups/bookings/${this.groupSessionId}`).then((response) => {
            this.bookings = response.data;
        })
    }
}
</script>
