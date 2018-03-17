<template>
    <div>
        <div class="single-property-section property-details">
            <div class="property-detail">
                <i class="icon" :class="property.type.icon" aria-hidden="true"></i>
                <div class="detail-label secondary">{{ property.type.name }}</div>
            </div>
            <div class="property-detail">
                <i class="icon bedrooms" aria-hidden="true"></i>
                <div class="detail-label secondary">{{ property.bedrooms }} Bdrm</div>
            </div>
            <div class="property-detail">
                <i class="icon bathrooms" aria-hidden="true"></i>
                <div class="detail-label secondary">{{ property.bathrooms }} Bthrm</div>
            </div>
            <div class="property-detail">
                <i class="icon size" aria-hidden="true"></i>
                <div class="detail-label secondary">{{ parseInt(property.size).toFixed(0) }} sqft</div>
            </div>
        </div>
        <div class="single-property-section property-desc">
            <p>{{ property.description }}</p>
        </div>
        <div class="single-property-section property-amenities">
            <div class="tagline">
                <h5>Amenities</h5>
            </div>
            <div class="amenities">
                <div class="amenity" v-for="amenity in amenities" :class="{ selected: amSelected(amenity.id) }">
                    <div>
                        <i class="icon" :class="amenity.icon" aria-hidden="true"></i>
                    </div>
                    <h5 v-html="amenity.name.replace(/\s/g, '<br>')"></h5>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'single-property-details',

        props: {
            property: {
                type: Object,
                required: true
            }
        },

        mounted() { this.$store.dispatch('properties/details') },

        computed: {
            amenities() {
                return this.$store.getters['properties/amenities'];
            },

            utilities() {
                return this.$store.getters['properties/utilities'];
            },
        },

        methods: {
            amSelected(am) {
                return this.property.amenityIds.indexOf(am) > -1;
            }
        }
    }
</script>