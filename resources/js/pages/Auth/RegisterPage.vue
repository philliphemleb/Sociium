<template>
    <div id="register">
        <form class="w-full shadow rounded-lg bg-white px-6 lg:w-1/2 grid grid-cols-12 gap-2 m-auto border-b-2 border-yellow-400" @submit.prevent>
            <h2 class="text-2xl my-4 col-span-12 text-center">{{ $t('auth.register') }}</h2>

            <div class="bg-red-50 border-l-8 border-red-400 mb-2 col-span-6 col-start-4" v-if="errors.length">
                <div class="p-2 grid grid-cols-12 flex items-center">
                    <div class="sm:pl-4 col-span-11">
                        <li class="text-md font-bold text-red-500 text-sm" v-for="error in errors">{{ error }}</li>
                    </div>
                    <div class="col-span-1 hidden sm:block">
                        <div class="mr-1 text-red-400 text-2xl">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-row col-span-6 col-start-4">
                <span class="z-highest rounded-l-lg w-10 h-10 flex justify-center items-center text-2xl text-gray-900 border border-r-0">
                    <i class="far fa-envelope"></i>
                </span>
                <input v-model="email_address" :placeholder="$t('auth.email')" class="border border-gray-200 rounded-r-lg outline-none focus:ring-1 ring-yellow-400 w-full pl-1">
            </div>
            <div class="flex flex-row col-span-6 col-start-4">
                <span class="z-highest rounded-l-lg w-10 h-10 flex justify-center items-center text-2xl text-gray-900 border border-r-0">
                    <i class="far fa-user"></i>
                </span>
                <input v-model="first_name" :placeholder="$t('auth.first_name')" class="border border-gray-200 rounded-r-lg outline-none focus:ring-1 ring-yellow-400 w-full pl-1">
            </div>
            <div class="flex flex-row col-span-6 col-start-4">
                <span class="z-highest rounded-l-lg w-10 h-10 flex justify-center items-center text-2xl text-gray-900 border border-r-0">
                    <i class="far fa-user"></i>
                </span>
                <input v-model="last_name" :placeholder="$t('auth.last_name')" class="border border-gray-200 rounded-r-lg outline-none focus:ring-1 ring-yellow-400 w-full pl-1">
            </div>

            <div class="flex flex-row col-span-6 col-start-4">
                <span class="z-highest rounded-l-lg w-10 h-10 flex justify-center items-center text-2xl text-gray-900 border border-r-0">
                    <i class="fas fa-key"></i>
                </span>
                <input type="password" v-model="password" :placeholder="$t('auth.password')" class="h-10 border border-gray-200 rounded-r-lg outline-none focus:ring-1 ring-yellow-400 w-full pl-1">
            </div>
            <div class="flex flex-row col-span-6 col-start-4">
                <span class="z-highest rounded-l-lg w-10 h-10 flex justify-center items-center text-2xl text-gray-900 border border-r-0">
                    <i class="fas fa-key"></i>
                </span>
                <input type="password" v-model="password_confirmation" :placeholder="$t('auth.password_confirmation')" class="h-10 border border-gray-200 rounded-r-lg outline-none focus:ring-1 ring-yellow-400 w-full pl-1">
            </div>
            <button value="button" class="px-4 py-2 rounded bg-green-400 text-white hover:bg-green-900 my-4 col-span-6 col-start-4" @click="submit">{{ $t('auth.register') }}</button>

        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            token: null,
            email_address: '',
            first_name: '',
            last_name: '',
            password: '',
            password_confirmation: '',
            errors: [],
        }
    },
    methods: {
        submit() {
            this.errors = [];

            if (this.email_address && this.first_name && this.last_name && this.password && this.password_confirmation) {

                axios.post(route('api.register', {
                    token: this.token,
                    email: this.email_address,
                    first_name: this.first_name,
                    last_name: this.last_name,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                }))
                .then((response) => {
                    this.$store.commit('notification/addNotification', {type: 'success', message: this.$i18n.t("auth.register_successful")});
                    this.$router.push({name: 'Login'});
                })
                .catch((error) => {
                    const errorsFromResponse = error.response.data.errors;

                    for (const [key, value] of Object.entries(errorsFromResponse)) {
                        this.errors.push(this.$i18n.t(`${value}`));
                    }
                });
            }

            if (!this.email_address) {
                this.errors.push( this.$i18n.t("auth.email_required") );
            }
            if (!this.first_name) {
                this.errors.push( this.$i18n.t("auth.first_name_required") );
            }
            if (!this.last_name) {
                this.errors.push( this.$i18n.t("auth.last_name_required") );
            }
            if (!this.password) {
                this.errors.push( this.$i18n.t("auth.password_required") );
            }
            if (!this.password_confirmation) {
                this.errors.push( this.$i18n.t("auth.password_confirmation_required") );
            }
        },
    },
    mounted() {
        this.token = document.querySelector('meta[name="csrf-token"]').content;
    }
}
</script>

<style scoped>

</style>
