export const convertJson = function (formData, json, prefix) {
    Object.keys(json).forEach(param => {
        if (json[param] == null) return;

        var key = prefix ? prefix + '[' + param + ']' : param;

        // Convert array items
        if (Array.isArray(json[param])) {
            json[param].forEach((el, idx) => {
                convertJson(formData, el, param + '[' + idx + ']')
            })
        // Convert files
        } else if (typeof json[param].name !== 'undefined') {
            formData.append(key, json[param], json[param].name);
        // Convert date objects
        } else if (toString.call(json[param]) === '[object Date]') {
            formData.append(key , json[param].toString());
        // Convert objects
        } else if (json[param] !== null && typeof json[param] === 'object') {
            Object.keys(json[param]).forEach(k => {
                formData.append(key + '[' + k + ']', json[param][k]);
            });
        // Convert regular keys
        } else {
            formData.append(key, json[param]);
        }
    });
}