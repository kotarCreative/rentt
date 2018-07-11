<template>
    <div id="profile-accounts-wrapper" class="creation-section-wrapper">
        <h2>Connected Accounts</h2>
        <div class="form-group">
            <label for="linked-in-url">LinkedIn Profile Url<sup v-if="hasError('linked_in_url')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="text"
                name="linked-in-url"
                placeholder="Paste your profile url here"
                v-model="user.linked_in_url"
                @input="removeError('linked_in_url', $event)"
            />
        </div>
        <div class="form-group">
            <label for="airbnb-url">AirBnB Profile Url<sup v-if="hasError('airbnb_url')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="text"
                name="airbnb-url"
                placeholder="Paste your profile url here"
                v-model="user.airbnb_url"
                @input="removeError('airbnb_url', $event)"
            />
        </div>
        <div class="form-errors" v-if="hasErrors()">
            <sup>*</sup>Please Complete Required Fields
        </div>
    </div>
</template>

<script>
    import ErrorMixins from '../../../../mixins/errorMixins';

    export default {
        name: 'profile-accounts-form',

        mixins: [ ErrorMixins ],

        data: () => ({
            errorModel: 'users'
        }),

        computed: {
            user() {
                return this.$store.getters['users/active'];
            }
        },
    }
</script>
