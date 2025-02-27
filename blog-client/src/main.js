import { createApp } from 'vue'
import App from './App.vue'
import './assets/app.css'
import router from './router'
import store from './store'
import axios from 'axios'

axios.defaults.baseURL = 'http://blog-project.test'
axios.defaults.withCredentials = true
axios.defaults.withXSRFToken = true

store.dispatch('authenticate').then(() => {
  createApp(App)
    .use(router)
    .use(store)
    .mount('#app')
})

