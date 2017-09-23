<template>
    <div id="property-address-wrapper" class="creation-section-wrapper">
        <h2>Address</h2>
        <div class="form-group">
            <label for="address_line_1">Street Address</label>
            <input
                class="form-control"
                name="address_line_1"
                type="text"
                v-model="property.address_line_1"
                placeholder="Anywhere">
        </div>
        <div class="form-group">
            <label for="address_line_2">Suite #</label>
            <input
                class="form-control"
                name="address_line_2"
                type="text"
                v-model="property.address_line_2"
                placeholder="Anywhere">
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <select
                class="form-control"
                name="type"
                v-model="property.country_id">
                <option :value="null" disabled>Any</option>
                <option v-for="country in countries" :value="country.id">{{ country.name }}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="subdivision">Province/State</label>
            <select
                class="form-control"
                name="subdivision"
                v-model="property.subdivision_id">
                <option :value="null" disabled>Any</option>
                <option v-for="subdivision in subdivisions" :value="subdivision.id">{{ subdivision.name }}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="city">City/Town</label>
            <select
                class="form-control"
                name="subdivision"
                v-model="property.city_id">
                <option :value="null" disabled>Any</option>
                <option v-for="city in cities" :value="city.id">{{ city.name }}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="postal">Postal Code</label>
            <input
                class="form-control"
                name="postal"
                type="text"
                v-model="property.postal"
                placeholder="Anywhere">
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
