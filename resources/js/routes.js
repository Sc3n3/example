import Home from './components/Home.vue';
import SignIn from './components/User/SignIn.vue';
import SignUp from './components/User/SignUp.vue';
import Dashboard from './components/Dashboard/Dashboard.vue';
import Form from './components/Dashboard/Form.vue';

export default [{
    name: 'home',
    path: '/',
    component: Home
}, {
    name: 'register',
    path: '/register',
    component: SignUp
}, {
    name: 'login',
    path: '/login',
    component: SignIn
}, {
    name: 'dashboard',
    path: '/dashboard',
    component: Dashboard,
    meta: {
        auth: true
    }
}, {
    name: 'create',
    path: '/create',
    component: Form,
    meta: {
        auth: true
    }
}, {
    name: 'update',
    path: '/edit/:id',
    component: Form,
    meta: {
        auth: true
    }
}];