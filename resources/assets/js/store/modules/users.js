// Namespaced
const namespaced = true

const REFERENCE = {
    first_name: null,
    last_name: null,
    email: null,
    relationship: null,
    is_approved: false
}
// State
const state = {
    active: {}
}

// Getters
const getters = {
    active: state => state.active,
    activePicture: state => state.active.profile_picture
}

// Actions
const actions = {
    store({ commit, dispatch }, params) {
        return new Promise((resultFn, errorFn) => {
            commit('addLoading', 'create-user', { root: true });
            axios.post('/register', params)
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
    addReference(state) {
        state.active.references.push(REFERENCE);
    },

    removeReference(state, idx) {
        state.active.references.splice(idx, 1);
    },

    setActive(state, user) {
        state.active = user;
    },

    setActivePicture(state, file) {
        state.active.profile_picture = file;
    },

    updateActive(state, updates) {
        Object.keys(updates).forEach(k => {
            state.active[k] = updates[k];
        });
    }
}

export default {
    namespaced,
    state,
    getters,
    actions,
    mutations
}
