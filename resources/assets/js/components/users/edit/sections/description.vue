<template>
    <div id="profile-description-wrapper" class="creation-section-wrapper">
        <h2>Description</h2>
        <div class="form-group">
            <div class="text-area">
                <textarea
                    class="form-control"
                    :class="{ 'has-error': hasError('description') }"
                    v-model="user.description"
                    maxlength="500"
                    placeholder="Tell us a bit about yourself..."
                    @input="removeError('description', $event)"></textarea>
                <span class="word-count">500</span>
            </div>
        </div>
        <div class="form-errors" v-if="hasErrors()">
            <sup>*</sup>Please Complete Required Fields
        </div>
    </div>
</template>

<script>
    import ErrorMixins from '../../../../mixins/errorMixins';

    export default {
        name: 'profile-description-form',

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