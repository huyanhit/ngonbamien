import 'simple-notify/dist/simple-notify.css'
import Notify from 'simple-notify'
import i18n   from '../plugins/i18n'
import audio1 from '../assets/audios/default.mp3'
import audio2 from '../assets/audios/clap.mp3'
import audio3 from '../assets/audios/ting.mp3'
const t = function(val, arg){
    return i18n.global.t('notification.command.'+val, JSON.parse(arg));
}
const showNotificationWindow = function(data, store){
    const notification = new Notification(
        t(data.title, data.extra), {
            body: t(data.text, data.extra),
            icon: data.auth_avatar ?? 'https://ui-avatars.com/api/?name=a'+data.auth_name
        }
    );
    notification.onclick = (event) => {
        event.preventDefault();
        window.open('/' + data.url);
    };
}
const showNotificationCustom = async function(data, store) {
    new Notify({
        status: 'success',
        title: t(data.title, data.extra),
        text: '<a href="/' + data.url + '">' + t(data.text, data.extra).replace('\n', '<br>') + '<a>',
        effect: 'slide', // fade , slide
        speed: 300,
        customClass: 'notification-style',
        customIcon: '<img class="rounded-circle img-fluid " ' + 'src="' + (data.auth_avatar ??
            'https://ui-avatars.com/api/?name=' + data.auth_name) + '">',
        showIcon: true,
        showCloseButton: true,
        autoclose: (parseInt(data.setting.auto_close) !== 0),
        autotimeout: parseInt(data.setting.auto_close),
        gap: 20,
        distance: 20,
        type: 'outline',
        position: data.setting.position
    })

    playSound(data.setting, store);
}

const playSound = function(setting, store) {
    let audio;
    if(!setting.is_mute && !store.muted.includes(setting.command)){
        switch (setting.sound){
            case 'default': audio = new Audio(audio1);
                break;
            case 'clap': audio = new Audio(audio2);
                break;
            case 'ting': audio = new Audio(audio3);
                break;
            default: audio = new Audio(audio1);
        }
        audio.loop = false;
        audio.play().then().catch(e =>{});
    }
}

export function showNotification(data, store) {
    let setting = data.setting
    if (setting && setting.notify_os){
        if (Notification.permission === 'granted') {
            showNotificationWindow(data, store)
        } else {
            Notification.requestPermission().then(function(permission) {
                if (permission === 'granted') {
                    showNotificationWindow(data, store)
                } else {
                    showNotificationCustom(data, store)
                }
            })
        }
    } else {
        showNotificationCustom(data, store)
    }
}