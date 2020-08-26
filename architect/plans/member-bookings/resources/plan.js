import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";

Architect.onBoot((Vue) => {
   Vue.component('member-bookings-list', PlanList);
   Vue.component('member-bookings-form', PlanForm);
});
