<template>
    <div id="property-info-wrapper" class="creation-section-wrapper">
        <h2>Basic Info</h2>
        <div class="form-group">
            <label for="type">Home Type</label>
            <select
                class="form-control"
                name="type"
                v-model="property.type">
                <option :value="null" disabled>Any</option>
                <option v-for="type in propertyTypes" :value="type.id">
                    <i class="icon bedrooms" :class="type.icon" aria-hidden="true"></i>{{ type.name }}
                </option>
            </select>
        </div>
        <div class="form-group">
            <label for="size">Size (sq.ft.)</label>
            <input
                class="form-control"
                name="size"
                type="text"
                v-model="property.size"
                placeholder="Any">
        </div>
        <div class="form-group">
            <label for="bedrooms">Bedrooms</label>
            <select
                class="form-control"
                name="bedrooms"
                v-model="property.bedrooms">
                <option :value="null" disabled>Any</option>
                <option value="0">Studio</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4+</option>
            </select>
        </div>
        <div class="form-group">
            <label for="bathrooms">Bathrooms</label>
            <select
                class="form-control"
                name="bathrooms"
                v-model="property.bathrooms">
                <option :value="null" disabled>Any</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3+</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'property-creation-info',

        mounted() {
            this.$store.dispatch('properties/details');
        },

        computed: {
            property() {
                return this.$store.getters['properties/active'];
            },

            propertyTypes() {
                return this.$store.getters['properties/types'];
            }
        }
    }
</script>
