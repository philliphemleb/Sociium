<template>
    <div class="app">
        <NavigationComponent></NavigationComponent>
        <notification-container-component v-if=notifications.length>
            <notification-component v-for="notification in notifications" :key="notification.message" :type="notification.type">
                {{ notification.message }}
            </notification-component>
        </notification-container-component>
        <router-view></router-view>
    </div>
</template>

<script>
import NotificationComponent from "./components/layout/notification/NotificationComponent";
import NotificationContainerComponent from "./components/layout/notification/NotificationContainerComponent";
export default {
    name: "App",

    components: {
        NotificationContainerComponent,
        NotificationComponent,
        NavigationComponent: () => import('./components/layout/NavigationComponent')
    },

    data() {
        return {
            notifications: []
        }
    },

    methods: {
        renderNotifications()
        {
            this.notifications = this.$store.state.notification.notifications ?? [];
        }
    },

    mounted() {
        this.renderNotifications();
    }
}
</script>

<style scoped>

</style>
