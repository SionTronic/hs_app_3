import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './axios'
import "bootstrap/dist/css/bootstrap.min.css"
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import "bootstrap"
import flatpickr from 'flatpickr';
// Import the "flatpickr" styles
import 'flatpickr/dist/flatpickr.css';




createApp(App)
.use(router)
.use(flatpickr)
//.use(VueAxios, axios)
.mount('#app')