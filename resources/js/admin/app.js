import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router';
import AppLayout from './layouts/AdminLayout.vue';

const app = createApp({
    template: '<router-view></router-view>'
});

app.use(createPinia());
app.use(router);

app.mount('#app');
