<template>
    <div id="property-sub-filters">
        <div class="form-group">
            <button class="btn filter" @click="toggleSection('homeFilterOpen')" :class="{ open: homeFilterOpen, selected: homeTypes.length > 0 }">
                {{ homeTypesLabel }}
            </button>
            <div class="filter-greyout" v-if="homeFilterOpen" @click="toggleSection('homeFilterOpen')"></div>
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
                    <label class="filter-apply" @click="toggleSection('homeFilterOpen')">Apply</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn filter"
                    @click="toggleSection('priceRangeOpen')"
                    :class="{ open: priceRangeOpen, selected: priceRange[0] !== null || priceRange[1] !== null }"
                    v-html="priceRangeLabel">
            </button>
            <div class="filter-greyout" v-if="priceRangeOpen" @click="toggleSection('priceRangeOpen')"></div>
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
                    <label class="filter-clear" @click="clearPriceRange">Clear</label>
                    <label class="filter-apply" @click="toggleSection('priceRangeOpen')">Apply</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn filter" @click="toggleSection('moreFiltersOpen')" :class="{ open: moreFiltersOpen, selected: hasMoreFilters }">
                More Filters
            </button>
            <div class="filter-greyout" v-if="moreFiltersOpen" @click="toggleSection('moreFiltersOpen')"></div>
            <div id="more-filters-dropdown" v-if="moreFiltersOpen">
                <label for="utilities">Utilities Included</label>
                <div class="filter-utilities utilities">
                    <div class="utility-wrapper" v-for="utility in utilities">
                        <div class="utility"
                             :class="{ selected: utilSelected(utility.id) }"
                             :id="utility.slug"
                             :title="'Filter by ' + utility.name"
                             @click="selectUtility(utility.id)">
                            <i class="icon" :class="utility.icon" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="bedroom-count"># of Bedrooms</label>
                    <select
                        class="form-control full-width"
                        name="bedrooms"
                        v-model="moreFilters.bedrooms">
                        <option :value="null">Any</option>
                        <option value="0">Studio</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4+</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bathroom-count"># of Bathrooms</label>
                    <select
                        class="form-control full-width"
                        name="bathrooms"
                        v-model="moreFilters.bathrooms">
                        <option :value="null">Any</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3+</option>
                    </select>
                </div>
                <div class="filter-actions">
                    <label class="filter-clear" @click="clearMoreFilters">Clear</label>
                    <label class="filter-apply" @click="toggleSection('moreFiltersOpen')">Apply</label>
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
            orders: [{
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
            moreFilters: {
                utilityIds: [],
                bedrooms: null,
                bathrooms: null
            },
            moreFiltersOpen: false,
            priceRange: [null, null],
            priceRangeOpen: false,
            homeTypes: [],
        }),

        mounted() {
            this.$store.dispatch('properties/details');
        },

        computed: {
            hasMoreFilters() {
                return this.moreFilters.utilityIds.length > 0 || this.moreFilters.bedrooms !== null || this.moreFilters.bathrooms !== null;
            },

            homeTypesLabel() {
                let label = 'Home Type';
                if (this.homeTypes.length > 0) {
                    label = this.homeTypes.length + ' Home Type';
                    this.homeTypes.length > 1 ? label += 's' : label;
                }
                return label;
            },

            priceRangeLabel() {
                var startRange = this.priceRange[0],
                    endRange = this.priceRange[1];
                if (startRange || endRange) {
                    var startRangeText = startRange ? '&#36;' + Number(startRange).toFixed(2) : 'Any',
                        endRangeText = endRange ? '&#36;' + Number(endRange).toFixed(2) : 'Any';
                    return startRangeText + ' &#45; ' + endRangeText;
                } else {
                    return 'Price';
                }
            },

            propertyTypes() {
                return this.$store.getters['properties/types'];
            },

            utilities() {
                return this.$store.getters['properties/utilities'];
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

            clearHomeTypes() {
                this.homeTypes = [];
                this.$store.commit('properties/updateSearch', {
                    key: 'home-types',
                    val: []
                });
                this.search();
            },

            clearMoreFilters() {
                this.moreFilters = {
                    utilityIds: [],
                    bedrooms: null,
                    bathrooms: null
                };
                this.$store.commit('properties/updateSearch', {
                    key: 'more-filters',
                    val: this.moreFilters
                });
                this.search();
            },

            clearPriceRange() {
                this.priceRange = [0, 0];
                this.$store.commit('properties/updateSearch', {
                    key: 'price-range',
                    val: [0, 0]
                });
                this.search();
            },

            search() {
                this.$store.dispatch('properties/search');
            },

            selectUtility(util) {
                if (this.utilSelected(util)) {
                    this.moreFilters.utilityIds.splice(this.moreFilters.utilityIds.indexOf(util), 1);
                } else {
                    this.moreFilters.utilityIds.push(util);
                }
            },

            toggleSection(section) {
                this[section] = !this[section];
                this.search();
            },

            utilSelected(util) {
                return this.moreFilters.utilityIds ? this.moreFilters.utilityIds.indexOf(util) > -1 : false;
            }
        },

        watch: {
            homeTypes(val) {
                this.$store.commit('properties/updateSearch', {
                    key: 'home-types',
                    val: val
                });
            },

            moreFilters: {
                handler(val) {
                    this.$store.commit('properties/updateSearch', {
                        key: 'more-filters',
                        val: val
                    });
                },
                deep: true
            },

            priceRange(val) {
                this.$store.commit('properties/updateSearch', {
                    key: 'price-range',
                    val: val
                });
            }
        }
    }

</script>
