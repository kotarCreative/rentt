// Namespaced
const namespaced = true

// State
const state = {
    all: [],
    active: {},
    types: [],
    countries: [],
    subdivisions: [],
    cities: [],
    utilities: [],
    ammenities: []
}

// Getters
const getters = {
    all: state => state.all,
    active: state => state.active,
    types: state => state.types,
    countries: state => state.countries,
    subdivisions: state => state.subdivisions,
    cities: state => state.cities,
    utilities: state => state.utilities,
    ammenities: state => state.ammenities
}

// Actions
const actions = {
    search({ commit, dispatch }, { where, bedroomCount }) {

    },

    details({ commit, dispatch }) {
        commit('addLoading', 'get-property-details', { root: true });
        axios.get('/properties/details')
             .then(response => {
                commit('setUtilities', response.data.utilities);
                commit('setAmmenities', response.data.ammenities);
                dispatch('finishAjaxCall', { loader: 'get-property-details', response: response }, { root: true });
             })
             .catch(errors => {
                dispatch('finishAjaxCall', { loader: 'get-property-details', response: errors, model: 'properties' }, { root: true });
             });
    }
}

// Mutations
const mutations = {
    setUtilities(state, utilities) {
        state.utilities = utilities;
    },

    setAmmenities(state, ammenities) {
        state.ammenities = ammenities;
    }
}

export default {
    namespaced,
    state,
    getters,
    actions,
    mutations
}
