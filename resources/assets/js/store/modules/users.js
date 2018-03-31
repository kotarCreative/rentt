// Namespaced
const namespaced = true

const PROPERTY = {
    landlord_id: null,
    property_id: null,
    city_id: null,
    landlord_first_name: null,
    landlord_last_name: null,
    landlord_email: null,
    is_verified: false,
    started_on: null,
    ended_on: null
}

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
    addProperty(state) {
        state.active.rental_history.push(PROPERTY);
    },

    addReference(state) {
        state.active.references.push(REFERENCE);
    },

    removeProperty(state, idx) {
        state.active.rental_history.splice(idx, 1);
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
