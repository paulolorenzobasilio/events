import Vue from 'vue'
import Calendar from './components/Calendar';
import CalendarDates from './components/CalendarDates';
import Card from './components/Card';

[
    Calendar,
    CalendarDates,
    Card
].forEach(Component => {
    Vue.component(Component.name, Component)
})

const app = new Vue({
    el: '#app'
});