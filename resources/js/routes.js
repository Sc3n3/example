import Home from './components/Home.vue';
import SignIn from './components/User/SignIn.vue';
import SignUp from './components/User/SignUp.vue';
import Dashboard from './components/Dashboard/Dashboard.vue';

export default [{
    name: 'home',
    path: '/',
    component: Home
}, {
    name: 'dashboard',
    path: '/dashboard',
    component: Dashboard,
    meta: {
        auth: true
    }
}, {
    name: 'register',
    path: '/register',
    component: SignUp
}, {
    name: 'login',
    path: '/login',
    component: SignIn
}];