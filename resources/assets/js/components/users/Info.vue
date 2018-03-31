<template>
    <div class="profile-info-wrapper">
        <div class="profile-info-header">
            <div class="profile-picture-wrapper" v-if="type === 'property'">
                <img v-if="profile.profile_picture" src="profile.profile_picture" :title="profile.first_name + ' profile picture'" :alt="profile.first_name + ' profile picture'" width="80" height="80">
                <img v-else src="/imgs/profile.png" title="Profile Picture" alt="Empty profile picture" width="80" height="80">
            </div>
            <div class="profile-info">
                <div v-html="nameHeader"></div>
                <h5>{{ profile.location }} &#45; Joined in {{ new Date(profile.created_at).format('M Y') }}</h5>
                <h5 v-if="profile.languages">Languages: </h5>
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
                switch (this.type) {
                    case 'property':
                        return '<h3>Listed By ' + this.profile.first_name + '</h3>';

                    case 'profile':
                        if (this.activeUser.id !== this.profile.id) {
                            return '<h1>Hi, I\'m ' + this.profile.first_name + '</h1>';
                        } else {
                            return '<h1>Hi, I\'m ' + this.profile.first_name + '&nbsp;<a class="link" href="/profile/edit">edit</a></h1>';
                        }
                }
            }
        }
    }
</script>
