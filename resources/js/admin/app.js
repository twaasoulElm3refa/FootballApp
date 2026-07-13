import { createApp } from 'vue';
import { createPinia } from 'pinia';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import router from './router';

const app = createApp({
    template: '<router-view></router-view>'
});

app.use(createPinia());
app.use(router);
app.use(Toast, {
    position: 'top-right',
    timeout: 3500,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
});

app.mount('#app');
