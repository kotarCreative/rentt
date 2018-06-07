<template>
    <vue-modal name="contact-user" :on-close="closeModal" class="contact-user-modal">
        <h2 slot="header">{{ is_successful ? type.capitalizeAll() + ' Contacted!' : 'Contact ' + type.capitalizeAll()</h2>
        <div v-if="!is_successful">
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
                <button class="btn" @click="send">Send</button>
            </div>
        </div>
        <div v-else>
            <p>The {{ type.capitalizeAll() }} will recieve an email from us shortly. We have included your email so that they can contact you back directly.</p>
            <a class="btn" @click="closeModal">Ok</a>
        </div>
    </vue-modal>
</template>

<script>
    import errorMixins from '../../../../mixins/errorMixins';

    export default {
        name: 'contact-user-modal',

        mixins: [errorMixins],

        props: {
            type: {
                type: String,
                validator(val) {
                    return val === 'landlord' || val === 'reference';
                }
            },

            id: {
                type: Number,
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
                this.$modals.hide('contact-user');
            },

            send() {
                let params = {
                    id: this.id,
                    type: this.type,
                    message: this.message
                };
                this.$store.dispatch('users/contact', params)
                    .then(r => this.is_successful = true);
            }
        }
    }
</script>
