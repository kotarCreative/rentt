<template>
    <div class="profile-info-wrapper">
        <div class="profile-info-header">
            <div class="profile-picture-wrapper">
                <img v-if="profile.profile_picture" src="profile.profile_picture" :title="profile.first_name + ' profile picture'" :alt="profile.first_name + ' profile picture'" width="80" height="80">
                <img v-else src="/imgs/profile.png" title="Profile Picture" alt="Empty profile picture" width="80" height="80">
            </div>
            <div class="profile-info">
                <h3>{{ nameHeader }}</h3>
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
            nameHeader() {
                switch (this.type) {
                    case 'property':
                        return 'Listed By ' + this.profile.first_name;
                }
            }
        }
    }
</script>
