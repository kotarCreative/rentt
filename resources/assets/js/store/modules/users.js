// Namespaced
const namespaced = true

// State
const state = {
    active: {}
}

// Getters
const getters = {
    active: state => state.active
}

// Actions
const actions = {
    store({ commit, dispatch }, params) {
        return new Promise((resultFn, errorFn) => {
            commit('addLoading', 'create-user', { root: true });
            axios.post('/users', params)
                 .then(response => {
                    commit('setActive', response.data.user);
                    dispatch('finishAjaxCall', {
                        loader: 'create-user',
                        response: response,
                        model: 'users'
                    }, { root: true });

                    if (resultFn) { resultFn(response) }
                 })
                 .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: 'create-user',
                        response: errors,
                        model: 'users'
                    }, { root: true });

                    if (errorFn) { errorFn(errors) }
                 });
        });
    }
}

// Mutations
const mutations = {
    setActive(state, user) {
        state.active = user;
    }
}

export default {
    namespaced,
    state,
    getters,
    actions,
    mutations
}
