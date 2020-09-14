import Vue from "vue";
import BookSession from "./Components/BookSession";
import Accordion from "./Components/Accordion";
import Modal from "./Components/Modal";
import MemberLookup from "./Components/MemberLookup";
import CancelSession from "./Components/CancelSession";
import GroupSessions from "./Components/GroupSessions";

Vue.component('accordion', Accordion);
Vue.component('cancel-session', CancelSession);
Vue.component('group-sessions', GroupSessions);
Vue.component('member-lookup', MemberLookup);
Vue.component('modal', Modal);
