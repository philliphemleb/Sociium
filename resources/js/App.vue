<template>
    <div class="app">
        <NavigationComponent></NavigationComponent>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "App",

    components: {
        NavigationComponent: () => import('./components/layout/NavigationComponent')
    }
}
</script>

<style scoped>

</style>
