<template>
    <div class="flex bg-white shadow-lg rounded-lg overflow-hidden mt-1 w-full" v-show="visible">
        <div class="w-2 bg-red-400"></div>
        <div class="flex items-center px-2 py-3">
            <div class="mx-3">
                <h2 class="text-xl font-semibold text-red-400">Error</h2>
                <p class="text-gray-600">Oh No! An error has occurred!</p>
            </div>
        </div>
        <div class="absolute right-0 mr-3 text-2xl cursor-pointer hover:text-red-400" @click="changeVisibility">
            &times;
        </div>
    </div>
</template>

<script>
export default {
    name: "NotificationComponent",

    data() {
        return {visible: true}
    },
    methods: {
        changeVisibility: function ()
        {
            this.visible = false;
        }
    }
}
</script>

<style scoped>

</style>
