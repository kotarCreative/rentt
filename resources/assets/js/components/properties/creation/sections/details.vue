<template>
    <div id="property-address-wrapper" class="creation-section-wrapper">
        <div class="tagline">
            <h2>Included Utilities</h2><h4 class="description">(Click the icons)</h4>
        </div>
        <div class="utilities">
            <div class="utility" v-for="utility in utilities" @click="select(utility)">
                <i class="icon" :class="utility.icon" aria-hidden="true"></i>
            </div>
        </div>
        <div class="tagline">
            <h2>Ammenities</h2><h4 class="description">(Click the icons)</h4>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'property-creation-details',

        computed: {
            property() {
                return this.$store.getters['properties/active'];
            },

            utilities() {
                return this.$store.getters['properties/utilities'];
            }
        },

        methods: {
            select(utility) {

            }
        }
    }
</script>
