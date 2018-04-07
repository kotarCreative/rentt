<template>
    <vue-modal name="review-user" :on-close="closeModal" class="review-user-modal">
        <div v-if="!is_successful">
            <div class="status">
                <h2>Post a Review</h2>
                <p>Help the community learn more about this person by posting a review.</p>
            </div>
            <div class="contact-message-wrapper">
                <div class="form-group">
                    <div class="text-area">
                        <textarea
                            class="form-control"
                            :class="{ 'has-error': hasError('message') }"
                            v-model="message"
                            maxlength="500"
                            placeholder="Write your message here..."
                            @input="removeError('message', $event)"></textarea>
                        <span class="word-count">500</span>
                    </div>
                    <div class="input-error" v-if="hasError('message')">
                        {{ showError('message') }}
                    </div>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn" @click="send">Post Review</button>
            </div>
        </div>
        <div v-else>
            <h2>Review Posted!</h2>
            <p>Reviews are what make this site different from the other guys. Thanks for helping improve this community!</p>
            <a class="btn" @click="$modals.hide('review-user')">You're Welcome.</a>
        </div>
    </vue-modal>
</template>

<script>
    import errorMixins from '../../../../mixins/errorMixins';

    export default {
        name: 'review-property-modal',

        mixins: [errorMixins],

        props: {
            user: {
                type: Object,
                required: true
            }
        },

        data: () =>({
            message: null,
            errorModel: 'users',
            is_successful: false,
        }),

        methods: {
            clearForm() {
                this.message = null;
                this.is_successful = false;
            },

            closeModal() { this.clearForm() },

            send() {
                let params = {
                    status: this.status,
                    message: this.message
                };
                this.$store.dispatch('users/review', { params: params, id: this.user.id })
                    .then(r => this.is_successful = true);
            }
        }
    }
</script>
