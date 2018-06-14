<template>
    <div class="row with-background">
        <div class="background xs-1-2"></div>
        <div class="background end xs-1-2"></div>
        <div class="sm-1-2 scrollable">
            <div id="creation-header">
                <div class="logo-wrapper" @click="goHome">
                    <img src="/imgs/main-logo.png" />
                </div>
                <ul class="nav">
                    <li class="nav-item" :class="{ selected: selectedSection == 'property-info' }">
                        <button @click="changeSection('property-info')" >Basic Info<sup v-if="hasInfoErrors()" class="form-errors">*</sup></button>
                    </li>
                    <li class="nav-item" :class="{ selected: selectedSection == 'property-address' }">
                        <button @click="changeSection('property-address')">Address<sup v-if="hasAddressErrors()" class="form-errors">*</sup></button>
                    </li>
                    <li class="nav-item" :class="{ selected: selectedSection == 'property-details' }">
                        <button @click="changeSection('property-details')">Details</button>
                    </li>
                    <li class="nav-item" :class="{ selected: selectedSection == 'property-photos' }">
                        <button @click="changeSection('property-photos')">Photos<sup v-if="hasPhotoErrors()" class="form-errors">*</sup></button>
                    </li>
                    <li class="nav-item" :class="{ selected: selectedSection == 'property-description' }">
                        <button
                            @click="changeSection('property-description')"
                            :class="{ selected: selectedSection == 'property-description' }">
                            Description<sup v-if="hasDescriptionErrors()" class="form-errors">*</sup>
                        </button>
                    </li>
                </ul>
            </div>
            <div id="new-property-content">
                <component :is="selectedSection"></component>
            </div>
        </div>
        <div class="sm-1-2">
            <div id="new-property-graphics">
                <div class="property-creation-top-nav row">
                    <ul class="nav right">
                        <li class="nav-item">
                            <button id="creation-save" @click="save()">save &amp; exit</button>
                        </li>
                    </ul>
                </div>
                <div id="left-side-content" class="row">
                    <div class="xs-1-1 center-content">
                        <img v-if="selectedSection == 'property-info'" src="/imgs/property-creation-info.png" width="100%">
                        <div v-else-if="selectedSection == 'property-address'">
                            <gmap-map
                                :center="mapCenter"
                                style="width: 100%; height: 500px;"
                                :zoom="15"
                                class="property-map"
                              >
                                <gmap-marker
                                  :position="property.coordinates"
                                    v-if="property.coordinates.lat"
                                ></gmap-marker>
                              </gmap-map>
                        </div>
                        <img v-else-if="selectedSection == 'property-details'" src="/imgs/property-creation-utilities.png" width="100%">
                        <vue-gallery v-else-if="selectedSection == 'property-photos'" vuexSet="properties/setActiveImages" vuexGet="properties/activeImages"></vue-gallery>
                        <img v-else-if="selectedSection == 'property-description'" src="/imgs/property-creation-description.png" width="100%">
                    </div>
                </div>
                <div class="property-creation-nav row">
                    <div class="xs-1-1 center-content">
                        <div>
                            <button class="left"
                                    @click="goToSection('prev')"
                                    v-if="selectedSection != 'property-info'">Back</button>
                            <button class="right"
                                    @click="goToSection('next')">
                                {{ selectedSection != 'property-description' ? 'Next' : 'Finished' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import errorMixins from '../../../mixins/errorMixins'
    import propertyAddress from './sections/address'
    import propertyDetails from './sections/details'
    import propertyInfo from './sections/info'
    import propertyPhotos from './sections/photos'
    import propertyDescription from './sections/description'

    export default {
        name: 'property-creation',

        mixins: [ errorMixins ],

        components: {
            propertyAddress,
            propertyDetails,
            propertyInfo,
            propertyPhotos,
            propertyDescription
        },

        props: {
            existing: {
                type: Object
            }
        },

        data: () => ({
            errorModel: 'properties',
            selectedSection: 'property-info',
            sections: [
                'property-info',
                'property-address',
                'property-details',
                'property-photos',
                'property-description'
            ]
        }),

        mounted() {
            if (this.existing && Object.keys(this.existing).length > 0) {
                this.$store.commit('properties/setActive', this.existing);
            }
            document.onreadystatechange = () => {
                if (document.readyState === 'complete') {
                    resizeScreen(0);
                }
            }
        },

        computed: {
            mapCenter() {
                return this.property.coordinates.lat ? this.property.coordinates : { lat: 53.5444, lng: -113.4909 };
            },

            property() {
                return this.$store.getters['properties/active'];
            }
        },

        methods: {
            changeSection(section) {
                this.selectedSection = section;
            },

            save(isActive = false) {
                if (this.property.id) {
                    this.$store.dispatch('properties/update', { isActive: isActive });
                } else {
                    this.$store.dispatch('properties/store', isActive);
                }
            },

            goHome() {
                redirectTo('/');
            },

            goToSection(direction) {
                switch (direction) {
                    case 'next':
                        var idx = this.sections.indexOf(this.selectedSection);
                        if (typeof this.sections[idx + 1] !== 'undefined') {
                            var dest = this.sections[idx + 1];
                            this.changeSection(dest);
                        } else {
                            this.save(true);
                        }
                        break;
                    case 'prev':
                        var idx = this.sections.indexOf(this.selectedSection);
                        if (typeof this.sections[idx - 1] !== 'undefined') {
                            var dest = this.sections[idx - 1];
                            this.changeSection(dest);
                        }
                        break;
                }
            },

            hasAddressErrors() {
                return this.hasError('address_line_1') || this.hasError('city_id') || this.hasError('postal_code');
            },

            hasDescriptionErrors() {
                return this.hasError('title') || this.hasError('available_at') || this.hasError('price') || this.hasError('damage_deposit') || this.hasError('description');
            },

            hasInfoErrors() {
                return this.hasError('type_id') || this.hasError('size') || this.hasError('bedroms') || this.hasErrors('bathrooms');
            },

            hasPhotoErrors() {
                return this.hasError('images');
            }
        }
    }
</script>
