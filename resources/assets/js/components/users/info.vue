<template>
    <div class="profile-info-wrapper">
        <div class="profile-info-header">
            <div class="profile-picture-wrapper" v-if="type === 'property'" @click="goToProfile">
                <img v-if="profile.profile_picture"
                     :src="profile.profile_picture"
                     :title="profile.first_name + ' profile picture'"
                     :alt="profile.first_name + ' profile picture'"
                     width="80"
                     height="80"
                     class="profile-picture">
                <img v-else src="/imgs/profile.png" title="Profile Picture" alt="Empty profile picture" width="80" height="80">
            </div>
            <div class="profile-info">
                <div v-html="nameHeader" @click="goToProfile"></div>
                <h5>{{ profile.location ? profile.location + ' &#45;' : '' }} Joined in {{ new Date(profile.created_at).format('M Y') }}</h5>
                <h5 v-if="profile.languages && profile.languages.length > 0" class="secondary">Languages: {{ profile.languages.map(l => l.name).join(', ') }}</h5>
                <div class="linked-accounts">
                    <div class="account">
                        <div class="icon-wrapper reviews">
                            <h5>{{ profile.review_count }}</h5>
                        </div>
                        <h5>Reviews</h5>
                    </div>
                    <a v-if="profile.linked_in_url" class="account" :href="'https://' + profile.linked_in_url" target="_blank">
                        <div class="icon-wrapper">
                            <img src="/imgs/linkedin-logo.png">
                        </div>
                        <h5>LinkedIn</h5>
                    </a>
                    <a v-if="profile.airbnb_url" class="account" :href="'https://' + profile.airbnb_url" target="_blank">
                        <div class="icon-wrapper">
                            <img src="/imgs/airbnb-logo.png">
                        </div>
                        <h5>Airbnb</h5>
                    </a>
                </div>
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
                    redirectTo('/profile/' + this.profile.slug);
                }
            }
        }
    }
</script>
