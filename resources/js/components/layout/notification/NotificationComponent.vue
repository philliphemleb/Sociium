<template>
    <div class="flex bg-white shadow-lg rounded-lg overflow-hidden w-full mt-2" v-show="visible">
        <div class="w-2"
             v-bind:class="{'text-red-400, bg-red-400': type === 'error', 'text-yellow-400, bg-yellow-400': type === 'warning', 'text-gray-900, bg-gray-900': type === 'info', 'text-green-400, bg-green-400': type === 'success'}"
        ></div>
        <div class="flex items-center px-2 py-3">
            <div class="mx-3">
                <h2 class="text-xl font-semibold animate-pulse hover:animate-none"
                    v-bind:class="{'text-red-400': type === 'error', 'text-yellow-400': type === 'warning', 'text-gray-900': type === 'info', 'text-green-400': type === 'success'}"
                >{{ $t('notification.' + type) }}</h2>
                <p class="text-gray-600">
                    <slot></slot>
                </p>
            </div>
        </div>
        <div class="absolute right-0 mr-3 text-2xl cursor-pointer hover:text-red-400 hover:animate-pulse" @click="changeVisibility">
            &times;
        </div>
    </div>
</template>

<script>
export default {
    name: "NotificationComponent",
    props: {
        type: String
    },

    data() {
        return {
            visible: true
        }
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
