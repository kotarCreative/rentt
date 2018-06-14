<template>
    <div class="single-property-wrapper" @mouseover="highlightPin(true)" @mouseout="highlightPin(false)">
        <div class="single-property-header">
            <div v-if="showSettings" class="single-property-status" :class="{ 'is-active': property.is_active }" v-html="propertyStatus">
            </div>
            <button v-if="showSettings" class="btn property-settings-btn" @click="updateSettings">
                <img src="/imgs/settings_icon.png">
            </button>
        </div>
        <vue-gallery :images="images" :view-only="true" :redirect-url="redirectUrl"></vue-gallery>
        <div class="single-property-info" @click="redirect">
            <div class="single-property-details">
                <div class="property-price">&#36;{{ parseInt(property.price) || 0 }}</div>
                <div class="property-utilities utilities">
                    <div class="utility-wrapper" v-for="utility in utilities">
                        <div class="utility" :class="{ selected: utilSelected(utility.id) }" :id="utility.slug" :title="utility.name">
                            <i class="icon" :class="utility.icon" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-property-main-info">
                <div class="property-title">{{ property.title }}</div>
            </div>
            <div class="single-property-sub-info">
                <div v-if="property.type" class="property-type">{{ property.type }},</div>
                <div v-if="property.bedrooms" class="property-beds">{{ property.bedrooms }} Bed,</div>
                <div v-if="property.bathrooms" class="property-baths">{{ property.bathrooms }} Bath</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'single-property',

        props: {
            hoverActive: {
                type: Boolean,
                default: true
            },

            property: {
                type: Object,
                required: true
            },

            showSettings: {
                type: Boolean,
                default: false
            }
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

            propertyStatus() {
                if (this.property.is_active) {
                    return 'Active';
                }

                if (this.property.is_occupied) {
                    return 'Occupied';
                }

                return 'Inactive';
            },

            redirectUrl() {
                return '/properties/' + this.property.id;
            },

            utilities() {
                return this.$store.getters['properties/utilities'];
            }
        },

        methods: {
            highlightPin(highlight) {
                if (this.hoverActive) {
                    let el = document.getElementById('property-tooltip-' + this.property.id);
                    highlight && el ? el.classList.add('hovered') : el.classList.remove('hovered');
                }
            },

            redirect() {
                redirectTo('/properties/' + this.property.id, true);
            },

            updateSettings() {
                this.$store.commit('properties/setActive', this.property);
                this.$modals.show('property-settings');
            },

            utilSelected(util) {
                return this.property.utilityIds ? this.property.utilityIds.indexOf(util) > -1 : false;
            }
        }
    }
</script>
