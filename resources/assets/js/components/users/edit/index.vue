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
                    <li class="nav-item" :class="{ selected: selectedSection == 'profile-info' }">
                        <button @click="changeSection('profile-info')" >Basic Info</button>
                    </li>
                    <li class="nav-item" :class="{ selected: selectedSection == 'profile-description' }">
                        <button @click="changeSection('profile-description')">Description</button>
                    </li>
                    <li v-if="user.role === 'tenant'" class="nav-item" :class="{ selected: selectedSection == 'profile-references' }">
                        <button @click="changeSection('profile-references')">References<sup v-if="hasReferenceErrors()" class="form-errors">*</sup></button>
                    </li>
                    <li v-if="user.role === 'tenant'" class="nav-item" :class="{ selected: selectedSection == 'profile-history' }">
                        <button @click="changeSection('profile-history')">History<sup v-if="hasHistoryErrors()" class="form-errors">*</sup></button>
                    </li>
                    <li class="nav-item" :class="{ selected: selectedSection == 'profile-accounts' }">
                        <button @click="changeSection('profile-accounts')">Accounts</button>
                    </li>
                </ul>
            </div>
            <div id="edit-profile-content">
                <component :is="selectedSection"></component>
            </div>
        </div>
        <div class="sm-1-2">
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
                        <vue-gallery v-else-if="selectedSection == 'profile-description'" vuexSet="users/setActivePicture" vuexGet="users/activePicture" :single="true" :images="profilePicture"></vue-gallery>
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
                <div class="edit-profile-nav row">
                    <div class="xs-1-1 center-content">
                        <div>
                            <button class="left"
                                    @click="goToSection('prev')"
                                    v-if="selectedSection != 'profile-info'">Back</button>
                            <button class="right"
                                    @click="goToSection('next')">
                                {{ selectedSection != 'profile-accounts' ? 'Next' : 'Save Profile' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ErrorMixins from '../../../mixins/errorMixins';
    import ProfileAccounts from './sections/accounts';
    import ProfileDescription from './sections/description';
    import ProfileHistory from './sections/history';
    import ProfileInfo from './sections/info';
    import ProfileReferences from './sections/references';

    export default {
        name: 'profile-form',

        mixins: [ ErrorMixins ],

        components: {
            ProfileAccounts,
            ProfileDescription,
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
                'profile-references',
                'profile-history',
                'profile-accounts'
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
            user() { return this.$store.getters['users/active'] },

            profilePicture() {
                if (this.user.profile_picture_route) {
                    return [ { image: this.user.profile_picture_route, idx: 0 }];
                } else {
                    return [];
                }
            },
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
