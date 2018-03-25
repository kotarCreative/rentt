<template>
    <div id="property-sub-filters">
        <div class="form-group">
            <button class="btn filter" @click="homeFilterOpen = !homeFilterOpen" :class="[{ open: homeFilterOpen }, { selected: homeTypes.length > 0 }]">
                {{ homeTypesLabel }}
            </button>
            <div class="filter-greyout" v-if="homeFilterOpen" @click="homeFilterOpen = false"></div>
            <div id="home-type-dropdown" v-if="homeFilterOpen">
                <div v-for="prop in propertyTypes">
                    <v-checkbox v-model="homeTypes"
                                :check-val="prop.id"
                                :name="prop.name"
                                type="checkbox">
                        <span slot="label">{{ prop.name }}</span>
                    </v-checkbox>
                </div>
                <div class="filter-actions">
                    <label class="filter-clear" @click="clearHomeTypes">Clear</label>
                    <label class="filter-apply" @click="search">Apply</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn filter" @click="priceRangeOpen = !priceRangeOpen" :class="{ open: priceRangeOpen }">
                Price
            </button>
            <div class="filter-greyout" v-if="priceRangeOpen" @click="priceRangeOpen = false"></div>
            <div id="price-range-dropdown" v-if="priceRangeOpen">
                <div class="filter-actions">
                    <label class="filter-clear">Clear</label>
                    <label class="filter-apply" @click="search">Apply</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'property-sub-filters',

        data: () => ({
            homeFilterOpen: false,
            orders: [
                {
                    slug: 'newest',
                    label: 'Newest'
                },
                {
                    slug: 'price-asc',
                    label: 'Price Asc'
                },
                {
                    slug: 'price-desc',
                    label: 'Price Desc'
                }
            ],
            priceRangeOpen: false,
            homeTypes: []
        }),

        mounted() {
            this.$store.dispatch('properties/details');
        },

        computed: {
            homeTypesLabel() {
                let label = 'Home Type';
                if (this.homeTypes.length > 0) {
                    label = this.homeTypes.length + ' Home Type';
                    this.homeTypes.length > 1 ? label += 's' : label;
                }
                return label;
            },

            propertyTypes() {
                return this.$store.getters['properties/types'];
            }
        },

        methods: {
            clearHomeTypes() { this.homeTypes = [] },

            search() {
                this.$store.dispatch('properties/search');
            }
        },

        watch: {
            homeTypes(val) {
                this.$store.commit('properties/updateSearch', { key: 'home-types', val: val });
            }
        }
    }
</script>
