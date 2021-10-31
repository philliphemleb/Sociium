export default {
    mode: 'history',

    routes: [
        {
            path: '/',
            component: () => import('../pages/Home'),
            name: 'Home',
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
