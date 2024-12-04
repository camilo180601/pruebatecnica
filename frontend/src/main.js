import { createApp } from 'vue';
import './style.css';
import App from './App.vue';
import axios from 'axios';

// Crea la aplicación Vue

// Configura Axios como una propiedad global
axios.defaults.baseURL = 'https://api.allorigins.win/raw?url=https://pruebaback.rf.gd';
axios.defaults.headers.common['Origin'] = 'https://fronttest-chi.vercel.app';

const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.mount('#app');