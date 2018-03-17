<template>
    <div id="single-property-overview">
        <vue-gallery :images="images" :view-only="true"></vue-gallery>

        <div class="overview">
            <gmap-map
                :center="property.coordinates"
                style="width: 100%; height: 300px;"
                :zoom="15"
                class="property-listings-map"
              >
                <gmap-marker :position="property.coordinates"
                ></gmap-marker>
              </gmap-map>
            <div class="property-pricing-wrapper">
                <div class="property-pricing">
                    <div class="property-rent">&#36;{{ parseInt(property.price).toFixed(2) }}/month</div>
                    <div class="damage-deposit"
                         v-if="property.damage_deposit">&#43; &#36;{{ parseInt(property.damage_deposit).toFixed(2) }} damage deposit</div>
                    <button class="btn small" @click="contactOwner">
                        Contact Owner
                    </button>
                </div>
                <div class="property-utilities">
                    <div class="utilities">
                        <div class="utility-title">Included Utilities</div>
                        <div class="utility-wrapper" v-for="utility in utilities">
                            <div class="utility" :class="{ selected: utilSelected(utility.id) }" :id="utility.slug">
                                <i class="icon" :class="utility.icon" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="share-icons">
                        <div class="share-title">Share</div>
                        <div class="share-wrapper" v-for="utility in utilities">
                            <div class="share-icon" :class="{ selected: utilSelected(utility.id) }" :id="utility.slug">
                                <i class="icon" :class="utility.icon" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'single-property-overview',

        props: {
            property: {
                type: Object,
                required: true
            }
        },

        mounted() {
            // Make the map square
            let map = this.$el.getElementsByClassName('property-listings-map')[0];
            map.style.height = map.offsetWidth + 'px';
        },

        computed: {
            images() {
                let images = [];

                if (this.property.image_routes) {
                    this.property.image_routes.forEach((image, idx) => {
                        images.push({ image: image, idx: idx });
                    });
                }
                return images;
            },

            utilities() {
                return this.$store.getters['properties/utilities'];
            }
        },

        methods: {
            contactOwner() {},

            utilSelected(util) {
                return this.property.utilityIds.indexOf(util) > -1;
            }
        }
    }
</script>