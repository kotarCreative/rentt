// Namespaced
const namespaced = true

// State
const state = {
    user: null,
    modals: [],
    loading: [],
    errors: {},
    toasts: []
}

// Getters
const getters = {
    user: state => state.user,
    modals: state => state.modals,
    loading: state => state.loading,
    errors: (state, type) => state.errors[type],
    hasModal: (state, modal) => state.modals.indexOf(modal) > -1,
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
    }
}

export default {
    namespaced,
    state,
    getters,
    actions,
    mutations
}
