<template>
    <div class="flex flex-col lg:flex-row h-full">
        <!-- Sidebar with Chat List -->
        <div class="w-full lg:w-1/3 bg-gray-100 dark:bg-gray-800 p-4 border-r border-gray-300 dark:border-gray-700 overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-bold text-lg text-gray-800 dark:text-gray-200">Lists</h2>
                <!-- Back Button -->
                <button
                    @click="goBack"
                    class="text-gray-800 dark:text-gray-200 bg-gray-300 dark:bg-gray-700 p-2 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600 transition duration-300"
                >
                    Back
                </button>
            </div>
            <ul class="space-y-2">
                <router-link
                    v-for="chatUser in chatList"
                    :key="chatUser.id"
                    :to="{ name: 'chat', params: { userId: chatUser.id } }"
                    @click.native="selectChat(chatUser)"
                    class="p-3 rounded-lg transition-colors duration-300 cursor-pointer"
                >
                    <li
                        class="p-3 rounded-lg transition-colors duration-300 cursor-pointer"
                        :class="{
                'bg-indigo-500 text-white': chatUser.id === selectedUser?.id,
                'hover:bg-indigo-400 transition duration-300': chatUser.id !== selectedUser?.id
            }"
                    >
                        {{ chatUser.name }}
                    </li>
                </router-link>
            </ul>

        </div>

        <!-- Chat Window -->
        <div class="flex-1 flex flex-col">
            <div v-if="selectedUser" class="flex flex-col h-full bg-white dark:bg-gray-900 shadow-lg">
                <!-- Chat Header -->
                <div class="p-4 bg-gray-100 dark:bg-gray-800 border-b border-gray-300 dark:border-gray-700">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Chat with {{ selectedUser.name }}</h2>
                </div>

                <!-- Chat Messages -->
                <div class="flex-1 overflow-y-auto p-4 chat-messages bg-gray-50 dark:bg-gray-800">
                    <ul class="space-y-3">
                        <li v-for="(message, index) in messages" :key="index" class="flex">
                            <span :class="{
                                'ml-auto text-right': message.sender_id === auth.id,
                                'mr-auto text-left': message.sender_id !== auth.id
                            }">
                                <strong class="text-indigo-600 dark:text-indigo-400 mr-2">{{ message.sender_id === auth.id ? auth.name : selectedUser.name }}:</strong>
                                <span class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-lg inline-block mt-1">
                                    {{ message.message }}
                                </span>
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- Chat Input -->
                <div class="p-4 border-t border-gray-300 dark:border-gray-700">
                    <form @submit.prevent="sendMessage" class="flex">
                        <input
                            type="text"
                            v-model="newMessage"
                            placeholder="Type a message..."
                            class="flex-1 p-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-white"
                            required
                        />
                        <button
                            type="submit"
                            class="ml-3 px-4 py-2 rounded-lg font-semibold text-white bg-indigo-500 hover:bg-indigo-600 transition ease-in-out duration-300"
                        >
                            Send
                        </button>
                    </form>
                </div>
            </div>
            <div v-else class="text-center text-gray-600 dark:text-gray-300 mt-4">
                Select a chat to start messaging.
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['user', 'auth'],
    data() {
        return {
            chatList: [], // List of all chat users
            messages: [], // Messages with selected user
            newMessage: '', // New message input
            selectedUser: null, // Local state for selected user
        };
    },
    mounted() {
        this.loadChatList();
        this.selectedUser = this.user; // Set the selected user to the user prop

        Echo.private(`chat.${this.auth.id}`)
            .listen('MessageEvent', (event) => {
                if (this.selectedUser && event.sender.id === this.selectedUser.id) {
                    this.messages.push({
                        message: event.message,
                        sender_id: event.sender_id,
                        sender: event.sender,
                        receiver_id: event.receiver_id,
                    });
                }
            });
    },
    watch: {
        selectedUser(newUser) {
            if (newUser) {
                this.loadMessages(); // Load messages whenever the selected user changes
            }
        },
    },
    methods: {
        loadChatList() {
            axios.get('/chat-list').then(response => {
                this.chatList = response.data.users;
            });
        },
        loadMessages() {
            if (this.selectedUser) {
                axios.get(`/chat/${this.selectedUser.id}/messages`).then(response => {
                    this.messages = response.data.chat;
                });
            }
        },
        sendMessage() {
            axios.post('/chat-sent', {
                receiver_id: this.selectedUser.id,
                message: this.newMessage,
            }).then(() => {
                this.messages.push({
                    message: this.newMessage,
                    sender_id: this.auth.id,
                });
                this.newMessage = '';
            });
        },
        selectChat(chatUser) {
            this.selectedUser = chatUser;
        },
        goBack() {
            window.location.href = '/home';
        }
    },

};
</script>
