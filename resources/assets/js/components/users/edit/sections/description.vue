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
                <span class="word-count">{{ user.description ? 500 - user.description.length : 500 }}</span>
            </div>
        </div>
        <div class="form-group">
            <label for="languages">Spoken Languages</label>
            <v-select class="form-control"
                      name="languages"
                      v-model="user.languages"
                      :options="languages"
                      :searchable="false"
                      :clearable="false"
                      label="name"
                      value="id"
                      placeholder="none"
                      multiple>
            </v-select>
        </div>
        <template v-if="user.role === 'tenant'">
          <div class="section-spacer"></div>
          <h2>Connected Accounts</h2>
          <div class="form-group">
              <label for="linked-in-url">LinkedIn Profile Url<sup v-if="hasError('linked_in_url')" class="form-errors">*</sup></label>
              <input
                  class="form-control full-width"
                  type="text"
                  name="linked-in-url"
                  placeholder="Paste your profile url here"
                  v-model="user.linked_in_url"
                  @input="removeError('linked_in_url', $event)"
              />
          </div>
          <div class="form-group">
              <label for="airbnb-url">Airbnb Profile Url<sup v-if="hasError('airbnb_url')" class="form-errors">*</sup></label>
              <input
                  class="form-control full-width"
                  type="text"
                  name="airbnb-url"
                  placeholder="Paste your profile url here"
                  v-model="user.airbnb_url"
                  @input="removeError('airbnb_url', $event)"
              />
          </div>
        </template>
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
