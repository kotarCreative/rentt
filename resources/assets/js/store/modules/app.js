// State
const state = {
    loading: [],
    errors: {},
    notices: {}
}

// Getters
const getters = {
    errors: state => state.errors,
    hasLoading: state => loading => state.loading.indexOf(loading) > -1,
    modelErrors: (state, type) => state.errors[type],
    notices: state => model => state.notices[model]
}

// Actions
const actions = {
    finishAjaxCall({ state, commit }, { loader, response, model }) {
        commit('setErrors', { errors: 'reset' });
        commit('setNotice', { notice: 'reset' });
        commit('removeLoading', loader);

        if(typeof response.response == 'undefined') {
            if (response.data && response.data.session) {
                commit('setNotice', { model: model, notice: response.data.session });
            }
        } else {
            var _response = response.response;
            if (typeof _response.data.session !== 'undefined') {
                commit('setErrors', { model: model, errors: { general: [ _response.data.session ] } });
            } else {
                if (_response.status == 413) {
                    commit('setErrors', {
                        model: model,
                        errors: {
                            data: [ 'The request was too large try resizing your photos or removing some and trying again.' ]
                        }
                    });
                } else {
                    commit('setErrors', { model: model, errors: _response.data });
                }
            }
        }
    },

    login({ commit, dispatch }, credentials) {
        var loader = 'log-in';
        commit('addLoading', loader);

        axios.post('/login', credentials)
             .then(response => {
                redirectTo('');
                dispatch('finishAjaxCall', { loader: loader, response: response });
             })
             .catch(errors => {
                dispatch('finishAjaxCall', { loader: loader, response: errors, model: 'app' });
             });
    },

    logout({ commit, dispatch }) {
        var loader = 'log-out';
        commit('addLoading', loader);

        axios.post('/logout')
             .then(response => {
                commit('users/resetActive', null, { root: true });
                redirectTo('');
                dispatch('finishAjaxCall', { loader: loader, response: response });
             })
             .catch(errors => {
                dispatch('finishAjaxCall', { loader: loader, response: errors, model: 'app' });
             });
    },

    sendFeedback({ commit, dispatch }, params) {
        var loader = 'send-feedback';
        commit('addLoading', loader);

        return new Promise((resultFn, erroFn) => {
            axios.post('/feedback', params)
                 .then(response => {
                    dispatch('finishAjaxCall', { loader: loader, response: response, model: 'feedback' });
                    if (resultFn) { resultFn(); }
                 })
                 .catch(errors => {
                    dispatch('finishAjaxCall', { loader: loader, response: errors, model: 'feedback' });
                    if (errorFn) { errorFn(); }
                 });
        });
    }
}

// Mutations
const mutations = {
    addLoading(state, loading) {
        state.loading.push(loading);
    },

    clearErrors(state, model) {
      delete state.errors[model];
    },

    setErrors(state, { model, errors }) {
        if (model) {
            if (state.errors[model]) {
                Object.assign(state.errors[model], errors);
            } else {
                state.errors[model] = errors;
            }
        } else {
            if (errors === 'reset') {
                state.errors = {};
            } else {
                state.errors = errors;
            }
        }
    },

    setNotice(state, { model, notice }) {
        if (model) {
            if (state.notices[model]) {
                Object.assign(state.notices[model], notice);
            } else {
                state.notices[model] = notice;
            }
        } else {
            if (notice === 'reset') {
                state.notices = {};
            } else {
                state.notices = notice;
            }
        }
    },

    removeError(state, { model, error }) {
        if (state.errors[model]) {
            delete state.errors[model][error];
            if (Object.keys(state.errors[model]).length == 0) {
                delete state.errors[model];
            }
        } else if (error === 'general') {
            delete state.errors[model].general;
        }
    },

    removeLoading(state, loading) {
        state.loading = state.loading.filter(l => {
            return l !== loading;
        });
    },

    removeNotice(state, model) {
        if (state.notices[model]) {
            delete state.notices[model];
        }
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
