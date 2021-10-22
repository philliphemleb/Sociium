<template>
    <section>
        <nav class="relative px-4 py-4 flex justify-between items-center bg-gray-900 text-gray-100 border-b-2 border-yellow-400">
            <a class="text-3xl font-bold font-heading text-decoration-none hover:text-yellow-400" href="#">
                <!-- <img class="h-9" src="logo.png" alt="logo"> -->
                Logo Here.
            </a>
            <div class="lg:hidden">
                <button class="navbar-burger flex items-center p-3">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
            </div>
            <ul class="hidden absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2 lg:flex lg:mx-auto lg:flex lg:items-center lg:w-auto lg:space-x-6">
                <li><a class="text-sm hover:text-yellow-400 font-bold text-decoration-none" href="#">Home</a></li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-4 h-4 current-fill" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </li>
                <li><a class="text-sm hover:text-yellow-400 font-bold text-decoration-none" :href="route('twitter_index')">Dashboard</a></li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-4 h-4 current-fill" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </li>
                <li><a class="text-sm hover:text-yellow-400 font-bold text-decoration-none" href="#">About Us</a></li>
            </ul>
            <section class="text-2xl">
                <button class="hover:text-yellow-400" @click=""> <i class="far fa-user-circle mx-1"></i> </button>
            </section>
        </nav>

        <transition enter-active-class="transition ease-out duration-100"
                    enter-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95">
            <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5" v-show="">
                <a href="#" class="block px-4 py-2 text-sm text-gray-900 hover:bg-yellow-200 hover:text-gray-900 text-decoration-none">Your Profile</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-900 hover:bg-yellow-200 hover:text-gray-900 text-decoration-none">Settings</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-900 hover:bg-yellow-200 hover:text-gray-900 text-decoration-none">Sign out</a>
            </div>
        </transition>
    </section>
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
