/**
 * Converts a JSON object to a FormData object.
 *
 * @param FormData formData
 * @param Object json
 * @param string prefix
 *
 * @return void
 */
export const JSONToFormData = (formData, json, prefix) => {
    // json is actually an object
    if (typeof json == 'object') {
        Object.keys(json).forEach(param => {
            if (json[param] == null) return;

            var key = prefix ? prefix + '[' + param + ']' : param;

            if (Array.isArray(json[param])) {
                // Convert array items
                json[param].forEach((el, idx) => {
                    JSONToFormData(formData, el, key + '[' + idx + ']')
                });
            } else if (typeof json[param].name !== 'undefined') {
                // Convert files
                formData.append(key, json[param], json[param].name);
            } else if (toString.call(json[param]) === '[object Date]') {
                // Convert date objects
                formData.append(key, json[param].toDateString());
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
            formData.append(prefix, json, json.name);
        } else if (toString.call(json) === '[object Date]') {
            // Convert date objects
            formData.append(prefix, json.toDateString());
        } else {
            // Convert regular keys
            formData.append(prefix, json);
        }
    }
}
