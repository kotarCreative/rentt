<template>
    <div id="property-sub-filters" class="row">
        <div class="rg-1-4">
            <div class="form-group">
                <v-select class="form-control"
                          name="type"
                          v-model="search.type_id"
                          :options="propertyTypes"
                          placeholder="Home Type"
                          label="name"
                          :clearable="false">
                    <template slot="selected-option" slot-scope="option">
                        <span class="icon" :class="option.icon"></span>
                        {{ option.name }}
                    </template>
                    <template slot="option" slot-scope="option">
                        <span class="icon" :class="option.icon"></span>
                        {{ option.name }}
                    </template>
                </v-select>
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
