<template>
    <div class="profile-info-wrapper">
        <div class="profile-info-header" @click="goToProfile">
            <div class="profile-picture-wrapper" v-if="type === 'property'">
                <img v-if="profile.profile_picture_route"
                     :src="profile.profile_picture_route"
                     :title="profile.first_name + ' profile picture'"
                     :alt="profile.first_name + ' profile picture'"
                     width="80"
                     height="80"
                     class="profile-picture">
                <img v-else src="/imgs/profile.png" title="Profile Picture" alt="Empty profile picture" width="80" height="80">
            </div>
            <div class="profile-info">
                <div v-html="nameHeader"></div>
                <h5>{{ profile.location ? profile.location + ' &#45;' : '' }} Joined in {{ new Date(profile.created_at).format('M Y') }}</h5>
                <h5 v-if="profile.languages && profile.languages.length > 0">Languages: {{ profile.languages.join(', ') }}</h5>
            </div>
        </div>
        <div class="profile-desc">
            <p>{{ profile.description }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'profile-info',

        props: {
            profile: {
                type: Object,
                required: true
            },

            type: {
                type: String
            }
        },

        computed: {
            activeUser() {
                return this.$store.getters['users/active'];
            },

            nameHeader() {
                var userName = this.profile.first_name ? this.profile.first_name : 'Unknown';
                switch (this.type) {
                    case 'property':
                        return '<h3>Listed By ' + userName + '</h3>';

                    case 'profile':
                        if (this.activeUser.id !== this.profile.id) {
                            return '<h1>Hi, I\'m ' + userName + '</h1>';
                        } else {
                            return '<h1>Hi, I\'m ' + userName + '&nbsp;<a class="link" href="/profile/edit">edit</a></h1>';
                        }
                }
            }
        },

        methods: {
            goToProfile() {
                if (this.type == 'property') {
                    redirectTo('/profile/' + this.profile.id);
                }
            }
        }
    }
</script>
