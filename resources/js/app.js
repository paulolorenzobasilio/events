import Vue from 'vue'
import Calendar from './components/Calendar';
import CalendarDates from './components/CalendarDates';
import CalendarForm from './components/CalendarForm';
import Card from './components/Card';

import mixins from './plugins/mixins';
Vue.use(mixins);

[
    Calendar,
    CalendarDates,
    CalendarForm,
    Card
].forEach(Component => {
    Vue.component(Component.name, Component)
})


const app = new Vue({
    el: '#app',
});