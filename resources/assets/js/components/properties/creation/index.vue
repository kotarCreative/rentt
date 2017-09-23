<template>
    <div class="row with-background">
        <div class="background xs-1-2"></div>
        <div class="background end xs-1-2"></div>
        <div class="content">
            <div class="sm-1-2">
                <div id="creation-header">
                    <div class="logo-wrapper">
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
                    <div class="section" v-for="section in sections" v-if="selectedSection == section" >
                        <component :is="section">
                        </component>
                    </div>
                    <div v-else></div>
                </div>
            </div>
            <div class="sm-1-2">
                <div id="new-property-graphics">
                    <ul class="nav right">
                        <li class="nav-item">
                            <button id="creation-save" @click="save">save &amp; exit</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import propertyAddress from './sections/address'
    import propertyDetails from './sections/details'
    import propertyInfo from './sections/info'

    export default {
        name: 'property-creation',

        components: {
            propertyAddress,
            propertyDetails,
            propertyInfo
        },

        data() {
            return {
                selectedSection: 'property-info',
                sections: [
                    'property-address',
                    'property-details',
                    'property-info'
                ]
            }
        },

        methods: {
            changeSection(section) {
                this.selectedSection = section;
            },

            save() {

            }
        }
    }
</script>
