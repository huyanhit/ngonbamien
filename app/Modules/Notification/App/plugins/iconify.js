
import { Icon } from '@iconify/vue';
import 'remixicon/fonts/remixicon.css';
import 'boxicons/css/boxicons.css';
import '@mdi/font/css/materialdesignicons.css';
export default {
    install: (app) => {
        app.component('Icon', Icon);
    },
};
