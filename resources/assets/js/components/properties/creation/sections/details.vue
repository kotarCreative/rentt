<template>
    <div id="property-details-wrapper" class="creation-section-wrapper">
        <div class="tagline">
            <h2>Included Utilities</h2><h4 class="description">(Click the icons)</h4>
        </div>
        <div class="utilities">
            <div class="utility" v-for="utility in utilities" @click="selectUtil(utility.slug)" :class="{ selected: utilSelected(utility.slug) }" :id="utility.slug">
                <i class="icon" :class="utility.icon" aria-hidden="true"></i>
            </div>
        </div>
        <div class="tagline">
            <h2>Amenities</h2><h4 class="description">(Click the icons)</h4>
        </div>
        <div class="amenities">
            <div class="amenity" v-for="amenity in amenities" @click="selectAm(amenity.slug)" :class="{ selected: amSelected(amenity.slug) }">
                <div>
                    <i class="icon" :class="amenity.icon" aria-hidden="true"></i>
                </div>
                <h5 v-html="amenity.name.replace(/\s/g, '<br>')"></h5>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'property-creation-details',

        mounted() {
            this.$store.dispatch('properties/details');
        },

        computed: {
            property() {
                return this.$store.getters['properties/active'];
            },

            utilities() {
                return this.$store.getters['properties/utilities'];
            },

            amenities() {
                return this.$store.getters['properties/amenities'];
            },

            selectedUtilities() {
                return this.$store.getters['properties/active'].utilities;
            },

            selectedAmenities() {
                return this.$store.getters['properties/active'].amenities;
            }
        },

        methods: {
            selectUtil(util) {
                if (this.utilSelected(util)) {
                    var ind = this.selectedUtilities.indexOf(util);
                    this.selectedUtilities.splice(ind, 1);
                } else {
                    this.selectedUtilities.push(util);
                }
            },

            selectAm(am) {
                if (this.amSelected(am)) {
                    var ind = this.selectedAmenities.indexOf(am);
                    this.selectedAmenities.splice(ind, 1);
                } else {
                    this.selectedAmenities.push(am);
                }
            },

            utilSelected(util) {
                return this.selectedUtilities.indexOf(util) > -1;
            },

            amSelected(am) {
                return this.selectedAmenities.indexOf(am) > -1;
            }
        }
    }
</script>
