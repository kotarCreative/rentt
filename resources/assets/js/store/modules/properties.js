// Namespaced
const namespaced = true

import {
    JSONToFormData
} from '../helpers/formDataBuilder';

const STRUCTURE = {
    id: null,
    title: null,
    type_id: null,
    city_id: null,
    address_line_1: null,
    address_line_2: null,
    postal: null,
    coordinates: {
        lat: 53.5444,
        lng: -113.4909
    },
    bedrooms: null,
    bathrooms: null,
    size: null,
    user: {
        first_name: null,
        last_name: null,
        created_at: null
    },
    utilities: [],
    amenities: [],
    description: '',
    price: null,
    damage_deposit: null,
    images: [],
    available_at: null,
    type: {},
    is_active: false,
    is_occupied: false
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
        'home-types': []
    },
    subdivisions: [],
    types: [],
    utilities: [],
}

// Getters
const getters = {
    active: state => state.active,
    activeImages: state => {
        return { ...state.active.image_routes, ...state.active.images }
    },
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
    details({
        state,
        commit,
        dispatch
    }) {
        if (state.amenities.length == 0 || state.utilities.length == 0 || state.types.length == 0) {
            var loader = 'get-property-details';
            commit('addLoading', loader, {
                root: true
            });
            axios.get('/properties/details')
                .then(response => {
                    commit('setUtilities', response.data.utilities);
                    commit('setAmenities', response.data.amenities);
                    commit('setTypes', response.data.types);
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: response,
                        model: 'properties'
                    }, {
                        root: true
                    });
                })
                .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: errors,
                        model: 'properties'
                    }, {
                        root: true
                    });
                });
        }
    },

    getCities({
        commit,
        dispatch
    }, subdivisionId) {
        var loader = 'get-subdivision-cities';
        commit('addLoading', loader, {
            root: true
        });
        axios.get('/subdivisions/' + subdivisionId + '/cities')
            .then(response => {
                commit('setCities', response.data.cities);
                dispatch('finishAjaxCall', {
                    loader: loader,
                    response: response,
                    model: 'properties'
                }, {
                    root: true
                });
            })
            .catch(errors => {
                dispatch('finishAjaxCall', {
                    loader: loader,
                    response: errors,
                    model: 'properties'
                }, {
                    root: true
                });
            });
    },

    getSubdivisions({
        commit,
        dispatch
    }, countryId) {
        if (state.subdivisions.length == 0) {
            var loader = 'get-country-subdivisions';
            commit('addLoading', loader, {
                root: true
            });
            axios.get('/countries/' + countryId + '/subdivisions')
                .then(response => {
                    commit('setSubdivisions', response.data.subdivisions);
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: response,
                        model: 'properties'
                    }, {
                        root: true
                    });
                })
                .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: errors,
                        model: 'properties'
                    }, {
                        root: true
                    });
                });
        }
    },

    search({
        commit,
        dispatch
    }) {
        return new Promise((resultFn, errorFn) => {
            var loader = 'search-properties';
            commit('addLoading', loader, {
                root: true
            });
            axios.get('/properties/search', {
                    params: state.search
                })
                .then(response => {
                    commit('setAll', response.data.properties);
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: response,
                        model: 'properties'
                    }, {
                        root: true
                    });

                    if (resultFn) {
                        resultFn(response);
                    }
                })
                .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: errors,
                        model: 'properties'
                    }, {
                        root: true
                    });

                    if (errorFn) {
                        errorFn(errors);
                    }
                });
        });
    },

    store({
        state,
        commit,
        dispatch
    }, isActive) {
        return new Promise((resultFn, errorFn) => {
            var loader = 'store-property';
            commit('addLoading', loader, {
                root: true
            });

            var property = state.active;

            // Sanitize data
            if (property.city) {
                property.city_id = property.city.id;
            }
            property.amenities = property.amenities;
            property.utilities = property.utilities;
            property.is_active = isActive;

            // Convert active property to form data
            var formData = new FormData();
            JSONToFormData(formData, property);

            var config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            axios.post('/properties', formData, config)
                .then(response => {
                    if (response.data.redirect) {
                        redirectTo(response.data.redirect);
                    }
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: response,
                        model: 'properties'
                    }, {
                        root: true
                    });
                    if (resultFn) {
                        resultFn(response);
                    }
                })
                .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: errors,
                        model: 'properties'
                    }, {
                        root: true
                    });
                    if (errorFn) {
                        errorFn(errors);
                    }
                });
        });
    },

    update({
        state,
        commit,
        dispatch
    }, {
        isActive,
        isOccupied
    }) {
        return new Promise((resultFn, errorFn) => {
            var loader = 'update-property';
            commit('addLoading', loader, {
                root: true
            });
            var property = state.active;

            // Sanitize data
            if (property.city) {
                property.city_id = property.city.id;
            }
            if (property.amenities && typeof property.amenities[0] === 'object') {
                property.amenities = property.amenities.map(a => a.id);
            }

            if (property.utilities && typeof property.utilities[0] === 'object') {
                property.utilities = property.utilities.map(u => u.id);
            }
            property.is_active = isActive;
            property.is_occupied = isOccupied;

            // Convert active property to form data
            var formData = new FormData();
            formData.append('_method', 'PATCH');
            JSONToFormData(formData, property);

            var config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            axios.post('/properties/' + property.id, formData, config)
                .then(response => {
                    if (response.data.redirect) {
                        redirectTo(response.data.redirect);
                    }
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: response,
                        model: 'properties'
                    }, {
                        root: true
                    });
                    if (resultFn) {
                        resultFn(response);
                    }
                })
                .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: errors,
                        model: 'properties'
                    }, {
                        root: true
                    });
                    if (errorFn) {
                        errorFn(errors);
                    }
                });
        });
    },

    contactOwner({
        state,
        commit,
        dispatch
    }, params) {
        return new Promise((resultFn, errorFn) => {
            var loader = 'contact-owner';
            commit('addLoading', loader, {
                root: true
            });

            axios.post('/properties/' + state.active.id + '/contact', params)
                .then(response => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: response,
                        model: 'properties'
                    }, {
                        root: true
                    });
                    if (resultFn) {
                        resultFn(response);
                    }
                })
                .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: errors,
                        model: 'properties'
                    }, {
                        root: true
                    });
                    if (errorFn) {
                        errorFn(errors);
                    }
                });
        });
    },

    review({
        state,
        commit,
        dispatch
    }, params) {
        return new Promise((resultFn, errorFn) => {
            var loader = 'post-review';
            commit('addLoading', loader, {
                root: true
            });

            axios.post('/properties/' + state.active.id + '/reviews', params)
                .then(response => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: response,
                        model: 'properties'
                    }, {
                        root: true
                    });
                    if (resultFn) {
                        resultFn(response);
                    }
                })
                .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: errors,
                        model: 'properties'
                    }, {
                        root: true
                    });
                    if (errorFn) {
                        errorFn(errors);
                    }
                });
        });
    },

    destroy({
        commit,
        dispatch
    }) {
        return new Promise((resultFn, errorFn) => {
            var loader = 'destroy-property';
            commit('addLoading', loader, {
                root: true
            });

            axios.delete('/properties/' + state.active.id)
                .then(response => {
                    if (response.data.redirect) {
                        redirectTo(response.data.redirect);
                    }
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: response,
                        model: 'properties'
                    }, {
                        root: true
                    });
                    if (resultFn) {
                        resultFn(response);
                    }
                })
                .catch(errors => {
                    dispatch('finishAjaxCall', {
                        loader: loader,
                        response: errors,
                        model: 'properties'
                    }, {
                        root: true
                    });
                    if (errorFn) {
                        errorFn(errors);
                    }
                });
        });
    }
}

// Mutations
const mutations = {
    removeImageRoute(state, idx) {
        if (state.active.image_routes) {
            state.active.image_routes.splice(idx, 1);
        }
    },

    resetActive(state) {
        state.active = STRUCTURE;
    },

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

    setActive(state, property) {
        state.active = property;
    },

    setActiveImages(state, images) {
        state.active.image_routes = images;
    },

    setSubdivisions(state, subdivisions) {
        state.subdivisions = subdivisions;
    },

    setCities(state, cities) {
        state.cities = cities;
    },

    updateActive(state, {
        key,
        val
    }) {
        state.active[key] = val;
    },

    updateSearch(state, {
        key,
        val
    }) {
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
