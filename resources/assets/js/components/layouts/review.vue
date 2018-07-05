<template>
    <div class="review-wrapper">
        <div class="review-header">
            <div class="reviewer-profile-picture">
                <img v-if="review.reviewer_profile_picture"
                     :src="'/profile-pictures/' + review.reviewer_profile_picture"
                     :title="review.reviewer_first_name + ' profile picture'"
                     :alt="review.reviewer_first_name + ' profile picture'"
                     width="50"
                     height="50"
                     class="profile-picture">
                <img v-else src="/imgs/profile.png" title="Profile Picture" alt="Empty profile picture" width="50" height="50">
            </div>
            <div class="reviewer-info">
                <h5><b>{{ review.reviewer_first_name }}</b> <span class="secondary" v-if="review.status">&#45; {{ review.status.split('-').join(' ') }}</span></h5>
                <h6>{{ new Date(review.created_at).format('M Y') }}</h6>
            </div>
        </div>
        <p class="review-message">{{ message }} <button class="link" @click="showAll = !showAll" v-if="review.message.length > 200">{{ showAll ? 'less' : 'more' }}</button></p>
    </div>
</template>

<script>
    export default {
        name: 'review',

        props: {
            review: {
                type: Object,
                required: true
            }
        },

        data: () => ({
            showAll: false
        }),

        computed: {
            message() {
                if (this.showAll || this.review.message.length < 200) {
                    return this.review.message;
                } else {
                    return this.review.message.substring(0, 200) + '...';
                }
            }
        }
    }
</script>

<style lang="sass">
    .review-wrapper
        margin: 20px 0px

        .review-header
            display: flex
            justify-content: flex-start

            h5
                margin: 0px

            .reviewer-info
                align-self:     center
                margin-left:    10px
</style>
