export default {
    mode: 'history',

    routes: [
        {
            path: '/',
            component: () => import('../components/Home'),
            name: 'Home'
        }
    ]
}
