import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './axios'
//import axios from 'axios'
//import VueAxios from 'vue-axios';
import "bootstrap/dist/css/bootstrap.min.css"
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import "bootstrap"




createApp(App)
.use(router)
//.use(VueAxios, axios)
.mount('#app')