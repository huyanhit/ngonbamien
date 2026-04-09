import { createI18n } from 'vue-i18n';
import vi from '../lang/vi'; 
import en from '../lang/en';

const datetimeFormats = {
    'vi-VN': {
        short: {
            year: 'numeric', month: 'numeric', day: 'numeric'
        },
        long: {
            year: 'numeric', month: 'short', day: 'numeric',
            weekday: 'short', hour: 'numeric', minute: 'numeric'
        }
    },
    'en-US': {
        short: {
            year: 'numeric', month: 'short', day: 'numeric'
        },
        long: {
            year: 'numeric', month: 'short', day: 'numeric',
            weekday: 'short', hour: 'numeric', minute: 'numeric'
        }
    },
};

const i18n = createI18n({
    allowComposition: true,
    locale: 'vi',
    fallbackLocale: 'en',
    legacy: false,
    missingWarn: false,
    fallbackWarn: false,
    globalInjection: true,
    warnHtmlMessage: false,
    messages: {
        vi
    }
});

export function handleLang() {
    let lang = i18n.global.locale;
    switch (lang) {
        case 'vi':
            return 'vi-VN';
        case 'en':
            return 'en-US';
        default:
            return 'vi-VN';
    }
}

export default i18n;

export const { t } = i18n.global;
