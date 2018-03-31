<template>
    <div id="profile-info-wrapper" class="creation-section-wrapper">
        <h2>Basic Info</h2>
        <div class="form-group">
            <label for="first-name">First Name<sup v-if="hasError('first_name')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="text"
                name="first-name"
                placeholder="ie. Jules"
                v-model="user.first_name"
                @input="removeError('first_name', $event)"
            />
        </div>
        <div class="form-group">
            <label for="last-name">Last Name<sup v-if="hasError('last_name')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="text"
                name="last-name"
                placeholder="ie. Verne"
                v-model="user.last_name"
                @input="removeError('last_name', $event)"
            />
        </div>
        <div class="form-group">
            <label for="email">Email<sup v-if="hasError('email')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="text"
                name="email"
                placeholder="ie. captainnemo@thenautilus.com"
                v-model="user.email"
                @input="removeError('email', $event)"
            />
        </div>
        <div class="form-group">
            <label for="password">Password<sup v-if="hasError('password')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="password"
                name="password"
                placeholder="mysteriousIsland"
                v-model="user.password"
                @input="removeError('password', $event)"
            />
        </div>
        <div class="form-group">
            <label for="password">Confirm Password<sup v-if="hasError('password')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="password"
                name="confirmed"
                placeholder="mysteriousIsland"
                v-model="user.confirmed"
                @input="removeError('password_confirmation', $event)"
            />
        </div>
        <div class="form-errors" v-if="hasErrors()">
            <sup>*</sup>{{ errorMessage }}
        </div>
    </div>
</template>

<script>
    import ErrorMixins from '../../../../mixins/errorMixins';

    export default {
        name: 'profile-basic-info-form',

        mixins: [ ErrorMixins ],

        computed: {
            errorMessage() {
                if (this.hasError('email')) {
                    return this.showError('email');
                }

                if (this.hasError('password')) {
                    return 'Your password and confirm do not match';
                }

                if (this.hasError('first_name')) {
                    return 'Please fill out required fields';
                }
            },

            user() {
                return this.$store.getters['users/active'];
            }
        },
    }
</script>