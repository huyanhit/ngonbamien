import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './Cbox.vue'
import i18n from '../plugins/i18n'
import mitt from 'mitt'
import axios from 'axios'
import VueAxios from 'vue-axios'
import filters from '../helpers/filter'
import iconify from '../plugins/iconify'
import BootstrapVueNext from 'bootstrap-vue-next'
import bootstrapVue from 'bootstrap-vue-next'
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css'

const app      = createApp(App)
const pinia    = createPinia();
const emitter  = mitt();

app.use(pinia)
app.use(i18n)
app.use(VueAxios, axios)
app.use(BootstrapVueNext)
app.use(bootstrapVue({ plugins: { modalController: true } }))
app.use(iconify)

app.config.globalProperties.event   = emitter;
app.config.globalProperties.filters = filters;

app.mount('#cbox')
