<template>
    <div id="home">
        <h1>{{ count }}</h1>
        <button @click="count++">INCREMENT</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            count: 0
        }
    }
}
</script>

<style scoped>

</style>
