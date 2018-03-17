<template>
    <div class="single-property-wrapper">
        <vue-gallery :images="images" :view-only="true"></vue-gallery>
        <div class="single-property-info" @click="redirect">
            <div class="single-property-main-info">
                <div class="property-title">{{ property.title }}</div>
                <div class="property-price">${{ Number(property.price).toFixed(2) }}</div>
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
            }
        },

        methods: {
            redirect() {
                redirectTo('/properties/' + this.property.id);
            }
        }
    }
</script>
