import Gallery from "./components/gallery";

export default {
    install (Vue, options) {
        Vue.component('vue-gallery', Gallery);

        Vue.prototype.$gallery = {}
    }
}
