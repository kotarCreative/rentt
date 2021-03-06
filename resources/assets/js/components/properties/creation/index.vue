<template>
    <div class="row with-background">
        <div class="xs-1-1 sm-1-2 scrollable">
            <div id="creation-header">
                <div class="logo-wrapper" @click="goHome">
                    <img src="/imgs/main-logo.png" />
                </div>
                <ul class="nav mobile-hide">
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
                <ul class="mobile-nav mobile-show">
                    <li class="nav-item" @click="save(property.is_active)">Save &amp; Exit</li>
                </ul>
            </div>
            <div id="new-property-content">
                <component :is="selectedSection"></component>
                <div v-if="selectedSection == 'property-address'" class="mobile-show">
                    <gmap-map :center="mapCenter"
                              :style="mapStyle"
                              :zoom="15"
                              class="property-map"
                              id="gmap"
                              ref="gmap">
                        <gmap-marker
                          :position="property.coordinates"
                            v-if="property.coordinates"
                        ></gmap-marker>
                      </gmap-map>
                </div>
                <photo-grid v-else-if="selectedSection == 'property-photos'"
                            :starting-images="property.image_routes"
                            class="mobile-show"></photo-grid>
                <div class="mobile-section-nav">
                    <div v-if="selectedSection != 'profile-info'" class="btn prev-btn"  @click="goToSection('prev')">
                        Back
                    </div>
                    <div class="btn next-btn" @click="goToSection('next')">
                        {{ selectedSection != 'property-description' ? 'Next' : 'Post Listing' }}
                    </div>
                </div>
            </div>
        </div>
        <div class="sm-1-2 secondary-bg mobile-hide">
            <div id="new-property-graphics">
                <div class="property-creation-top-nav row">
                    <ul class="nav right">
                        <li class="nav-item">
                            <button id="creation-save" @click="save(property.is_active)">save &amp; exit</button>
                        </li>
                    </ul>
                </div>
                <div id="left-side-content" class="row">
                    <div class="xs-1-1 center-content">
                        <img v-if="selectedSection == 'property-info'" src="/imgs/property-creation-info.png" width="100%">
                        <div v-else-if="selectedSection == 'property-address'">
                            <gmap-map :center="mapCenter"
                                      :style="mapStyle"
                                      :zoom="15"
                                      class="property-map"
                                      id="gmap"
                                      ref="gmap">
                                <gmap-marker
                                  :position="property.coordinates"
                                    v-if="property.coordinates"
                                ></gmap-marker>
                              </gmap-map>
                        </div>
                        <img v-else-if="selectedSection == 'property-details'" src="/imgs/property-creation-utilities.png" width="100%">
                        <photo-grid v-else-if="selectedSection == 'property-photos'" :starting-images="property.image_routes"></photo-grid>
                        <img v-else-if="selectedSection == 'property-description'" src="/imgs/property-creation-description.png" width="100%">
                    </div>
                </div>
                <div class="property-creation-nav">
                    <button class="left"
                            @click="goToSection('prev')"
                            v-if="selectedSection != 'property-info'">Back</button>
                    <button class="right"
                            @click="goToSection('next')"
                            :disabled="loading">
                        {{ selectedSection != 'property-description' ? 'Next' : property.is_active ? 'Update Listing' : 'Post Listing' }}
                    </button>
                    <loader v-if="loading" />
                </div>
            </div>
        </div>
        <finish-modal></finish-modal>
    </div>
</template>

<script>
    import ErrorMixins from '../../../mixins/errorMixins'
    import FinishModal from './modals/finish-confirmation'
    import Loader from '../../layouts/loader'
    import PhotoGrid from '../../layouts/photo-grid'
    import PropertyAddress from './sections/address'
    import PropertyDetails from './sections/details'
    import PropertyInfo from './sections/info'
    import PropertyPhotos from './sections/photos'
    import PropertyDescription from './sections/description'

    export default {
        name: 'property-creation',

        mixins: [ErrorMixins],

        components: {
            FinishModal,
            Loader,
            PhotoGrid,
            PropertyAddress,
            PropertyDetails,
            PropertyInfo,
            PropertyPhotos,
            PropertyDescription
        },

        props: {
            existing: {
                type: Object
            }
        },

        data: () => ({
            errorModel: 'properties',
            mapStyle: 'width: 100%; height: 400px',
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
            loading() {
                return this.$store.getters.hasLoading('store-property') || this.$store.getters.hasLoading('update-property');
            },

            mapCenter() {
                var  coords = this.property.coordinates;
                return coords && coords.lat && coords.lng ? this.property.coordinates : {
                    lat: 53.5444,
                    lng: -113.4909
                };
            },

            property() {
                return this.$store.getters['properties/active'];
            }
        },

        methods: {
            changeSection(section) {
                this.selectedSection = section;
            },

            goHome() {
                redirectTo('/');
            },

            finish() {
                if (this.property.is_active) {
                    this.save(true);
                } else {
                    this.$modals.show('property-finish');
                }
            },

            goToSection(direction) {
                switch (direction) {
                    case 'next':
                        var idx = this.sections.indexOf(this.selectedSection);
                        if (typeof this.sections[idx + 1] !== 'undefined') {
                            var dest = this.sections[idx + 1];
                            this.changeSection(dest);
                        } else {
                            this.finish();
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
                return this.hasError('address_line_1') || this.hasError('city_id') || this.hasError('postal');
            },

            hasDescriptionErrors() {
                return this.hasError('title') || this.hasError('available_at') || this.hasError('price') || this.hasError('damage_deposit') || this.hasError('description');
            },

            hasInfoErrors() {
                return this.hasError('type_id') || this.hasError('size') || this.hasError('bedrooms') || this.hasError('bathrooms');
            },

            hasPhotoErrors() {
                return this.hasError('images');
            },

            save(isActive = false) {
                if (this.property.id) {
                    this.$store.dispatch('properties/update', {
                        isActive: isActive
                    });
                } else {
                    this.$store.dispatch('properties/store', isActive);
                }
            }
        }
    }

</script>
