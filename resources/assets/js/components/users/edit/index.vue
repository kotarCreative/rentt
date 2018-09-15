<template>
    <div class="row full-height">
        <div class="xs-1-1 sm-1-2 scrollable">
            <div id="creation-header">
                <div class="logo-wrapper" @click="goHome">
                    <img src="/imgs/main-logo.png" />
                </div>
                <ul class="nav mobile-hide">
                    <li class="nav-item" :class="{ selected: selectedSection == 'profile-info' }">
                        <button @click="changeSection('profile-info')" >Basic Info</button>
                    </li>
                    <li class="nav-item" :class="{ selected: selectedSection == 'profile-description' }">
                        <button @click="changeSection('profile-description')">Description</button>
                    </li>
                    <li class="nav-item" :class="{ selected: selectedSection == 'profile-details' }">
                        <button @click="changeSection('profile-details')">Details</button>
                    </li>
                    <li v-if="user.role === 'tenant'" class="nav-item" :class="{ selected: selectedSection == 'profile-references' }">
                        <button @click="changeSection('profile-references')">References<sup v-if="hasReferenceErrors()" class="form-errors">*</sup></button>
                    </li>
                    <li v-if="user.role === 'tenant'" class="nav-item" :class="{ selected: selectedSection == 'profile-history' }">
                        <button @click="changeSection('profile-history')">History<sup v-if="hasHistoryErrors()" class="form-errors">*</sup></button>
                    </li>
                    <li v-if="user.role === 'landlord'" class="nav-item" :class="{ selected: selectedSection == 'profile-accounts' }">
                        <button @click="changeSection('profile-accounts')">Accounts</button>
                    </li>
                </ul>
                <ul class="mobile-nav mobile-show">
                    <li class="nav-item" @click="save">Save &amp; Exit</li>
                </ul>
            </div>
            <div id="edit-profile-content">
                <component :is="selectedSection"></component>
                <template v-if="selectedSection == 'profile-description'"  >
                    <photo-grid class="mobile-show" :single-photo="true" :starting-images="[ user.profile_picture ]"></photo-grid>
                    <p class="photo-upload-desc mobile-show">Click {{ user.profile_picture ? 'your existing profile picture' : 'the grey box' }} to upload a new photo.</p>
                </template>
                <div class="mobile-section-nav">
                    <div v-if="selectedSection != 'profile-info'" class="btn prev-btn"  @click="goToSection('prev')">
                        Back
                    </div>
                    <div class="btn next-btn" @click="goToSection('next')">
                        {{ selectedSection != 'profile-accounts' ? 'Next' : 'Save Profile' }}
                    </div>
                </div>
            </div>
        </div>
        <div class="sm-1-2 secondary-bg mobile-hide">
            <div id="edit-profile-graphics">
                <div class="edit-profile-top-nav row">
                    <ul class="nav right">
                        <li class="nav-item">
                            <button id="creation-save" @click="save()">save &amp; exit</button>
                        </li>
                    </ul>
                </div>
                <div id="left-side-content" class="row">
                    <div class="xs-1-1 center-content">
                        <div v-if="selectedSection == 'profile-info'">
                            <img src="/imgs/profile-edit-info.png" width="100%">
                            <p class="text-center">We always keep your info confidential and safe.</p>
                        </div>
                        <template v-else-if="selectedSection == 'profile-description'"  >
                            <photo-grid :single-photo="true" :starting-images="[ user.profile_picture ]"></photo-grid>
                            <p class="photo-upload-desc">Click {{ user.profile_picture ? 'your existing profile picture' : 'the grey box' }} to upload a new photo.</p>
                        </template>
                        <div v-else-if="selectedSection == 'profile-references'">
                            <img src="/imgs/profile-edit-references.png" width="100%">
                            <p class="text-center">Let others talk about how great of a tenant you are.</p>
                        </div>
                        <div v-else-if="selectedSection == 'profile-history'" >
                            <img src="/imgs/profile-edit-history.png" width="100%">
                            <p class="text-center">Knowing where else you have lived can really help a landlord choose a tenant.</p>
                        </div>
                        <div v-else-if="selectedSection == 'profile-accounts'">
                            <img src="/imgs/profile-edit-accounts.png" width="100%">
                            <p class="text-center">Connect to other accounts to show off more of your great qualities.</p>
                        </div>
                    </div>
                </div>
                <div class="edit-profile-nav">
                    <button class="left"
                            @click="goToSection('prev')"
                            v-if="selectedSection != 'profile-info'">Back</button>
                    <button class="right"
                            @click="goToSection('next')"
                            :disabled="loading">
                        {{ selectedSection != 'profile-accounts' ? 'Next' : 'Save Profile' }}
                    </button>
                    <loader v-if="loading" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ErrorMixins from '../../../mixins/errorMixins';
    import Loader from '../../layouts/loader';
    import PhotoGrid from '../../layouts/photo-grid'
    import ProfileAccounts from './sections/accounts';
    import ProfileDescription from './sections/description';
    import ProfileDetails from './sections/details';
    import ProfileHistory from './sections/history';
    import ProfileInfo from './sections/info';
    import ProfileReferences from './sections/references';

    export default {
        name: 'profile-form',

        mixins: [ ErrorMixins ],

        components: {
            Loader,
            PhotoGrid,
            ProfileAccounts,
            ProfileDescription,
            ProfileDetails,
            ProfileHistory,
            ProfileInfo,
            ProfileReferences
        },

        data: () => ({
            errorModel: 'users',
            selectedSection: 'profile-info',
            tenantSections: [
                'profile-info',
                'profile-description',
                'profile-details',
                'profile-references',
                'profile-history'
            ],
            landlordSections: [
                'profile-info',
                'profile-description',
                'profile-accounts'
            ]
        }),

        mounted() {
            document.onreadystatechange = () => {
                if (document.readyState === 'complete') {
                    resizeScreen(0);
                }
            }
        },

        computed: {
            loading() {
                return this.$store.getters.hasLoading('update-user');
            },

            user() { return this.$store.getters['users/active'] },
        },

        methods: {
            changeSection(section) {
                this.selectedSection = section;
            },

            goHome() {
                redirectTo('/');
            },

            goToSection(direction) {
                switch (direction) {
                    case 'next':
                        var idx = this[this.user.role + 'Sections'].indexOf(this.selectedSection);
                        if (typeof this[this.user.role + 'Sections'][idx + 1] !== 'undefined') {
                            var dest = this[this.user.role + 'Sections'][idx + 1];
                            this.changeSection(dest);
                        } else {
                            this.save();
                        }
                        break;
                    case 'prev':
                        var idx = this[this.user.role + 'Sections'].indexOf(this.selectedSection);
                        if (typeof this[this.user.role + 'Sections'][idx - 1] !== 'undefined') {
                            var dest = this[this.user.role + 'Sections'][idx - 1];
                            this.changeSection(dest);
                        }
                        break;
                }
            },

            hasHistoryErrors() {
                return this.checkGeneralError('rental_history');
            },

            hasReferenceErrors() {
                return this.checkGeneralError('references');
            },

            save() {
                this.$store.dispatch('users/update');
            }
        }
    }
</script>

<style lang="sass">
  .photo-upload-desc
    width: 100%
    max-width: 500px
    margin: 10px auto 0px auto
</style>
