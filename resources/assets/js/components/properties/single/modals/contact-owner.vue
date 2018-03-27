<template>
    <vue-modal name="contact-owner" :on-close="closeModal" size="large" class="contact-owner-modal">
        <div v-if="!is_successful">
            <div class="contact-preferences">
                <div class="contacts">
                    <h2>Contact Owner</h2>
                    <div class="form-group">
                        <label for="phone-number">Phone Number (optional)</label>
                        <input type="text"
                               class="form-control"
                               name="phone-number"
                               id="phone-number"
                               v-model="phoneNum"
                               placeholder="xxx-xxx-xxxx">
                    </div>
                    <div class="form-group">
                        <label for="contact-form">Preferred Method of Contact</label>
                        <v-checkbox v-model="contactForm"
                            name="contact-form"
                            :options="contactOptions"
                            type="radio">
                            <span slot="label" slot-scope="{ option }">{{ option.label }}</span>
                        </v-checkbox>
                        <!--<v-select name="contact-form"
                                  class="form-control no-indicator"
                                  id="contact-form"
                                  v-model="contactForm"
                                  :options="contactOptions">
                        </v-select>-->
                    </div>
                </div>
                <div class="contact-icon-wrapper">
                    <img src="/imgs/paper-airplane.png" width="100%">
                </div>
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
                <button class="btn" @click="send">Send</button>
            </div>
        </div>
        <div v-else>
            <h2>Message Sent!</h2>
            <p>Your message has been sent to the owner. They should be in touch with you shortly.</p>
            <a class="btn" href="/properties">Continue Searching</a>
        </div>
    </vue-modal>
</template>

<script>
    import errorMixins from '../../../../mixins/errorMixins';

    export default {
        name: 'contact-owner-modal',

        mixins: [errorMixins],

        data: () =>({
            contactForm: 'Email',
            contactOptions: [
                {
                    val: 'Phone',
                    label: 'Phone'
                },
                {
                    val: 'Email',
                    label: 'Email'
                }
            ],
            message: null,
            phoneNum: null,
            errorModel: 'properties',
            is_successful: false
        }),

        methods: {
            clearForm() {
                this.contactForm = 'Email';
                this.message = null;
                this.phoneNum = null;
                this.is_successful = false;
            },

            closeModal() { this.clearForm() },

            send() {
                let params = {
                    contact_form: this.contactForm,
                    message: this.message,
                    phone_num: this.phoneNum
                };
                this.$store.dispatch('properties/contactOwner', params)
                    .then(r => this.is_successful = true);
            }
        }
    }
</script>