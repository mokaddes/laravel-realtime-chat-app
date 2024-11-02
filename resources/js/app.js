import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router'; // Import Vue Router

// Import components
import Chat from './components/Chat.vue';

// Define your routes
const routes = [
    { path: '/chat/:userId', name: 'chat', component: Chat, props: true } // Chat route with dynamic userId
];

// Create the router instance
const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Create and mount the app
const app = createApp({});

// Register components
app.component('chat-component', Chat);

// Use the router
app.use(router);

// Mount the app to the DOM
app.mount('#app');
