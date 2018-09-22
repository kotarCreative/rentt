<template>
  <div id="profile-details-wrapper" class="creation-section-wrapper">
    <h2>Personal Details</h2>
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
    <div class="form-group">
      <label for="employment">Employment</label>
      <v-select class="form-control single" name="employment" v-model="user.employment" :options="employments" placeholder="Select...">
      </v-select>
    </div>
    <div class="section-spacer"></div>
    <div class="pets-header">
          <h2>Pets</h2>
          <button class="link" @click="addPet">Add a Pet</button>
    </div>
    <template v-if="pets.length > 0">
        <pet v-for="(pet, idx) in pets" :pet="pet" :idx="idx" :key="idx"></pet>
    </template>
    <p v-else>You have not added any pets yet. Try adding some now if you own one.</p>
  </div>
</template>

<script>
  import ErrorMixins from '../../../../mixins/errorMixins';
  import Pet from './forms/pet';

  export default {
    name: 'profile-details-form',

    mixins: [ErrorMixins],

    components: {
      Pet
    },

    data: _ => ({
      errorModel: 'users',

      employments: [ 'Employed', 'Unemployed', 'Student' ],

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
        pets() {
          return this.$store.getters['users/active'].pets;
        },

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

    methods: {
      addPet() {
          this.$store.commit('users/addPet');
      }
    }
  }
</script>
