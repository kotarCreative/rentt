<template>
    <div id="property-address-wrapper" class="creation-section-wrapper">
        <div class="tagline">
            <h2>Included Utilities</h2><h4 class="description">(Click the icons)</h4>
        </div>
        <div class="utilities">
            <div class="utility" v-for="utility in utilities" @click="selectUtil(utility.slug)" :class="{ selected: utilSelected(utility.slug) }" :id="utility.slug">
                <i class="icon" :class="utility.icon" aria-hidden="true"></i>
            </div>
        </div>
        <div class="tagline">
            <h2>Ammenities</h2><h4 class="description">(Click the icons)</h4>
        </div>
        <div class="ammenitiess">
            <div class="ammenity" v-for="ammenity in ammenities" @click="selectAmm(ammenity.slug)">
                <i class="icon" :class="ammenity.icon" aria-hidden="true"></i>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'property-creation-details',

        data() {
            return {
                selectedUtilities: [],
                selectedAmmenities: []
            }
        },

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

            ammenities() {
                return this.$store.getters['properties/ammenities'];
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

            selectAmm(amm) {
                if (this.ammSelected(amm)) {
                    var ind = this.selectedAmmenities.indexOf(amm);
                    this.selectedAmmenities.splice(ind, 1);
                } else {
                    this.selectedAmmenities.push(amm);
                }
            },

            utilSelected(util) {
                return this.selectedUtilities.indexOf(util) > -1;
            },

            ammSelected(amm) {
                return this.selectedAmmenities.indexOf(amm) > -1;
            }
        }
    }
</script>
