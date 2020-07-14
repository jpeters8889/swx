import Vue from 'vue';
import Application from "./Application";
import './Plugins';

Vue.config.productionTip = false;

import './components';

window.app = function (config) {
    return new Application(config);
}

app().build();
