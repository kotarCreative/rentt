<template>
  <div id="profile-details-wrapper" class="creation-section-wrapper">
    <h2>Personal Habits</h2>
    <div class="form-group">
        <label for="smoker">Do you smoke?<sup v-if="hasError('is_a_smoker')" class="form-errors">*</sup></label>
        <v-select class="form-control single"
                  name="smoker"
                  v-model="smoker"
                  :options="smokingOptions"
                  :searchable="false"
                  :clearable="false">
        </v-select>
    </div>
  </div>
</template>

<script>
  import ErrorMixins from '../../../../mixins/errorMixins';

  export default {
    name: 'profile-details-form',

    mixins: [ErrorMixins],

    data: _ => ({
      errorModel: 'users',

      smokingOptions: [
        {
          label: 'Yes',
          value: 1
        },
        {
          label: 'No',
          value: 0
        }
      ]
    }),

    computed: {
        smoker: {
          get() {
            var status = this.smokingOptions.find(o => o.value === this.user.is_a_smoker);
            if (status) {
              return status;
            } else {
              return null;
            }
          },
          set(option) {
            this.user.is_a_smoker = option.value;
          }
        },

        user() {
            return this.$store.getters['users/active'];
        }
    },
  }
</script>
