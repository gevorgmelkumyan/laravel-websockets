import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import pusher from 'pusher-js'
import App from './App.vue'
import Home from './views/Home.vue'
import vuetify from "./plugins/vuetify.js"
import Login from "./views/Login.vue"

const routes = [
    { path: '/', component: Home },
    { path: '/login', component: Login },
    { path: '/:pathMatch(.*)*', component: Home },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.path === '/login') {
        next();
    } else {
        if (localStorage.getItem('token')) {
            next();
        } else {
            next('/login');
        }
    }
})

window.Pusher = pusher
window.Pusher.logToConsole = true

createApp(App).use(vuetify).use(router).mount('#app');
