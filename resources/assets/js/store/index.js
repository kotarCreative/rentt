import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

// Modules
import app from './modules/app'
import properties from './modules/properties'

export default new Vuex.Store({
    modules: {
        app,
        properties
    }
})
