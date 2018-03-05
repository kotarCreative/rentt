<template>
    <div id="property-search-bar">
        <div class="row">
            <div class="xs-1-1" :class="[{ 'sm-1-3': !inHeader }, { 'sm-1-2': inHeader }]">
                <div class="form-group">
                    <label for="where">Where</label>
                    <input
                        class="form-control"
                        type="text"
                        name="where"
                        placeholder="Anywhere"
                        v-model="whereSearch"
                    />
                </div>
            </div>
            <div class="xs-1-1" :class="[{ 'sm-1-3': !inHeader }, { 'sm-1-2': inHeader }]">
                <div class="form-group">
                    <label for="bedroom-count"># of Bedrooms</label>
                    <select class="form-control"
                            name="bedrooms"
                            v-model="bedroomCount">
                        <option :value="null" disabled>Any</option>
                        <option value="0">Studio</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4+</option>
                    </select>
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
    export default {
        name: 'property-search',

        data: () => ({
            whereSearch: null,
            bedroomCount: null
        }),

        props: {
            bedrooms: {
                default: null
            },

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

        methods: {
            search() {
                if (this.redirect) {
                    var base = '/properties?';
                    if (this.whereSearch != null) { base += '&where=' + this.whereSearch; }
                    if (this.bedroomCount != null) { base += '&bedrooms=' + this.bedroomCount; }
                    redirectTo(base);
                } else {
                    let params = {
                        where: this.whereSearch,
                        bedrooms: this.bedroomCount
                    };
                    this.$store.dispatch('properties/search', params);
                }
            }
        },

        watch: {
            bedrooms(val) { this.bedroomCount = val },

            where(val) { this.whereSearch = val }
        }
    }
</script>

<style lang="sass">
    .search
        margin-top: 18px
</style>
