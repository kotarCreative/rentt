<template>
    <vue-modal name="review-user" :on-close="closeModal" class="review-user-modal">
        <h2 slot="header"> {{ is_successful ? 'Review Posted!' : 'Post a Review' }}</h2>
        <div v-if="!is_successful">
            <div class="status">
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
                    <div class="form-errors" v-if="hasError('message')">
                        {{ showError('message') }}
                    </div>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn" @click="send">Post Review</button>
            </div>
        </div>
        <div v-else>
            <p>Reviews are what make this site different from the other guys. Thanks for helping improve this community!</p>
            <a class="btn" @click="closeModal">You're Welcome</a>
        </div>
    </vue-modal>
</template>

<script>
    import errorMixins from '../../../../mixins/errorMixins';

    export default {
        name: 'review-user-modal',

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

            closeModal() {
                this.clearForm();
                this.is_successfull = false;
                this.$modals.hide
            },

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
