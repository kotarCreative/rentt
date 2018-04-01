// Namespaced
const namespaced = true

import { convertJson } from '../helpers/formDataBuilder';

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
    active: {},
    languages: []
}

// Getters
const getters = {
    active: state => state.active,
    activePicture: state => state.active.profile_picture,
    languages: state => state.languages
}

// Actions
const actions = {
    languages({ state, commit, dispatch, rootGetters }) {
        if (state.languages.length == 0 && !rootGetters['hasLoading']('get-languages')) {
            commit('addLoading', 'get-languages', { root: true });
            axios.get('/languages')
                 .then(response => {
                    commit('setLanguages', response.data.languages);
                    dispatch('finishAjaxCall', {
                            loader: 'get-languages',
                            response: response,
                            model: 'users'
                        }, { root: true });
                 })
                 .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: 'get-languages',
                        response: errors,
                        model: 'users'
                    }, { root: true });
                 });
        }
    },

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
    },

    update({ state, commit, dispatch }) {
        commit('addLoading', 'update-user', { root: true });

        // Convert active user to form data
        var user = state.active;
        var formData = new FormData();
        formData.append('_method', 'PATCH');

        convertJson(formData, user);
        axios.post('/profile', formData)
             .then(response => {
                redirectTo('/profile?success=edit');
                dispatch('finishAjaxCall', {
                    loader: 'update-user',
                    response: response,
                    model: 'users'
                }, { root: true });
             })
             .catch(errors => {
                dispatch('finishAjaxCall', {
                    loader: 'update-user',
                    response: errors,
                    model: 'users'
                }, { root: true });
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

    setLanguages(state, languages) {
        state.languages = languages;
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
