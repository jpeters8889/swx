import Vue from "vue";
import BookSession from "./Components/BookSession";
import Accordion from "./Components/Accordion";
import Modal from "./Components/Modal";
import MemberLookup from "./Components/MemberLookup";
import CancelSession from "./Components/CancelSession";

Vue.component('accordion', Accordion);
Vue.component('book-session', BookSession);
Vue.component('cancel-session', CancelSession);
Vue.component('member-lookup', MemberLookup);
Vue.component('modal', Modal);
