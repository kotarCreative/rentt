<template>
    <div id="property-search-bar">
        <div class="row">
            <div class="xs-1-1" :class="[{ 'sm-2-3': !inHeader }]">
                <div class="form-group">
                    <vueplete name="where"
                              url="/cities"
                              v-model="whereSearch"
                              :get-option="formatSearchOption"
                              @selectOption="search"></vueplete>
                </div>
            </div>
            <div class="xs-1-1 sm-1-3" v-if="!inHeader">
                <button
                    class="btn search"
                    @click="search"
                >Search</button>
            </div>
        </div>
    </div>
</template>

<script>
    import UtilMixins from '../../mixins/utilMixins';

    export default {
        name: 'property-search',

        mixins: [ UtilMixins ],

        data: () => ({
            timeout: null,
            whereSearch: null
        }),

        props: {

            inHeader: {
                default: false
            },

            redirect: {
                type: Boolean,
                default: true
            },

            where: {
                default: null
            }
        },

        mounted() {
            let params = this.getUrlParams();
            if (params.where) {
                this.whereSearch = params.where;
            }
        },

        methods: {
            formatSearchOption(option) {
                return option.name + ', ' + option.subdivision.abbreviation;
            },

            search() {
                if (this.redirect) {
                    var base = '/properties?';
                    if (this.whereSearch != null) {
                        base += '&where=' + this.whereSearch;
                    }
                    redirectTo(base);
                } else {
                    if (this.timeout) { clearTimeout(this.timeout) }

                    this.timeout = setTimeout(() => {
                        this.$store.commit('properties/updateSearch', { key: 'where', val: this.whereSearch });
                        this.$store.dispatch('properties/search');
                    }, 2000);
                }
            }
        },

        watch: {
            where(val) { this.whereSearch = val }
        }
    }
</script>

<style lang="sass">
    .search
        width: 100%
        padding: 10px
</style>
