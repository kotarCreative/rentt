export const convertJson = function (formData, json, prefix) {
    if (Object.keys(json).length > 0) {
        Object.keys(json).forEach(param => {
            if (json[param] == null) return;

            var key = prefix ? prefix + '[' + param + ']' : param;

            // Convert array items
            if (Array.isArray(json[param])) {
                json[param].forEach((el, idx) => {
                    convertJson(formData, el, key + '[' + idx + ']')
                })
            // Convert files
            } else if (typeof json[param].name !== 'undefined') {
                formData.append(key, json[param], json[param].name);
            // Convert date objects
            } else if (toString.call(json[param]) === '[object Date]') {
                formData.append(key, json[param].toString());
            // Convert objects
            } else if (json[param] !== null && typeof json[param] === 'object') {
                convertJson(formData, json[param], key);
            // Convert boolean
            } else if (typeof json[param] === 'boolean') {
                formData.append(key, json[param] ? 'true' : 'false');
            // Convert regular keys
            } else {
                formData.append(key, json[param]);
            }
        });
    } else {
        // Convert array items
        if (Array.isArray(json)) {
            json.forEach((el, idx) => {
                convertJson(formData, el, prefix + '[' + idx + ']')
            })
        // Convert files
        } else if (typeof json.name !== 'undefined') {
            formData.append(prefix, json, json.name);
        // Convert date objects
        } else if (toString.call(json) === '[object Date]') {
            formData.append(prefix, json.toString());
        // Convert boolean
        } else if (typeof json === 'boolean') {
            formData.append(prefix, json ? 'true' : 'false');
        // Convert regular keys
        } else {
            formData.append(prefix, json);
        }
    }
}
