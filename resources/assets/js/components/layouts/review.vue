<template>
    <div class="review-wrapper">
        <div class="review-header">
            <div class="reviewer-profile-picture">
                <img v-if="review.reviewer_profile_picture" src="review.reviewer_profile_picture" :title="review.reviewer_first_name + ' profile picture'" :alt="review.reviewer_first_name + ' profile picture'" width="50" height="50">
                <img v-else src="/imgs/profile.png" title="Profile Picture" alt="Empty profile picture" width="50" height="50">
            </div>
            <div class="reviewer-info">
                <h5><b>{{ review.reviewer_first_name }}</b> <span class="secondary">&#45; {{ review.status.split('-').join(' ') }}</span></h5>
                <h5>{{ new Date(review.created_at).toFormattedString('M Y') }}</h5>
            </div>
        </div>
        <p class="review-message">{{ message }} <button class="link" @click="showAll = !showAll">{{ showAll ? 'less' : 'more' }}</button></p>
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
                if (this.showAll) {
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
