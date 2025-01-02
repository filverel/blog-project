import { createApp } from 'vue'
import App from './App.vue'
import './assets/app.css'
import router from './router'
import axios from 'axios'

axios.defaults.baseURL = 'http://blog-project.test'

createApp(App)
  .use(router)
  .mount('#app')
