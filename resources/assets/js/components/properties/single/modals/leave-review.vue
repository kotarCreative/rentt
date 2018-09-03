<template>
    <vue-modal name="review-property" :on-close="closeModal" class="review-property-modal">
        <h2 slot="header"> {{ is_successful ? 'Review Posted!' : 'Post a Review' }}</h2>
        <div v-if="!is_successful">
            <div class="status">
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
                        <span class="word-count">{{ 500 - message.length }}</span>
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
            status: 'walk-through',
            message: '',
            errorModel: 'properties',
            is_successful: false,
            statuses: [
                {
                    val: 'lived-there',
                    label: 'I lived there'
                },
                {
                    val: 'walk-through',
                    label: 'I went for a showing'
                }
            ]
        }),

        methods: {
            clearForm() {
                this.status = 'walk-through';
                this.message = '';
                this.is_successful = false;
            },

            closeModal() {
                this.clearForm();
                this.is_successfull = false;
                this.$modals.hide('review-property');
            },

            send() {
                let params = {
                    status: this.status,
                    message: this.message,
                };
                this.$store.dispatch('properties/review', params)
                    .then(r => {
                        this.is_successful = true;
                        if (typeof mixpanel !== 'undefined') {
                            mixpanel.track('Review property');
                        }
                    });
            }
        }
    }
</script>
