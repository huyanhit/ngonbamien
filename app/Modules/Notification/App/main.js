import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import i18n from './plugins/i18n'
import mitt from 'mitt'
import axios from 'axios'
import VueAxios from 'vue-axios'
import filters from './helpers/filter'
import BootstrapVueNext from 'bootstrap-vue-next'
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css'

const app      = createApp(App)
const pinia    = createPinia();
const emitter  = mitt();

app.use(BootstrapVueNext)
app.use(pinia)
app.use(i18n)
app.use(VueAxios, axios)

app.config.globalProperties.event   = emitter;
app.config.globalProperties.filters = filters;

app.mount('#notification')
