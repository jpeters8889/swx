<template>
    <div v-if="Object.keys(dates).length">
        <div v-for="timestamp in Object.keys(dates)" :key="timestamp" v-if="dates[timestamp].length">
            <div class="flex flex-col border border-sw-red">
                <div class="bg-sw-red text-lg p-2 font-semibold text-white">
                    <h2>{{ formatDateFromUnix(timestamp) }}</h2>
                </div>

                <div class="flex flex-wrap m-1 leading-none">
                    <template v-for="groupSession in dates[timestamp]">
                        <book-session :group="group" :group-session="groupSession"
                                      v-if="isBookable(groupSession.date, groupSession.session.start_at)"/>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as moment from 'moment';
import BookSession from "./BookSession";

export default {
    components: {
        'book-session': BookSession,
    },

    props: {
        groupId: {
            required: true,
            type: Number,
        },
        today: {
            type: String,
            required: true,
        },
        now: {
            type: Number,
            required: true,
        },
    },

    data: () => ({
        group: {},
        dates: {},
        announcement: null,
    }),

    mounted() {
        app().request().get(`/group-sessions/${this.groupId}`).then((response) => {
            this.group = response.data.group;
            this.announcement = response.data.announcement;
            this.dates = response.data.dates;
        });
    },

    methods: {
        formatDate(date, format = 'Do MMM') {
            return moment(date).format(format);
        },

        formatDateFromUnix(timestamp, format = 'dddd Do MMMM') {
            return moment.unix(timestamp).format(format);
        },

        isBookable(date, sessionStart) {
            if (this.today !== this.formatDate(date)) {
                return true;
            }

            if (this.formatDate('01-01-2020 ' + sessionStart, 'Hmm') > this.now) {
                return true
            }

            return false;
        }
    },
}
</script>
