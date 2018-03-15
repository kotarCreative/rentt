<template>
    <div id="property-sub-filters" class="row">
        <div class="rg-1-4">
            <div class="form-group">
                <button class="btn filter" @click="homeFilterOpen = !homeFilterOpen">
                    Home Type
                </button>
                <div class="filter-greyout" v-if="homeFilterOpen" @click="homeFilterOpen = false"></div>
                <div id="home-type-dropdown" v-if="homeFilterOpen">
                    <div v-for="prop in propertyTypes">
                        <v-checkbox v-model="search.propertyTypes"
                                    :check-val="prop.id"
                                    :name="prop.name"
                                    type="checkbox">
                            <span slot="label">{{ prop.name }}</span>
                        </v-checkbox>
                    </div>
                </div>
            </div>
        </div>
        <div class="rg-1-4">
            <div class="form-group">
            </div>
        </div>
        <div class="rg-1-4">
            <div class="form-group">
            </div>
        </div>
        <div class="rg-1-4">
            <div class="form-group">
                <v-select class="form-control"
                          name="type"
                          v-model="search.order"
                          :options="orders"
                          :clearable="false"></v-select>
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
            ]
        }),

        mounted() {
            this.$store.dispatch('properties/details');
        },

        computed: {
            propertyTypes() {
                return this.$store.getters['properties/types'];
            },

            search() { return this.$store.getters['properties/search'] }
        }
    }
</script>
