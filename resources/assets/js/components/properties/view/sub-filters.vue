<template>
    <div id="property-sub-filters">
        <div class="form-group">
            <button class="btn filter" @click="homeFilterOpen = !homeFilterOpen" :class="{ open: homeFilterOpen, selected: homeTypes.length > 0 }">
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
            <button class="btn filter" @click="priceRangeOpen = !priceRangeOpen" :class="{ open: priceRangeOpen, selected: priceRange[0] !== null || priceRange[1] !== null }">
                Price
            </button>
            <div class="filter-greyout" v-if="priceRangeOpen" @click="priceRangeOpen = false"></div>
            <div id="price-range-dropdown" v-if="priceRangeOpen">
                <div class="range-input">
                    <moola class="form-control range-input__input"
                           id="from-price"
                           name="from-price"
                           v-model="priceRange[0]"
                           placeholder="Any"
                           :precision="0"
                           :min="0"
                           :max="99999"
                           :style="calculateRangeWidth(0)"></moola>
                    <span class="range-input__separator">&#45;</span>
                    <moola class="form-control range-input__input"
                           id="to-price"
                           name="to-price"
                           v-model="priceRange[1]"
                           placeholder="Any"
                           :precision="0"
                           :min="0"
                           :max="99999"
                           :style="calculateRangeWidth(1)"></moola>
                </div>
                <div class="filter-actions">
                    <label class="filter-clear">Clear</label>
                    <label class="filter-apply" @click="search">Apply</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import RangeSlider from 'vue-range-slider'

    import 'vue-range-slider/dist/vue-range-slider.css'
    export default {
        name: 'property-sub-filters',

        components: {
            RangeSlider
        },

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
            homeTypes: [],
            priceRange: [ null, null ]
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
            calculateRangeWidth(idx) {
                var len = String(this.priceRange[idx]).length;
                if (len == 0) {
                    return 'width: 35px';
                } else {
                    return 'width: ' + (len * 10 + 15 + (Math.floor(len / 3) * 3)) + 'px';
                }
            },

            clearHomeTypes() { this.homeTypes = [] },

            search() {
                this.$store.dispatch('properties/search');
            }
        },

        watch: {
            homeTypes(val) {
                this.$store.commit('properties/updateSearch', { key: 'home-types', val: val });
            },

            priceRange(val) {
                this.$store.commit('properties/updateSearch', { key: 'price-range', val: val });
            }
        }
    }
</script>
