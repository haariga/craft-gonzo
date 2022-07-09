// Import our CSS
import '@/css/app.pcss';
import { createApp } from 'vue';
import router from '../vue/router';
import GonzoPatternLibrary from '../vue/App.vue';
import { createPinia } from "pinia";

const app = createApp(GonzoPatternLibrary);

app.use(router);
app.use(createPinia());

app.mount('#app-container');
