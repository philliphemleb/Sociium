<template>
    <div id="home">
        <notification-component></notification-component>
        <h1>{{ count }}</h1>
        <button @click="count++">INCREMENT</button>
    </div>
</template>

<script>
import NotificationComponent from "./layout/notification/NotificationComponent";
export default {
    components: {NotificationComponent},
    data() {
        return {
            count: 0
        }
    }
}
</script>

<style scoped>

</style>
