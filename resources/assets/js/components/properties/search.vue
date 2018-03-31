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
                        @keydown.enter="search"
                    />
                </div>
            </div>
            <div class="xs-1-1" :class="[{ 'sm-1-3': !inHeader }, { 'sm-1-2': inHeader }]">
                <div class="form-group">
                    <label for="bedroom-count"># of Bedrooms</label>
                    <v-select class="form-control no-indicator"
                              name="bedroom-count"
                              v-model="bedroomCount"
                              :options="bedroomOptions"
                              :clearable="false"
                              placeholder="Any">
                    </v-select>
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
            bedroomCount: null,
            bedroomOptions: [
                {
                    label: 'Any',
                    value: null
                },
                {
                    label: 'Studio',
                    value: 0
                },
                {
                    label: 'One',
                    value: 1
                },
                {
                    label: 'Two',
                    value: 2
                },
                {
                    label: 'Three',
                    value: 3
                },
                {
                    label: 'Four+',
                    value: 4
                },
            ],
            timeout: null,
            whereSearch: null
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
                    if (this.bedroomCount != null) { base += '&bedrooms=' + this.bedroomCount.value; }
                    redirectTo(base);
                } else {
                    if (this.timeout) { clearTimeout(this.timeout) }

                    this.timeout = setTimeout(() => {
                        if (this.bedroomCount) {
                            var val = this.bedroomCount.value;
                        } else {
                            var val = null;
                        }
                        this.$store.commit('properties/updateSearch', { key: 'bedrooms', val: val });
                        this.$store.commit('properties/updateSearch', { key: 'where', val: this.whereSearch });
                        this.$store.dispatch('properties/search');
                    }, 2000);
                }
            }
        },

        watch: {
            bedrooms(val) { this.bedroomCount = val },

            bedroomCount(val) { this.search() },

            where(val) { this.whereSearch = val }
        }
    }
</script>

<style lang="sass">
    .search
        margin-top: 18px
</style>
