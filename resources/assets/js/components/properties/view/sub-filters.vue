<template>
    <div id="property-sub-filters" class="row">
        <div class="rg-1-4">
            <div class="form-group">
                <select
                    class="form-control"
                    name="type"
                    v-model="search.type_id">
                    <option :value="null" disabled>Home Type</option>
                    <option v-for="type in propertyTypes" :value="type.id">
                        {{ type.name }}
                    </option>
                </select>
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
                <select
                    class="form-control"
                    name="order"
                    v-model="search.order">
                    <option v-for="order in orders" :value="order.slug">
                        {{ order.label }}
                    </option>
                </select>
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
