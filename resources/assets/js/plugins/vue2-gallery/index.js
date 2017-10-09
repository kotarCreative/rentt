import Gallery from "./components/Gallery";

export default {
    install (Vue, options) {
        Vue.component('vue-gallery', Gallery);

        Vue.prototype.$gallery = {}
    }
}
