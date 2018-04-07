<template>
    <div id="single-property-overview">
        <vue-gallery :images="images" :view-only="true"></vue-gallery>

        <div class="overview">
            <gmap-map
                :center="property.coordinates"
                style="width: 100%;"
                :zoom="15"
                class="property-listings-map"
              >
                <gmap-marker :position="property.coordinates"
                ></gmap-marker>
              </gmap-map>
            <div class="property-pricing-wrapper">
                <div class="property-pricing">
                    <div class="property-rent">&#36;{{ parseInt(property.price).toFixed(0) }}/month</div>
                    <div class="damage-deposit"
                         v-if="property.damage_deposit">&#43; &#36;{{ parseInt(property.damage_deposit).toFixed(0) }} damage deposit</div>
                    <button class="btn small" @click="contactOwner" v-if="property.user_id != user.id">
                        Contact Owner
                    </button>
                </div>
                <div class="property-utilities">
                    <div class="utilities">
                        <div class="utility-title">Included Utilities</div>
                        <div class="utility-wrapper" v-for="utility in utilities">
                            <div class="utility" :class="{ selected: utilSelected(utility.id) }" :id="utility.slug" :title="utility.name">
                                <i class="icon" :class="utility.icon" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="share-icons">
                        <div class="share-title">Share</div>
                        <a class="share-wrapper" v-for="share in shares" :href="generateLink(share.type)" :target="share.target">
                            <img :src="share.img" :alt="share.alt" :title="share.title" width="25" height="25" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'single-property-overview',

        mounted() {
            // Make the map square
            this.squareMap()
            window.addEventListener('resize', this.squareMap);
        },

        data: () => ({
            shares: [
                {
                    type: 'facebook',
                    img: '/imgs/facebook-icon.svg',
                    alt: 'Share this listing on Facebook',
                    title: 'Share on Facebook',
                    target: '_blank'
                },
                {
                    type: 'twitter',
                    img: '/imgs/twitter-icon.svg',
                    alt: 'Share this listing on Twitter',
                    title: 'Share on Twitter',
                    target: '_blank'
                },
                {
                    type: 'email',
                    img: '/imgs/email-icon.svg',
                    alt: 'Share this listing by email',
                    title: 'Share with Email',
                    target: '_self'
                }
            ]
        }),

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

            property() { return this.$store.getters['properties/active'] },

            user() { return this.$store.getters['users/active'] },

            utilities() {
                return this.$store.getters['properties/utilities'];
            }
        },

        methods: {
            contactOwner() { this.user ? this.$modals.show('contact-owner') : this.$modals.show('login') },

            generateLink(type) {
                switch(type) {
                    case 'facebook':
                        return 'https://www.facebook.com/sharer/sharer.php?u=http://rentt.io/properties/' + this.property.id;
                    case 'twitter':
                        return 'https://twitter.com/home?status=http://rentt.io/properties/' + this.property.id;
                    case 'email':
                        return 'mailto:?&subject=Look at this property for rent&body=I%20was%20looking%20through%20Rentt.io%20for%20a%20new%20place%20to%20rent%20and%20found%20this%20listing.%20What%20do%20you%20think?%20http://rentt.io/properties/' + + this.property.id;
                }
            },

            squareMap() {
                let map = this.$el.getElementsByClassName('property-listings-map')[0];
                map.style.height = map.offsetWidth + 'px';
            },

            utilSelected(util) {
                return this.property.utilityIds.indexOf(util) > -1;
            }
        }
    }
</script>
