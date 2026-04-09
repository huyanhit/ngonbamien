import _ from 'lodash'
export default {
     mapObject: function (list, object, key, map = null){
        if(list[key]){
            let data = list[key].map(id => {
                let assign = object[id]? object[id]: object[key + '_' + id];
                if(assign){
                    if(map === null){
                        return Object.assign(assign, {id: id});
                    }else{
                        return Object.assign(assign, map[id]);
                    }
                }
            });

            return data.filter(filter => filter !== undefined);
        }

        return null;
    },
    merge: function(state, obj){
        for(let index in obj){
            state[index] = _.mergeWith(state[index], obj[index], (a, b) => _.isArray(b) ? b : undefined);
            state[index] = _.omitBy(state[index], v => v === null);
        }
    },
    mergeList: function(state, obj){
        for(let index in obj){
            _.merge(state[index], obj[index])
        }
    },
    last: function(obj){
        if(obj) return obj.slice(-1)[0]
    },
    removeEmptyValue: function(obj) {
        return _.omitBy(obj, (value) => value === '' || value === null || value === undefined || (Array.isArray(value) && value.length === 0))
    }
}