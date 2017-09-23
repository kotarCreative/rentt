// State
const state = {
    user: null,
    loading: [],
    errors: {},
    toasts: []
}

// Getters
const getters = {
    activeUser: state => state.user,
    modals: state => state.modals,
    loading: state => state.loading,
    errors: (state, type) => state.errors[type],
    hasLoading: (state, loading) => state.loading.indexOf(loading) > -1
}

// Actions
const actions = {
    finishAjaxCall({ state, commit }, { loader, response, model }) {
        commit('resetErrors');
        commit('removeLoading', loader);

        if (typeof response.response != 'undefined') {
            commit('addToast', response.message);
        } else {
            commit('addError', { error: response.response, model: model });
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
    addModal(state, modal) {
        state.modals.push(modal);
    },

    removeModal(state, modal) {
        var ind = state.modals.indexOf(modal);

        state.modals.splice(ind, 1);
    },

    addError(state, { error, model }) {
        state.errors[model] = error;
    },

    removeError(state, model) {
        state.errors = state.errors.filter((e, error) => error != model);
    },

    resetErrors(state) {
        state.errors = {};
    },

    setUser(state, user) {
        state.user = user;
    },

    addToast(state, toast) {
        state.toasts.push(toast);
    },

    removeToast(state, toast) {
        var ind = state.toasts.indexOf(toast);

        state.toasts.splice(ind, 1);
    },

    addLoading(state, loading) {
        state.loading.push(loading);
    },

    removeLoading(state, loading) {
        var ind = state.loading.indexOf(loading);
        state.loading.splice(ind, 1);
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
