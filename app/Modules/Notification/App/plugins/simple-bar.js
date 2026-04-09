
import simplebar from 'simplebar-vue';
import 'simplebar-vue/dist/simplebar.min.css';

export default {
    install: (app) => {
        app.component('simplebar', simplebar);
    },
};
