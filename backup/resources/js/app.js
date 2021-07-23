require('./bootstrap');
require('./custom/custom');



window.Vue = require('vue');



Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('favorite-component', require('./components/FavoriteJobComponent.vue').default);

Vue.component('add-review-component', require('./components/AddReviewComponent.vue').default);

Vue.component('exam-component', require('./components/Exam/ExamComponent.vue').default);

Vue.component('personality-component', require('./components/Exam/PersonalityComponent.vue').default);

Vue.component('aptitude-component', require('./components/Exam/AptitudeComponent.vue').default);

Vue.component('filter-component', require('./components/Chart/FilterComponent.vue').default);

Vue.component('chart-component', require('./components/Chart/ChartComponent.vue').default);



export const bus = new Vue();



const app = new Vue({

    el: '#app'

});