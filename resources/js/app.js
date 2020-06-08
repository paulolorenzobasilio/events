import Vue from 'vue'
import Calendar from './components/Calendar';
import Card from './components/Card';

[
    Calendar,
    Card
].forEach(Component => {
    Vue.component(Component.name, Component)
})

const app = new Vue({
    el: '#app'
});