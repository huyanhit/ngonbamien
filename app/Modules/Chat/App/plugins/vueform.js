import Multiselect from "@vueform/multiselect";
import Slider from "@vueform/slider";

import "@vueform/multiselect/themes/default.css";
import "@vueform/slider/themes/default.css";

export default {
    install: (app) => {
        app.component('Multiselect', Multiselect);
        app.component('Slider', Slider);
    },
};
