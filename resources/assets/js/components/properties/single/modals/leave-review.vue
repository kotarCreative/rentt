<template>
    <vue-modal name="review-property" :on-close="closeModal" class="review-property-modal">
        <div v-if="!is_successful">
            <div class="status">
                <h2>Post a Review</h2>
                <label>When did you see this property?</label>
                <v-checkbox v-model="status"
                            name="status"
                            :options="statuses"
                            type="radio">
                    <span slot="label" slot-scope="{ option }">{{ option.label }}</span>
                </v-checkbox>
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
            <a class="btn" href="/properties">Continue Searching</a>
        </div>
    </vue-modal>
</template>

<script>
    import errorMixins from '../../../../mixins/errorMixins';

    export default {
        name: 'review-property-modal',

        mixins: [errorMixins],

        data: () =>({
            status: 'showing',
            message: null,
            errorModel: 'properties',
            is_successful: false,
            statuses: [
                {
                    val: 'lived',
                    label: 'I lived there'
                },
                {
                    val: 'showing',
                    label: 'I went for a showing'
                }
            ]
        }),

        methods: {
            clearForm() {
                this.status = 'lived';
                this.message = null;
                this.is_successful = false;
            },

            closeModal() { this.clearForm() },

            send() {
                let params = {
                    status: this.status,
                    message: this.message,
                };
                this.$store.dispatch('properties/review', params)
                    .then(r => this.is_successful = true);
            }
        }
    }
</script>