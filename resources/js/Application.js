import Vue from 'vue';
import Toasted from 'vue-toasted';
import VTooltip from 'v-tooltip';
import request from "./Utilities/RequestHandler";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

export default class Application {

    constructor(config) {
        this.vue = new Vue();
        this.config = config;
    }

    build() {
        Vue.component('font-awesome-icon', FontAwesomeIcon);

        Vue.use(Toasted, {
            position: "bottom-right",
            duration: 6000,
        });

        Vue.use(VTooltip);

        this.app = new Vue({
            el: '#app',
            mounted: () => {
                //
            }
        });
    }

    request() {
        return request;
    }

    error(message) {
        Vue.toasted.show(message, {type: 'error'});
    }
}
