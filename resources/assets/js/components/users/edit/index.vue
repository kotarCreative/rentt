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
                    <li class="nav-item" :class="{ selected: selectedSection == 'profile-references' }">
                        <button @click="changeSection('profile-references')">References</button>
                    </li>
                    <li class="nav-item" :class="{ selected: selectedSection == 'profile-history' }">
                        <button @click="changeSection('profile-history')">History</button>
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

        </div>
    </div>
</template>

<script>
    import ProfileAccounts from './sections/accounts';
    import ProfileDescription from './sections/description';
    import ProfileHistory from './sections/history';
    import ProfileInfo from './sections/info';
    import ProfileReferences from './sections/references';

    export default {
        name: 'profile-form',

        components: {
            ProfileAccounts,
            ProfileDescription,
            ProfileHistory,
            ProfileInfo,
            ProfileReferences
        },

        data: () => ({
            selectedSection: 'profile-info',
            sections: [
                'profile-info',
                'profile-description',
                'profile-references',
                'profile-history',
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
            }
        }
    }
</script>
