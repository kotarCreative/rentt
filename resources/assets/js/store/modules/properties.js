// Namespaced
const namespaced = true

// State
const state = {
    all: [],
    active: {
        id: null,
        title: null,
        type: null,
        city_id: null,
        bedrooms: null,
        bathrooms: null,
        utilities: [],
        amenities: [],
        description: null,
        price: null,
        damage_deposit: null,
        images: [],
        available_at: null
    },
    types: [],
    countries: [],
    subdivisions: [],
    cities: [],
    utilities: [],
    amenities: [],
    types: []
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
    amenities: state => state.amenities,
    types: state => state.types,
    activeImages: state => state.active.images
}

// Actions
const actions = {
    search({ commit, dispatch }, { where, bedroomCount }) {

    },

    details({ state, commit, dispatch }) {
        if (state.amenities.length == 0 || state.utilities.length == 0 || state.types.length == 0) {
            commit('addLoading', 'get-property-details', { root: true });
            axios.get('/properties/details')
                 .then(response => {
                    commit('setUtilities', response.data.utilities);
                    commit('setAmenities', response.data.amenities);
                    commit('setTypes', response.data.types);
                    dispatch('finishAjaxCall', { loader: 'get-property-details', response: response }, { root: true });
                 })
                 .catch(errors => {
                    dispatch('finishAjaxCall', { loader: 'get-property-details', response: errors, model: 'properties' }, { root: true });
                 });
        }
    },

    store() {}
}

// Mutations
const mutations = {
    setUtilities(state, utilities) {
        state.utilities = utilities;
    },

    setAmenities(state, amenities) {
        state.amenities = amenities;
    },

    setTypes(state, types) {
        state.types = types;
    },

    setActiveImages(state, images) {
        state.active.images = images;
    }
}

export default {
    namespaced,
    state,
    getters,
    actions,
    mutations
}
