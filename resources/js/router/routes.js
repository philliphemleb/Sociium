export default {
    mode: 'history',

    routes: [
        {
            path: '/',
            component: () => import('../pages/LandingPage'),
            name: 'LandingPage',
        },
        {
            path: '/register',
            component: () => import('../pages/Auth/RegisterPage'),
            name: 'Register',
        },
        {
            path: '/login',
            component: () => import('../pages/Auth/LoginPage'),
            name: 'Login',
        },
    ]
}
