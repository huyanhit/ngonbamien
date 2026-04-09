import { Vietnamese } from 'flatpickr/dist/l10n/vn'
import { english} from "flatpickr/dist/l10n/default"
import { Japanese} from "flatpickr/dist/l10n/ja"
import flatpickr from "flatpickr"
import i18n from "@/plugins/i18n"

const locales = {
    vi : Vietnamese,
    en: english,
    jp: Japanese
}

flatpickr.localize(locales[i18n.global.locale.value]);