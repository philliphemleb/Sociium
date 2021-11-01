<template>
    <section>
        <nav class="h-full px-4 py-4 flex justify-between items-center bg-gray-900 text-gray-100 border-b-2 border-yellow-400 z-40">
            <router-link :to="{name: 'dashboard'}">
                <a class="text-3xl font-bold font-heading text-decoration-none hover:text-yellow-400" href="#">{{ appName }}</a>
            </router-link>
            <section class="text-2xl">
                <button class="hover:text-yellow-400" @click="changeVisibility"> <i class="far fa-user-circle mx-1"></i> </button>
            </section>
        </nav>

        <transition enter-active-class="transition ease-out duration-100"
                    enter-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95">
            <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 border-l-2 border-yellow-400" v-show="visible">
                <a href="#" class="block px-4 py-2 text-sm text-gray-900 hover:bg-yellow-200 hover:text-gray-900 text-decoration-none">Your Profile</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-900 hover:bg-yellow-200 hover:text-gray-900 text-decoration-none">Settings</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-900 hover:bg-yellow-200 hover:text-gray-900 text-decoration-none">Sign out</a>
            </div>
        </transition>
    </section>
</template>

<script>
export default {
    name: "NavigationComponent",

    data() {
        return{
            appName: process.env.MIX_APP_NAME,
            visible: false
        }
    },
    methods: {
        changeVisibility: function ()
        {
            this.visible = !this.visible;
        }
    }
}
</script>

<style scoped>

</style>
