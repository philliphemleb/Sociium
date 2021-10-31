<template>
    <div class="app h-screen grid grid-cols-12 grid-rows-12 bg-gray-100">
        <NavigationComponent v-show="$route.name !== 'LandingPage'" class="col-span-12 row-span-1"></NavigationComponent>
        <side-bar-navigation-component v-show="$route.name !== 'LandingPage'" class="col-span-3 row-span-11"></side-bar-navigation-component>
        <notification-container-component v-show="$route.name !== 'LandingPage'" v-if=notifications.length>
            <notification-component v-for="notification in notifications" :key="notification.message" :type="notification.type" :message="notification.message"></notification-component>
        </notification-container-component>
        <router-view class="col-span-9 row-span-11"></router-view>
    </div>
</template>

<script>
import NotificationComponent from "./components/layout/notification/NotificationComponent";
import NotificationContainerComponent from "./components/layout/notification/NotificationContainerComponent";
import SideBarNavigationComponent from "./components/layout/navigation/SideBarNavigationComponent";
export default {
    name: "App",

    components: {
        SideBarNavigationComponent,
        NotificationContainerComponent,
        NotificationComponent,
        NavigationComponent: () => import('./components/layout/navigation/NavigationComponent')
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
