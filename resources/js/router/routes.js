export default {
    mode: 'history',

    routes: [
        {
            path: '/',
            component: () => import('../components/Home'),
            name: 'Home',
        },
        {
            path: '/register',
            component: () => import('../components/auth/Register'),
            name: 'Register',
        },
        {
            path: '/login',
            component: () => import('../components/auth/Login'),
            name: 'Login',
        },
    ]
}
