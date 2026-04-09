import Axios  from 'axios'
import i18n   from '../plugins/i18n';

const t       = i18n.global.t;
const URL     = '';
const token   = document.querySelector("meta[name='api-token']").getAttribute('content');

export default class ApiService {
    callApi(data){
        if(data.method !== undefined && data.url !== undefined){
            let method = data.method.toLowerCase();
            let url    = data.url.toLowerCase();
            let param  = data.param;

            switch(method){
                case 'get':
                    return this.get(url, param).then((response) => response);
                case 'delete':
                    return this.delete(url, param).then((response) => response);
                case 'post':
                    return this.post(url, param).then((response) => response);
                case 'put':
                    return this.put(url, param).then((response) => response);
                case 'put_upload':
                    return this.put_upload(url, param).then((response) => response);
                case 'upload':
                    return this.upload(url, param).then((response) => response);
                case 'image':
                    return this.image(url, param).then((response) => response);
                case 'download':
                        return this.download(url, param).then((response) => response);
                default:
                    return { message:'method not support', errors:null };
            }
        }else{
            return { message:'call api fail', errors: null };
        }
    }
    authHeader() {
        const headers = {
            Accept: 'application/json',
        };
        if (token) {
            headers.Authorization = 'Bearer ' + token;
        }

        return headers;
    }

    get(api, param) {
        api = this.joinParamToUrl(api, param);
        return Axios.get(URL + api, {
            headers: this.authHeader()
        })
        .then(res => {
            res.data.param = param
            return res.data;
        })
        .catch(err => {
            return this.processErrorResponse(err, api);
        });
    }

    download(api, param, responseType = 'blob') {
        api = this.joinParamToUrl(api, param);
        return Axios.get(URL + api, {
            headers: this.authHeader(),
            responseType: responseType
        })
        .then(res => {
            return res;
        })
        .catch(err => {
            return this.processErrorResponse(err, api);
        });
    }

    delete(api, param) {
        if(!param?.ids) {
            api = this.joinParamToUrl(api, param);
        }
        return Axios.delete(URL + api, {
            headers: this.authHeader(),
            data: param
        })
        .then(res => {
            return res.data;
        })
        .catch(err => {
            return this.processErrorResponse(err, api);
        });
    }

    post(api, data) {
        return Axios.post(URL + api, data, {
            headers: this.authHeader()
        })
        .then(res => {
            return res.data;
        })
        .catch(err => {
            return this.processErrorResponse(err, api);
        });
    }

    put_upload(api, data) {
        data.append('_method', 'PUT');
        return Axios.post(URL + api, data, {
            headers: this.authHeader()
        })
        .then(res => {
            return res.data;
        })
        .catch(err => {
            return this.processErrorResponse(err, api);
        });
    }

    put(api, data) {
        return Axios.put(URL + api, data, {
            headers: this.authHeader()
        })
        .then(res => {
            return res.data;
        })
        .catch(err => {
            return this.processErrorResponse(err, api);
        });
    }

    upload(api, data) {
        return Axios.post(URL + api, data, {
            headers: Object.assign(this.authHeader(), {
                'Content-Type': 'multipart/form-data'
            }),
        })
        .then(res => {
            return res.data;
        })
        .catch(err => {
            return this.processErrorResponse(err, api);
        });
    }
    image(api, param) {
        return fetch(URL + api + '/' + param.id, {
            headers: this.authHeader()
        })
    }
    joinParamToUrl(api, params) {
        let string = api;
        if(params !== undefined){
            let i = 0
            for(let index in params){
                if(i === 0){
                    string += '?'+ index +'=' + params[index];
                }else{
                    string += '&'+ index +'=' + params[index];
                }

                i++;
            }
        }
        return string;
    }

    processErrorResponse(err, api) {
        return err.response.data;
    }
}