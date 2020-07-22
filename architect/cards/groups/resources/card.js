import Card from "./Components/Card";
import MemberList from "./Components/MemberList";
import SessionHistory from "./Components/SessionHistory";

Architect.onBoot((Vue) => {
   Vue.component('groups-card', Card);
   Vue.component('groups-member-list', MemberList);
   Vue.component('group-session-history', SessionHistory);
});
