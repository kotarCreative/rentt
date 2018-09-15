// Namespaced
const namespaced = true

import {
    JSONToFormData
} from '../helpers/formDataBuilder';

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

const USER = {
    id: null,
    first_name: null,
    last_name: null,
    role: null,
    location: null,
    description: '',
    profile_picture: null
}

// State
const state = {
    active: USER,
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
    languages({
        state,
        commit,
        dispatch,
        rootGetters
    }) {
        if (state.languages.length == 0 && !rootGetters['hasLoading']('get-languages')) {
            var loader = 'get-languages';
            commit('addLoading', loader, {
                root: true
            });
            axios.get('/languages')
                .then(response => {
                    commit('setLanguages', response.data.languages);
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: response,
                        model: 'users'
                    }, {
                        root: true
                    });
                })
                .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: errors,
                        model: 'users'
                    }, {
                        root: true
                    });
                });
        }
    },

    store({
        commit,
        dispatch
    }, params) {
        return new Promise((resultFn, errorFn) => {
            var loader = 'store-user';
            commit('addLoading', loader, {
                root: true
            });
            axios.post('/register', params)
                .then(response => {
                    commit('setActive', response.data.user);
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: response,
                        model: 'users'
                    }, {
                        root: true
                    });

                    if (resultFn) {
                        resultFn(response)
                    }
                })
                .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: errors,
                        model: 'users'
                    }, {
                        root: true
                    });

                    if (errorFn) {
                        errorFn(errors)
                    }
                });
        });
    },

    update({
        state,
        commit,
        dispatch
    }) {
        var loader = 'update-user';
        commit('addLoading', loader, {
            root: true
        });

        // Convert active user to form data
        var user = state.active;
        var formData = new FormData();
        formData.append('_method', 'PATCH');

        JSONToFormData(formData, user);
        axios.post('/profile', formData)
            .then(response => {
                redirectTo(response.data.redirect);
                dispatch('finishAjaxCall', {
                    loader: loader,
                    response: response,
                    model: 'users'
                }, {
                    root: true
                });
            })
            .catch(errors => {
                dispatch('finishAjaxCall', {
                    loader: loader,
                    response: errors,
                    model: 'users'
                }, {
                    root: true
                });
            });
    },

    review({
        state,
        commit,
        dispatch
    }, {
        params,
        id
    }) {
        return new Promise((resultFn, errorFn) => {
            var loader = 'post-review';
            commit('addLoading', loader, {
                root: true
            });

            axios.post('/users/' + id + '/reviews', params)
                .then(response => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: response,
                        model: 'users'
                    }, {
                        root: true
                    });
                    if (resultFn) {
                        resultFn()
                    }
                })
                .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: errors,
                        model: 'users'
                    }, {
                        root: true
                    });
                    if (errorFn) {
                        errorFn()
                    }
                })
        })
    },

    contact({
        state,
        commit,
        dispatch
    }, params) {
        return new Promise((resultFn, errorFn) => {
            var loader = 'contact-user';
            commit('addLoading', loader, {
                root: true
            });

            axios.post('/users/contact', params)
                .then(response => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: response,
                        model: 'users'
                    }, {
                        root: true
                    });
                    if (resultFn) {
                        resultFn()
                    }
                })
                .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: errors,
                        model: 'users'
                    }, {
                        root: true
                    });
                    if (errorFn) {
                        errorFn()
                    }
                })
        })
    },

    emailResetPassword({ commit, dispatch }, email) {
        return new Promise((resultFn, errorFn) => {
            var loader = 'email-reset-password';
            commit('addLoading', loader, {
                root: true
            });

            axios.post('/password/email', { email: email })
                .then(response => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: response,
                        model: 'users'
                    }, {
                        root: true
                    });
                    if (resultFn) {
                        resultFn()
                    }
                })
                .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: errors,
                        model: 'users'
                    }, {
                        root: true
                    });
                    if (errorFn) {
                        errorFn()
                    }
                })
        })
    },

    resetPassword({ commit, dispatch }, params) {
        return new Promise((resultFn, errorFn) => {
            var loader = 'reset-password';
            commit('addLoading', loader, {
                root: true
            });

            axios.post('/password/reset', params)
                .then(response => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: response,
                        model: 'users'
                    }, {
                        root: true
                    });
                    if (resultFn) {
                        resultFn()
                    }
                })
                .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: errors,
                        model: 'users'
                    }, {
                        root: true
                    });
                    if (errorFn) {
                        errorFn()
                    }
                })
        })
    }
}

// Mutations
const mutations = {
    addProperty(state) {
        state.active.rental_history.push({ ...PROPERTY });
    },

    addReference(state) {
        state.active.references.push({ ...REFERENCE });
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
