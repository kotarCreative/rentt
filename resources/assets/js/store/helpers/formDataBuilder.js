export const JSONToFormData = function (formData, json, prefix) {
    // json is actually an object
    if (Object.keys(json).length > 0) {
        Object.keys(json).forEach(param => {
            if (json[param] == null) return;

            var key = prefix ? prefix + '[' + param + ']' : param;

            if (Array.isArray(json[param])) {
                // Convert array items
                json[param].forEach((el, idx) => {
                    JSONToFormData(formData, el, param + '[' + idx + ']')
                });
            } else if (typeof json[param].name !== 'undefined') {
                // Convert files
                formData.append(key, json[param], json[param].name);
            } else if (toString.call(json[param]) === '[object Date]') {
                // Convert date objects
                formData.append(key, json[param].toISOString());
            } else if (typeof json[param] === 'object') {
                // Convert objects
                JSONToFormData(formData, json[param], key);
            } else {
                // Convert regular keys
                formData.append(key, json[param]);
            }
        });
    } else {
        // Base Case
        if (Array.isArray(json)) {
            // Convert array items
            json.forEach((el, idx) => {
                JSONToFormData(formData, el, prefix + '[' + idx + ']')
            });
        } else if (typeof json.name !== 'undefined') {
            // Convert files
            formData.append(key, json, json.name);
        } else if (toString.call(json) === '[object Date]') {
            // Convert date objects
            formData.append(prefix, json.toISOString());
        } else {
            // Convert regular keys
            formData.append(prefix, json);
        }
    }

}
