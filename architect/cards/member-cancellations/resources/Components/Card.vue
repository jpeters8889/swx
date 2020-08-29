<template>
    <div class="flex flex-col" v-if="Object.keys(cancellation).length > 0">
        <strong class="text-lg">{{ this.cancellation.member.name }}</strong>
        <span class="mb-2">
            {{ this.cancellation.member.email }}
            {{ this.cancellation.member.phone }}
        </span>
        <strong class="text-lg">{{ this.cancellation.group_session.group.name }}</strong>
        <span class="mb-2">
            {{ this.formatDate(this.cancellation.group_session.date) }},
            {{ this.cancellation.group_session.session.human_start_time }}
        </span>
        <span class="italic">
            Cancelled at {{ formatDate(this.cancellation.created_at, 'DD/MM/YY HH:mm')}}
        </span>
    </div>
</template>

<script>
export default {
    props: {
        data: Object | Array,
        labels: Object | Array,
    },

    data: () => ({
        cancellation: {},
    }),

    mounted() {
        Architect.request().get(`/external/cancellation/get/${this.data.id}`).then((response) => {
            this.cancellation = response.data;
        });
    },

    methods: {
        formatDate(date, format = 'Do MMMM YYYY') {
            return moment(date).format(format);
        },
    }
}
</script>
