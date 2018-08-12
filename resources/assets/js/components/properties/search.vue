<template>
    <div id="property-search-bar">
        <div class="row">
            <div class="xs-1-1">
                <div class="form-group">
                    <vueplete name="where"
                              url="/cities"
                              v-model="whereSearch"
                              :get-option="formatSearchOption"
                              @selectOption="search"
                              placeholder='Try "Edmonton, AB"'
                              :mobile-hide="inHeader"></vueplete>
                </div>
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
                        if (typeof this.whereSearch === 'object') {
                            base += '&where=' + this.whereSearch.name + ', ' + this.whereSearch.subdivision.abbreviation;
                        } else {
                            base += '&where=' + this.whereSearch;
                        }
                    }
                    redirectTo(base);
                } else {
                    if (this.timeout) { clearTimeout(this.timeout) }

                    this.timeout = setTimeout(() => {
                        var search;
                        if (typeof this.whereSearch === 'object') {
                            search = this.whereSearch.name + ', ' + this.whereSearch.subdivision.abbreviation;
                        } else {
                            search = this.whereSearch;
                        }
                        this.$store.commit('properties/updateSearch', { key: 'where', val: search });
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
