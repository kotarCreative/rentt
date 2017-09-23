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
    utilities: []
}

// Getters
const getters = {
    all: state => state.all,
    active: state => state.active,
    types: state => state.types,
    countries: state => state.countries,
    subdivisions: state => state.subdivisions,
    cities: state => state.cities,
    utilities: state => state.utilities
}

// Actions
const actions = {
    search({ commit, dispatch }, { where, bedroomCount }) {

    }
}

// Mutations
const mutations = {

}

export default {
    namespaced,
    state,
    getters,
    actions,
    mutations
}
