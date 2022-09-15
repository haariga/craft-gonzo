// Import our CSS
import '@/css/app.pcss';
import { createApp } from 'vue';
import router from '../vue/router';
import GonzoPatternLibrary from '../vue/App.vue';
import { createPinia } from 'pinia';

const appContainer = document.querySelector('#app-container');

const app = createApp(GonzoPatternLibrary, {
  components: JSON.parse(appContainer.dataset.components),
  activeComponent: JSON.parse(appContainer.dataset.activecomponent ?? '{}'),
});

app.use(router);
app.use(createPinia());

app.mount('#app-container');
