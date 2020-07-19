import Card from "./Components/Card";
import MemberList from "./Components/MemberList";
import ManageSession from "./Components/ManageSession";

Architect.onBoot((Vue) => {
   Vue.component('groups-card', Card);
   Vue.component('groups-member-list', MemberList);
   Vue.component('group-manage-session', ManageSession);
});
