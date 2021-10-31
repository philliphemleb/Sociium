<template>
    <div class="flex bg-gray-100 shadow-lg rounded-lg overflow-hidden w-full mt-2" v-show="visible">
        <div class="w-2"
             v-bind:class="{'bg-red-400': type === 'error', 'bg-yellow-400': type === 'warning', 'bg-gray-900': type === 'info', 'bg-green-400': type === 'success'}"
        ></div>
        <div class="flex items-center px-2 py-3">
            <div class="mx-3">
                <h2 class="text-xl font-semibold animate-pulse hover:animate-none"
                    v-bind:class="{'text-red-400': type === 'error', 'text-yellow-400': type === 'warning', 'text-gray-900': type === 'info', 'text-green-400': type === 'success'}"
                >{{ $t('notification.' + type) }}</h2>
                <p class="text-gray-600">
                    {{ message }}
                </p>
            </div>
        </div>
        <div class="absolute right-0 mr-3 text-2xl cursor-pointer hover:animate-pulse"
             v-bind:class="{'hover:text-red-400': type === 'error', 'hover:text-yellow-400': type === 'warning', 'hover:text-gray-900': type === 'info', 'hover:text-green-400': type === 'success'}"
             @click="changeVisibility">
            &times;
        </div>
    </div>
</template>

<script>
export default {
    name: "NotificationComponent",
    props: {
        type: String,
        message: String
    },

    data() {
        return {
            visible: true
        }
    },
    methods: {
        changeVisibility: function ()
        {
            this.$store.commit('notification/deleteNotification', this.message);
            this.visible = false;
        }
    }
}
</script>

<style scoped>

</style>
