import moment from '../plugins/moment'
import { computed } from 'vue';
export default {
    datetime (value, arg1) {
        let date = new Date(value);
        return computed(()=>{
            if (arg1 === 'dd/mm/yyyy')
                return (date.toLocaleDateString('vi-VN') + ' ' + date.toLocaleTimeString('vi-VN'));
            return (
                date.getFullYear() + '-' +
                ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
                ('0' + date.getDate()).slice(-2) + ' ' +
                ('0' + date.getHours()).slice(-2) + ':' +
                ('0' + date.getMinutes()).slice(-2)
            );
        })
    },

    time (value, arg1) {
        let date = new Date(value);
        if (arg1 === 'dd/mm/yyyy')
            return (date.toLocaleDateString('vi-VN') + ' ' + date.toLocaleTimeString('vi-VN'));
        return (
            ('0' + date.getHours()).slice(-2) + ':' +
            ('0' + date.getMinutes()).slice(-2)
        );
    },

    date(value) {
        return moment(value).format('DD-MM-YYYY');
    },

    datePicker(value, options={}) {
        return moment(value).format(options.format || 'YYYY-MM-DD');
    },

    short_date(value) {
        return moment(value).format('DD');
    },
    month(value) {
        return moment(value).format('MM');
    },
    year(value) {
        return moment(value).format('YYYY');
    },

    monthYear(value) {
        return moment(value).format('MM-YYYY');
    },

    time_to_second(time) {
        const [hours, minutes] = time.split(":").map(Number);
        return (hours * 3600) + (minutes * 60);
    },

    date_of_week(value) {
        let i = moment(value).format('d');
        switch (i){
            case '0': return 'CN';
            case '1': return 'T2';
            case '2': return 'T3';
            case '3': return 'T4';
            case '4': return 'T5';
            case '5': return 'T6';
            case '6': return 'T7';
        }
    },

    fromNow (value, arg1) {
        return moment(value).fromNow();
    },

    createMonthYearFromFormat (value, format) {
        return moment(value, format).format('MM/YYYY');
    },   

    formatCapacity(value) {
        if (value >= 1024 && value < 1024 * 1024) {
          return (value / 1024).toFixed(2) + ' KB';
        } else if (value >= 1024 * 1024 && value < 1024 * 1024 * 1024) {
          return (value / (1024 * 1024)).toFixed(2) + ' MB'; 
        } else if (value >= 1024 * 1024 * 1024) {
          return (value / (1024 * 1024 * 1024)).toFixed(2) + ' GB'
        } else {
          return value + ' B';
        }
    },

    renderBetweenDate(start, end) {
        start = start ? moment(start) : null
        end = end ? moment(end) : null

        if (!start && !end) return
        if (!start) return `? - ${end?.format('DD/MM/YYYY')}`
        if (!end) return `${start.format('DD/MM/YYYY')} - ?`

        const startFormat = start.isSame(end, 'year') ? start.format('DD/MM') : start.format('DD/MM/YYYY')
        const endFormat = end.format('DD/MM/YYYY')

        return `${startFormat} - ${endFormat}`
    },
    renderStartEnd({start, end, format = 'DD/MM/YYYY'}) {
        if (!start && end) return `${moment(end).format(format)}`
        if (start && !end) return `${moment(start).format(format)}`
        if (start && end) return `${moment(start).format(format)} - ${moment(end).format(format)}`
        return '--'
    },
    formatNumber(amount) {
        return Math.floor(amount).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    formatCurrency(amount) {
        return Math.floor(amount).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    formatNumberWithTwoDecimals(amount) {
        return amount
            .toFixed(2) // Làm tròn 2 chữ số thập phân
            .replace(/\B(?=(\d{3})+(?!\d))/g, ","); // Định dạng dấu phẩy
    }
}