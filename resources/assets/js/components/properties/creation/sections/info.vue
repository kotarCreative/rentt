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
                <option v-for="type in propertyTypes" :value="type.id">{{ type.name }}</option>
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
            <input
                class="form-control"
                name="bedrooms"
                type="text"
                v-model="property.bedrooms"
                placeholder="Any">
        </div>
        <div class="form-group">
            <label for="bathrooms">Bathrooms</label>
            <input
                class="form-control"
                name="bathrooms"
                type="text"
                v-model="property.bathrooms"
                placeholder="Any">
        </div>
    </div>
</template>

<script>
    export default {
        name: 'property-creation-info',

        computed: {
            property() {
                return this.$store.getters['properties/active'];
            }
        }
    }
</script>
