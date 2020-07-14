import Vue from 'vue';
import Toasted from 'vue-toasted';
import request from "./Utilities/RequestHandler";

Vue.use(Toasted, {
    position: "bottom-right",
    duration: 6000,
});

export default class Application {

    constructor(config) {
        this.vue = new Vue();
        this.config = config;
        this.afterBootCallbacks = [];
    }

    onBoot(callback) {
        this.afterBootCallbacks.push(callback);
    }

    build() {
        this.afterBoot();

        Vue.use(Toasted);

        this.app = new Vue({
            el: '#app',
            mounted: () => {
                //
            }
        });
    }

    afterBoot() {
        this.afterBootCallbacks.forEach((callback) => {
            callback(Vue);
        });

        this.afterBootCallbacks = [];
    }

    request() {
        return request;
    }

    $on(event, callback) {
        this.vue.$on(event, callback);
    }

    $emit(event,...args) {
        this.vue.$emit(event,...args)
    }

    success(message) {
        Vue.toasted.show(message, {type: 'success'});
    }

    error(message) {
        Vue.toasted.show(message, {type: 'error'});
    }
}
