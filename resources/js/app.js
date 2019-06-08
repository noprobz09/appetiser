require('./vue-assets');

Vue.component('data-loader', require('./components/LoadDataComponent.vue').default);
Vue.component('passers-lists', require('./components/PassersComponent.vue').default);
Vue.component('add-examinee', require('./components/ExamineeComponent.vue').default);


const app = new Vue({
    el: '#app',
});
