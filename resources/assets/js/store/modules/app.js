// State
const state = {
    user: null,
    loading: [],
    errors: {}
}

// Getters
const getters = {
    activeUser: state => state.user,
    errors: (state, type) => state.errors[type],
    hasLoading: (state, loading) => state.loading.indexOf(loading) > -1
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
                commit('setErrors', { model: model, errors: _response.data });
            }
        }
    },

    login({ commit, dispatch }, credentials) {
        commit('addLoading', 'log-in');

        axios.post('/login', credentials)
             .then(response => {
                redirectTo('');
                dispatch('finishAjaxCall', { loader: 'log-in', response: response });
             })
             .catch(errors => {
                dispatch('finishAjaxCall', { loader: 'log-in', response: errors, model: 'app' });
             });
    },

    logout({ commit, dispatch }) {
        commit('addLoading', 'log-out');

        axios.post('/logout')
             .then(response => {
                commit('setUser', null);
                redirectTo('');
                dispatch('finishAjaxCall', { loader: 'log-out', response: response });
             })
             .catch(errors => {
                dispatch('finishAjaxCall', { loader: 'log-out', response: errors, model: 'app' });
             });
    }
}

// Mutations
const mutations = {
    addLoading(state, loading) {
        state.loading.push(loading);
    },

    clearErrors(state, model) {
      state.errors[model] = [];
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
            if (state.errors[model].errors) {
                delete state.errors[model].errors[error];
                if (Object.keys(state.errors[model].errors).length == 0) {
                    delete state.errors[model];
                }
            } else if (error === 'general') {
                delete state.errors[model].general;
            }
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
