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
                <span class="word-count">{{ 500 - user.description.length }}</span>
            </div>
        </div>
        <div class="form-group">
            <label for="languages">Spoken Languages</label>
            <v-select class="form-control"
                      name="languages"
                      v-model="user.languages"
                      :options="languages"
                      label="name"
                      value="id"
                      placeholder="none"
                      multiple>
            </v-select>
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

        created() {
            this.$store.dispatch('users/languages');
        },

        computed: {
            languages() {
                return this.$store.getters['users/languages'];
            },

            user() {
                return this.$store.getters['users/active'];
            }
        },
    }
</script>
