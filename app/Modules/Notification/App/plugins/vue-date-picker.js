import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

export default {
    install: (app) => {
        app.component('VueDatePicker', VueDatePicker)
    },
};