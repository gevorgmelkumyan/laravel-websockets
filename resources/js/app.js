import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';
import Home from './views/Home.vue';
import vuetify from "./plugins/vuetify.js";
import Login from "./views/Login.vue";

const routes = [
    { path: '/', component: Home },
    { path: '/login', component: Login },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

createApp(App).use(vuetify).use(router).mount('#app');
