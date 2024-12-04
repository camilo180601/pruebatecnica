import { createApp } from 'vue';
import './style.css';
import App from './App.vue';
import axios from 'axios';

// Configura Axios como una propiedad global
axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.headers.common['Origin'] = 'http://localhost:5173';

// Crea la aplicación Vue
const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.mount('#app');