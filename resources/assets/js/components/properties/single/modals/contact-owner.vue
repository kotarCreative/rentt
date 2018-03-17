<template>
    <vue-modal name="contact-owner" :on-close="closeModal" size="large" class="contact-owner-modal">
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
                    <v-select name="contact-form"
                              class="form-control no-indicator"
                              id="contact-form"
                              v-model="contactForm"
                              :options="contactOptions">
                    </v-select>
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
                'Email',
                'Phone'
            ],
            message: null,
            phoneNum: null
        }),

        methods: {
            closeModal() {},

            send() {}
        }
    }
</script>