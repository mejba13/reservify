import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import '../css/app.css'

// Create Vue app instance
const app = createApp(App)

// Configure plugins
app.use(createPinia())
app.use(router)

// Mount app
app.mount('#app')
