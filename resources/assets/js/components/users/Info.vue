<template>
    <div class="profile-info-wrapper">
        <div class="profile-picture-wrapper"></div>
        <div class="profile-info">
            <h3>{{ nameHeader }}</h3>
            <h5>{{ profile.location }} &#45; Joined in {{ new Date(profile.created_at).toFormattedString('M Y') }}</h5>
            <h5 v-if="profile.languages">Languages: </h5>
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
