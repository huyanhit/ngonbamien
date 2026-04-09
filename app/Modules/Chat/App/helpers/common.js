import { getCurrentInstance } from "vue"
import { useCookies } from 'vue3-cookies';
import Swal from 'sweetalert2'
import i18n from '@/plugins/i18n'

export default{
    useEvent:() => getCurrentInstance().appContext.config.globalProperties.event,
    useFilter:() => getCurrentInstance().appContext.config.globalProperties.filter,
    useRoute:() => getCurrentInstance().appContext.config.globalProperties.$router,
    useSocket:() => getCurrentInstance().appContext.config.globalProperties.$socket,
    useCookies:() => useCookies({expire:'7d'}).cookies,
}

export const { showConfirm, showAlert, showToast, parseErrorKey } = {
    showConfirm: (options) =>{
        return Swal.fire({
            title: options.title ?? null,
            text: options.text ?? null,
            icon: options.icon ?? "warning",
            html: options.html ?? null,
            showCancelButton: true,
            color: "#545454",
            confirmButtonColor: '#FB6900',
            cancelButtonColor: '#98a3ad',
            confirmButtonText: options.confirmButtonText ?? i18n.global.t('common.common.sweetalert.confirm_button_text'),
            cancelButtonText: options.cancelButtonText ?? i18n.global.t('common.common.sweetalert.cancel_button_text'),
            allowOutsideClick: false,
            customClass: options.customClass ?? {},
        });
    },
    showAlert: (options)=>{
       return  Swal.fire({
            title: options.title ?? null,
            text: options.text ?? null,
            html: options.html ?? null,
            icon: options.icon ?? 'info',
            iconHtml: options.iconHtml ?? null,
            confirmButtonColor: '#FB6900',
            confirmButtonText: i18n.global.t('common.common.sweetalert.confirm_button_text'),
            showCloseButton: true,
            allowOutsideClick: false
        });
    },
    showToast: (options)=>{
        const Toast= Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: options.confirm?? false,
            timer:  options.timer?? 2000,
            timerProgressBar: options.progress?? true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
        });

        Toast.fire({
            icon: options.icon ?? 'info',
            title: options.title ?? null,
            text: options.text ?? null,
            html: options.html ?? null,
            width: options.width ?? null
        });
    },

    parseErrorKey: (errors) => {
        let parsedData = {};

        for (let key in errors) {
            if (errors.hasOwnProperty(key)) {
                parsedData[key] = [];

                errors[key].forEach(entry => {
                    let parsedEntry = entry.split('#')[0];
                    parsedData[key].push(parsedEntry);
                });
            }
        }

        return parsedData;
    },
}

export const ID_VN =  1423;