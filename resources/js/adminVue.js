window.Vue = require('vue');
Vue.component('pagination', require('laravel-vue-pagination'));
import IncredibleOffers from './components/IncredibleOffers'
import axios from 'axios';
import VueAxsio from 'vue-axios';
Vue.use(VueAxsio,axios);
Vue.prototype.$siteUrl='http://localhost:8000/';
const app = new Vue({
    el: '#app',
    components: {
        IncredibleOffers
    }
});