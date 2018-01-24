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
                        <button @click="changeSection('property-info')" >Basic Info</button>
                    </li>
                    <li class="nav-item" :class="{ selected: selectedSection == 'property-address' }">
                        <button @click="changeSection('property-address')">Address</button>
                    </li>
                    <li class="nav-item" :class="{ selected: selectedSection == 'property-details' }">
                        <button @click="changeSection('property-details')">Details</button>
                    </li>
                    <li class="nav-item" :class="{ selected: selectedSection == 'property-photos' }">
                        <button @click="changeSection('property-photos')">Photos</button>
                    </li>
                    <li class="nav-item" :class="{ selected: selectedSection == 'property-description' }">
                        <button
                            @click="changeSection('property-description')"
                            :class="{ selected: selectedSection == 'property-description' }">
                            Description
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
                <div class="row">
                    <ul class="nav right">
                        <li class="nav-item">
                            <button id="creation-save" @click="save">save &amp; exit</button>
                        </li>
                    </ul>
                </div>
                <div id="left-side-content" class="row">
                    <div class="xs-1-1">
                        <img v-if="selectedSection == 'property-info'" src="/imgs/property-creation-info.png" width="100%">
                        <div v-if="selectedSection == 'property-details'">
                            <img src="/imgs/property-creation-utilities.png" width="100%">
                            <p>Make sure to list all of the amenities that are included in your listing...people love amenities!</p>
                        </div>
                        <vue-gallery v-else-if="selectedSection == 'property-photos'"></vue-gallery>
                        <img v-if="selectedSection == 'property-description'" src="/imgs/property-creation-description.png" width="100%">
                    </div>
                </div>
                <div class="property-creation-nav row">
                    <div class="xs-1-1">
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
</template>

<script>
    import propertyAddress from './sections/address'
    import propertyDetails from './sections/details'
    import propertyInfo from './sections/info'
    import propertyPhotos from './sections/photos'
    import propertyDescription from './sections/description'

    export default {
        name: 'property-creation',

        components: {
            propertyAddress,
            propertyDetails,
            propertyInfo,
            propertyPhotos,
            propertyDescription
        },

        data() {
            return {
                selectedSection: 'property-info',
                sections: [
                    'property-info',
                    'property-address',
                    'property-details',
                    'property-photos',
                    'property-description'
                ]
            }
        },

        methods: {
            changeSection(section) {
                this.selectedSection = section;
            },

            save() {

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
                            this.save();
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
            }
        }
    }
</script>
