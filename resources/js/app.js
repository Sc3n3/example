/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue').default;

import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import VueMoment from 'vue-moment';
import VueGoogleMap from 'vuejs-google-maps';
import VueToast from 'vue-toast-notification';

import 'vue-toast-notification/dist/theme-default.css';
import 'vuejs-google-maps/dist/vuejs-google-maps.css';

import App from './components/App.vue';
import routes from './routes.js';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

//const files = require.context('./', true, /\.vue$/i)
//files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.use(VueRouter);
Vue.use(VueMoment);
Vue.use(VueAxios, window.axios);
Vue.use(VueToast, {
    position: 'top-right'
});
Vue.use(VueGoogleMap, {
    load: {
        apiKey: process.env.MIX_GOOGLE_API_KEY,
        libraries: ['places', 'visualization']
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
    data: {
        ui: { name: process.env.MIX_APP_NAME, loading: false },
        auth: { user: null, token: null }
    },
    methods: {
        setAccessToken(token){
            this.auth.token = token;

            token ? window.localStorage.setItem('token', token)
                  : window.localStorage.removeItem('token');
        },
        getStoredAccessToken(){
            return window.localStorage.getItem('token');
        },
        getAccessToken(){
            return this.auth.token;
        },
        setUser(user){
            this.auth.user = user;
            !user && this.setAccessToken(null);
        },
        getUser(){
            return this.user;
        },
        logout(){
            this.setUser(null);
            this.$router.push({name: 'login'});
        },
        async fetchUser(){
            const response = await this.axios.get('/api/user/me');
            return response.data;
        },
        async refreshToken(){
            const response = await this.axios.post('/api/user/refresh');
            return response.data.access_token;
        },
        async getAccessTokenUser(){
            return this.fetchUser().then((user) => {
                this.setUser(user);
                return user;
            }).catch((err) => {
                this.setUser(null);
                return err;
            });
        },
    },
    beforeCreate(){
        this.$router.beforeEach((to, from, next) => {
            if (to.matched.some(route => route.meta.auth)) {
                if (!this.auth.user) {
                    return next({name: 'login'});
                }
            }
            return next();
        });

        this.axios.interceptors.request.use((request) => {
            if (this.auth.token) {
                request.headers['Authorization'] = 'Bearer '+ this.auth.token;
            }
            this.ui.loading = true;
            return request;
        });

        this.axios.interceptors.response.use((response) => {
            this.ui.loading = false;
            return response;
        }, (err) => {
            if (err.response.status === 401) {
                if (!err.config.url.includes('user/refresh') && !err.config.retryRequest) {
                    err.config.retryRequest = true;
                    return this.refreshToken().then((token) => {
                        this.setAccessToken(token);
                        return this.axios(err.config);
                    }).catch((err) => {
                        this.$toast.warning('You need to sign in to view the page.');
                        this.$router.push({name: 'login'});
                        return err;
                    });
                } else if (err.config.url.includes('user/refresh') && err.config.retryRequest) {
                    this.logout();
                }
            } else if (err.response.status === 422) {
                const message = [
                    err.response.data.message +"\n",
                    ...Object.values(err.response.data.errors).map((error) => {
                        return error.join("\n");
                    })
                ];

                this.$toast.error(message.join("\n"));
            }
            this.ui.loading = false;
            return Promise.reject(err);
        });
    },
    created(){
        this.setAccessToken(this.getStoredAccessToken());
        this.getAccessTokenUser();
    }
});
