import { all } from '@vee-validate/rules'
import { configure, defineRule  } from 'vee-validate';
import { localize, setLocale }  from '@vee-validate/i18n';
import vi from '@/lang/vi/common/validate.json';
import en from '@/lang/en/common/validate.json';
import jp from '@/lang/jp/common/validate.json';
import i18n from '@/plugins/i18n.ts'
import _, {clone} from "lodash"
import moment from 'moment'

Object.entries(all).forEach(([name, rule]) => {
    defineRule(name, rule);
})
const timeToSecond = function(time){
    const [hours, minutes] = time.split(":").map(Number);
    return (hours * 3600) + (minutes * 60);
}

defineRule('required_with', (value, [target, targetName], ctx) => {
    const targetKey = target.split('.')
    let targetFieldValue = ''
    if (targetKey.length > 0) {
        targetFieldValue = ctx.form[targetKey[0]]
        targetKey.forEach((element, index) => {
            if (index === 0) return true;
            targetFieldValue = targetFieldValue[element]
        });
    } else{
        targetFieldValue = ctx.form[target]
    }
    if (targetFieldValue && !value) {
        return i18n.global.t('common.validate.messages.required_with', { field: ctx.field, target: targetName });
    }

    return true;
});

defineRule('required_if', (value, [target, targetValue], ctx) => {
    const targetFieldValue = ctx.form[target];
    const isRequired = Array.isArray(targetValue)
        ? targetValue.includes(targetFieldValue)
        : targetFieldValue === targetValue;

    if (isRequired && !value) {
        return i18n.global.t('common.validate.messages.required_if', { field: ctx.field });
    }

    return true;
});

defineRule('unique', (value, [array, keyArray], ctx) => {
    const cloneArray = clone(ctx.form[array])
    if (value) {
        const index= ctx.name.split('[')[1].split(']')[0]
        cloneArray.splice(index, 1)
        const invalid = cloneArray.some(item => item[keyArray] === value);

        if (invalid) {
            return i18n.global.t('common.validate.messages.unique', { field: ctx.field });
        }
    }

    return true;
});

defineRule('before', (value, [date], ctx) => {
    if (!value || !value.length || date === 'null') {
        return true;
    }
    const dateBefore = moment(date).format('YYYY-MM-DD')

    if (!moment(value).isBefore(dateBefore)) {
        return i18n.global.t('common.validate.messages.before', { field: ctx.field, date });
    }

    return true;
});

defineRule('after', (value, [date], ctx) => {
    if (!value || !value.length || date === 'null') {
        return true;
    }
    const dateAfter = moment(date).format('YYYY-MM-DD')

    if (!moment(value).isAfter(dateAfter)) {
        return i18n.global.t('common.validate.messages.after', { field: ctx.field, date });
    }

    return true;
})

defineRule('before_or_equal', (value, [date], ctx) => {
    if (!value || !value.length || date === 'null') {
        return true;
    }
    const dateBefore = moment(date, 'YYYY-MM-DD')

    if (!moment(value).isSameOrBefore(dateBefore)) {
        return i18n.global.t('common.validate.messages.before_or_equal', { field: ctx.field, date });
    }

    return true;
});


defineRule('after_or_equal', (value, [date], ctx) => {
    if (!value || !value.length || date === 'null') {
        return true;
    }

    const dateAfter = moment(date).format('YYYY-MM-DD')

    if (!moment(value).isSameOrAfter(dateAfter)) {
        return i18n.global.t('common.validate.messages.after_or_equal', { field: ctx.field, date });
    }

    return true;
});

defineRule('before_or_equal_time', (value, [date, time, dateCurrent], ctx) => {
    if (!value || !value.length || time === 'null') {
        return true;
    }

    const dateTimeCurrent = moment(`${dateCurrent} ${value}`, 'YYYY-MM-DD HH:mm');
    const dateTimeAfter = moment(`${date} ${time}`, 'YYYY-MM-DD HH:mm');
    //const dateTimeCurrent = moment(`${dateCurrent} ${timeCurrent}`, 'YYYY-MM-DD H:i');
    console.log(time,  dateTimeCurrent, dateTimeAfter);
    // const dateTimeAfter = moment(`${dateAfter} ${time}`, 'YYYY-MM-DD H:i');
    if (!moment(dateTimeCurrent).isBefore(dateTimeAfter)) {
        return i18n.global.t('common.validate.messages.before_or_equal_time', { field: ctx.field, time });
    }

    return true;
});

defineRule('after_or_equal_time', (value, [date, time, dateCurrent], ctx) => {
    if (!value || !value.length || time === 'null') {
        return true;
    }

    const dateTimeCurrent = moment(`${dateCurrent} ${value}`, 'YYYY-MM-DD HH:mm');
    const dateTimeBefore = moment(`${date} ${time}`, 'YYYY-MM-DD HH:mm');

    if (!moment(dateTimeCurrent).isAfter(dateTimeBefore)) {
        return i18n.global.t('common.validate.messages.after_or_equal_time', { field: ctx.field, time });
    }

    return true;
});

defineRule('between_date', (value, [star, end], ctx) => {
    if (!value || !value.length || star === 'null' || end === 'null') {
        return true;
    }
    const startDate = moment(star).format('YYYY-MM-DD')
    const endDate = moment(end).format('YYYY-MM-DD')

    if (!moment(value).isBetween(startDate, endDate, undefined, '[]')) {
        return i18n.global.t('common.validate.messages.between_date', { field: ctx.field, start: startDate, end: endDate })
    }

    return true;
});

defineRule('username', (value, [minLength], ctx) => {
    if (!value || value.length === 0) {
        return i18n.global.t('common.validate.messages.required', { field: ctx.field });
    }
    
    if (value.length < minLength) {
        return i18n.global.t('common.validate.messages.minLength', { field: ctx.field, minLength });
    }
    
    const regex = /^[a-z0-9]+$/;
    if (!regex.test(value)) {
        return i18n.global.t('common.validate.messages.rex_username', { field: ctx.field });
    }

    return true;
});

defineRule('telephone', (value, ctx) => {
    // Regex để kiểm tra định dạng số điện thoại
    const regex = /^\+?[0-9]\d{1,14}$/;
    if (value && !regex.test(value)) {
        return i18n.global.t('common.validate.messages.invalidTelephone', { field: ctx.field });
    }

    return true;
});

defineRule('gt', (value, [num], ctx) => {
    if (parseFloat(value) <= parseFloat(num)) {
        return i18n.global.t('common.validate.messages.greater_than', { field: ctx.field, num: num });
    }
    return true;
});

defineRule('gt_time', (value, [time], ctx) => {
    if (timeToSecond(value) <= timeToSecond(time)) {
        return i18n.global.t('common.validate.messages.greater_than_time', { field: ctx.field, time: time });
    }
    return true;
});

defineRule('lt_time', (value, [time], ctx) => {
    if (timeToSecond(value) >= timeToSecond(time)) {
        return i18n.global.t('common.validate.messages.less_than_time', { field: ctx.field, time: time });
    }
    return true;
});

defineRule('gt_or_eq_time', (value, [time], ctx) => {
    if (timeToSecond(value) < timeToSecond(time)) {
        return i18n.global.t('common.validate.messages.greater_than_time', { field: ctx.field, time: time });
    }

    return true;
});

defineRule('lt_or_eq_time', (value, [time], ctx) => {
    if (timeToSecond(value) > timeToSecond(time)) {
        return i18n.global.t('common.validate.messages.less_than_time', { field: ctx.field, time: time });
    }

    return true;
});

defineRule('password', (value, [minLength], ctx) => {
    // Kiểm tra nếu trường trống
    if (!value || value.length === 0) {
        return i18n.global.t('common.validate.messages.required', { field: ctx.field });
    }

    // Kiểm tra độ dài tối thiểu
    if (value.length < minLength) {
        return i18n.global.t('common.validate.messages.min', { field: ctx.field, length: minLength });
    }

    // Kiểm tra các yêu cầu khác cho mật khẩu
    const hasUpperCase = /[A-Z]/.test(value);
    const hasLowerCase = /[a-z]/.test(value);
    const hasNumber = /\d/.test(value);
    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(value);

    if (!hasUpperCase) {
        return i18n.global.t('common.validate.messages.password.uppercase', { field: ctx.field });
    }

    if (!hasLowerCase) {
        return i18n.global.t('common.validate.messages.password.lowercase', { field: ctx.field });
    }

    if (!hasNumber) {
        return i18n.global.t('common.validate.messages.password.number', { field: ctx.field });
    }

    if (!hasSpecialChar) {
        return i18n.global.t('common.validate.messages.password.special', { field: ctx.field });
    }

    return true; // Nếu tất cả các yêu cầu đều hợp lệ
});

defineRule('date_format', (value, [format], ctx) => {
    if (!value || !value.length) {
        return true;
    }

    if (!moment(value, format, true).isValid()) {
        return i18n.global.t('common.validate.messages.date_format', { field: ctx.field, format });
    }

    return true;
});

defineRule('min_value_field', (value, [targetField], ctx) => {
    const targetValue = ctx.form[targetField];

    // if (!value || !targetValue) {
    //     return true;
    // }

    if (parseFloat(value) < parseFloat(targetValue)) {
        return i18n.global.t('common.validate.messages.min_value_field', {
            field: ctx.field,
            format: i18n.global.t(`common.validate.fields.${targetField}`),
        });
    }

    return true;
});

configure({
    generateMessage: localize({
        vi,
        en,
        jp
    }),
});

setLocale(i18n.global.locale.value);
