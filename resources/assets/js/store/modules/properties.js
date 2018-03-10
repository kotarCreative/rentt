// Namespaced
const namespaced = true

const STRUCTURE = {
    id: null,
    title: null,
    type_id: null,
    city_id: null,
    address_line_1: null,
    address_line_2: null,
    coordinates: {
        lat: null,
        lng: null
    },
    bedrooms: null,
    bathrooms: null,
    size: null,
    utilities: [],
    amenities: [],
    description: null,
    price: null,
    damage_deposit: null,
    images: [],
    available_at: null
}

// State
const state = {
    all: [],
    active: STRUCTURE,
    amenities: [],
    cities: [],
    countries: [],
    search: {
        bedrooms: null,
        order: 'Newest',
        type_id: null,
        where: null,
    },
    subdivisions: [],
    types: [],
    utilities: [],
}

// Getters
const getters = {
    active: state => state.active,
    activeImages: state => state.active.images,
    all: state => state.all,
    amenities: state => state.amenities,
    cities: state => state.cities,
    countries: state => state.countries,
    search: state => state.search,
    subdivisions: state => state.subdivisions,
    types: state => state.types,
    utilities: state => state.utilities
}

// Actions
const actions = {
    details({ state, commit, dispatch }) {
        if (state.amenities.length == 0 || state.utilities.length == 0 || state.types.length == 0) {
            commit('addLoading', 'get-property-details', { root: true });
            axios.get('/properties/details')
                 .then(response => {
                    commit('setUtilities', response.data.utilities);
                    commit('setAmenities', response.data.amenities);
                    commit('setTypes', response.data.types);
                    dispatch('finishAjaxCall', {
                        loader: 'get-property-details',
                        response: response,
                        model: 'properties'
                    }, { root: true });
                 })
                 .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: 'get-property-details',
                        response: errors,
                        model: 'properties'
                    }, { root: true });
                 });
        }
    },

    getCities({ commit, dispatch }, subdivisionId) {
        commit('addLoading', 'get-subdivision-cities', { root: true });
        axios.get('/subdivisions/' + subdivisionId + '/cities')
             .then(response => {
                commit('setCities', response.data.cities);
                dispatch('finishAjaxCall', {
                    loader: 'get-subdivision-cities',
                    response: errors,
                    model: 'properties'
                }, { root: true });
             })
             .catch(errors => {
                dispatch('finishAjaxCall', {
                    loader: 'get-subdivision-cities',
                    response: errors,
                    model: 'properties'
                }, { root: true });
             });
    },

    getSubdivisions({ commit, dispatch }, countryId) {
        if (state.subdivisions.length == 0) {
            commit('addLoading', 'get-country-subdivisions', { root: true });
            axios.get('/countries/' + countryId + '/subdivisions')
                 .then(response => {
                    commit('setSubdivisions', response.data.subdivisions);
                    dispatch('finishAjaxCall', {
                        loader: 'get-country-subdivisions',
                        response: errors,
                        model: 'properties'
                    }, { root: true });
                 })
                 .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: 'get-country-subdivisions',
                        response: errors,
                        model: 'properties'
                    }, { root: true });
                 });
        }
    },

    search({ commit, dispatch }) {
        return new Promise((resultFn, errorFn) => {
            commit('addLoading', 'search-properties', { root: true });
            axios.get('/properties/search', { params: state.search })
                 .then(response => {
                    commit('setAll', response.data.properties);
                    dispatch('finishAjaxCall', {
                        loader: 'search-properties',
                        response: errors,
                        model: 'properties'
                    }, { root: true });
                 })
                 .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: 'search-properties',
                        response: errors,
                        model: 'properties'
                    }, { root: true });
                 });
        });
    },

    store({ state, commit, dispatch }) {
        return new Promise((resultFn, errorFn) => {
            commit('addLoading', 'store-property', { root: true });
            var property = state.active;

            // Convert active property to form data
            var formData = new FormData();
            Object.keys(property).forEach(param => {
                if (Array.isArray(property[param])) {
                    property[param].forEach(el => {
                        if (typeof el.name !== 'undefined') {
                            formData.append(param + '[]', el, el.name);
                        } else {
                            formData.append(param + '[]', el);
                        }
                    })
                } else {
                    formData.append(param, property[param]);
                }
            })
            axios.post('/properties', formData)
                 .then(response => {
                    dispatch('finishAjaxCall', { loader: 'store-property', response: errors, model: 'properties' }, { root: true });
                 })
                 .catch(errors => {
                    dispatch('finishAjaxCall', { loader: 'store-property', response: errors, model: 'properties' }, { root: true });
                 });
        });
    }
}

// Mutations
const mutations = {
    setUtilities(state, utilities) {
        state.utilities = utilities;
    },

    setAmenities(state, amenities) {
        state.amenities = amenities;
    },

    setAll(state, all) {
        state.all = all;
    },

    setTypes(state, types) {
        state.types = types;
    },

    setActiveImages(state, images) {
        state.active.images = images;
    },

    setSubdivisions(state, subdivisions) {
        state.subdivisions = subdivisions;
    },

    setCities(state, cities) {
        state.cities = cities;
    },

    updateSearch(state, { key, val }) {
        state.search[key] = val;
    }
}

export default {
    namespaced,
    state,
    getters,
    actions,
    mutations
}
