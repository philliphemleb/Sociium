export default {
    mode: 'history',

    routes: [
        {
            path: '/',
            component: () => import('../pages/LandingPage'),
            name: 'landingPage',
            meta: { hideNavigation: true }
        },
        {
            path: '/register',
            component: () => import('../pages/Auth/RegisterPage'),
            name: 'register',
            meta: { hideNavigation: true }
        },
        {
            path: '/login',
            component: () => import('../pages/Auth/LoginPage'),
            name: 'login',
            meta: { hideNavigation: true }
        },
        {
            path: '/dashboard',
            component: () => import('../pages/DashboardPage'),
            name: 'dashboard',
            meta: { requiresAuth: true }
        },
    ]
}
