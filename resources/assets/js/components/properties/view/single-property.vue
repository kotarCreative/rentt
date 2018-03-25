<template>
    <div class="single-property-wrapper" @mouseover="highlightPin(true)" @mouseout="highlightPin(false)">
        <vue-gallery :images="images" :view-only="true"></vue-gallery>
        <div class="single-property-info" @click="redirect">
            <div class="single-property-details">
                <div class="property-utilities utilities">
                    <div class="utility-wrapper" v-for="utility in utilities">
                        <div class="utility" :class="{ selected: utilSelected(utility.id) }" :id="utility.slug" :title="utility.name">
                            <i class="icon" :class="utility.icon" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="property-price">${{ Number(property.price).toFixed(2) }}</div>
            </div>
            <div class="single-property-main-info">
                <div class="property-title">{{ property.title }}</div>
            </div>
            <div class="single-property-sub-info">
                <div class="property-type">{{ property.type }},</div>
                <div class="property-beds">{{ property.bedrooms }} Bed,</div>
                <div class="property-baths">{{ property.bathrooms }} Bath</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'single-property',

        props: {
            property: {
                type: Object,
                required: true
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

            utilities() {
                return this.$store.getters['properties/utilities'];
            }
        },

        methods: {
            highlightPin(highlight) {
                let el = document.getElementById('property-tooltip-' + this.property.id);
                highlight && el ? el.classList.add('hovered') : el.classList.remove('hovered');
            },

            redirect() {
                redirectTo('/properties/' + this.property.id, true);
            },

            utilSelected(util) {
                return this.property.utilityIds ? this.property.utilityIds.indexOf(util) > -1 : false;
            }
        }
    }
</script>
