<template>
  <div id="profile-info-wrapper" class="creation-section-wrapper">
    <h2>Basic Info</h2>
    <div class="form-group">
      <label for="first-name">First Name<sup v-if="hasError('first_name')" class="form-errors">*</sup></label>
      <input class="form-control" type="text" name="first-name" placeholder="ie. Jules" v-model="user.first_name" @input="removeError('first_name', $event)" />
    </div>
    <div class="form-group">
      <label for="last-name">Last Name<sup v-if="hasError('last_name')" class="form-errors">*</sup></label>
      <input class="form-control" type="text" name="last-name" placeholder="ie. Verne" v-model="user.last_name" @input="removeError('last_name', $event)" />
    </div>
    <div v-if="user.role === 'tenant'" class="form-group">
      <label for="gender">Gender</label>
      <v-select class="form-control single" name="gender" v-model="user.gender" :options="genders" placeholder="Select">
      </v-select>
    </div>
    <div v-if="user.role === 'tenant'" class="form-group">
      <label for="birthday">Birthday</label>
      <div class="birthday-selector">
        <v-select id="birthday-month" class="form-control single" name="birthday-month" v-model="birthday.month" :options="months" placeholder="Month">
        </v-select>
        <v-select id="birthday-day" class="form-control single" name="birthday-day" v-model="birthday.day" :options="days" placeholder="Day">
        </v-select>
        <v-select id="birthday-year" class="form-control single" name="birthday-year" v-model="birthday.year" :options="years" placeholder="Year">
        </v-select>
      </div>
    </div>
    <div class="form-group">
      <label for="subdivision">Province/State</label>
      <v-select class="form-control single" name="subdivision" v-model="subdivision" :options="subdivisions" label="name" placeholder="Anywhere" @input="fetchCities">
      </v-select>
    </div>
    <div class="form-group">
      <label for="city">City/Town<sup v-if="hasError('city_id')" class="form-errors">*</sup></label>
      <v-select class="form-control single" name="city" v-model="city" :options="cities" label="name" placeholder="Anywhere">
      </v-select>
    </div>
    <!--<div class="form-group">
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
        </div>-->
    <div class="form-errors" v-if="hasErrors()">
      <sup>*</sup>{{ errorMessage }}
    </div>
  </div>
</template>

<script>
  import ErrorMixins from '../../../../mixins/errorMixins';

  export default {
    name: 'profile-basic-info-form',

    mixins: [ErrorMixins],

    data: () => ({
      birthday: {
        month: null,
        day: null,
        year: null
      },
      country: {
        id: 1,
        name: 'Canada'
      },
      days: [],
      errorModel: 'users',
      genders: ['Male', 'Female', 'Other'],
      months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      years: []
    }),

    mounted() {
      this.populateSubdivisions();
      this.fetchCities(true);
      this.calculateDays();
      this.calculateYears();
      this.populateBirthday();
    },

    computed: {
      city: {
        get() {
          var option = this.cities.find(s => s.id == this.user.city_id);
          return option;
        },
        set(val) {
          this.$store.commit('users/updateActive', {
            city_id: val ? val.id : null
          });
        }
      },

      cities() {
        return this.$store.getters['properties/cities'];
      },

      countries() {
        return this.$store.getters['properties/countries'];
      },

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

      subdivision: {
        get() {
          var option = this.subdivisions.find(s => s.id == this.user.subdivision_id);
          return option;
        },
        set(val) {
          this.$store.commit('users/updateActive', {
            subdivision_id: val ? val.id : null
          });
        }
      },

      subdivisions() {
        return this.$store.getters['properties/subdivisions'];
      },

      user() {
        return this.$store.getters['users/active'];
      }
    },

    methods: {
      calculateDays() {
        let dayCount = 31,
            days = [];
        const monthIdx = this.months.indexOf(this.birthday.month),
              today = new Date();
        if (monthIdx) {
          dayCount = new Date(today.getFullYear(), monthIdx+1, 0).getDate();
        }

        for (let i = 1; i <= dayCount; i++) {
          days.push(String(i));
        }

        this.days = days;
      },

      calculateYears() {
        let current = new Date().getFullYear(),
            years = [];

        for (let i = current - 18; i > current - 70; i--) {
          years.push(String(i));
        }

        this.years = years;
      },

      fetchCities(dontReset) {
        if (!dontReset) {
          this.$store.commit('users/updateActive', {
            city_id: null
          });
        }
        this.$store.dispatch('properties/getCities', this.user.subdivision_id);
      },

      populateBirthday() {
        if (this.user.birthday) {
          let date = new Date(this.user.birthday);
          this.birthday.year = String(date.getFullYear());
          this.birthday.month = this.months[date.getMonth()];
          this.birthday.day = String(date.getDate());
        }
      },

      populateSubdivisions() {
        this.$store.dispatch('properties/getSubdivisions', this.country.id);
      }
    },

    watch: {
      birthday: {
        handler(val) {
          this.user.birthday = val.year + '-' + (this.months.indexOf(val.month) + 1) + '-' + val.day;
        },
        deep: true
      },

      'birthday.month'(val) {
        this.calculateDays();
      }
    }
  }

</script>

<style lang="scss">
  .birthday-selector {
    display: flex;

    #birthday- {
      &day {
        width: 70px !important;
        margin-right: 2px;
      }

      &month {
        width: 120px !important;
        margin-right: 2px;
      }

      &year {
        width: 75px !important;
        margin-right: 2px;
      }
    }
  }
</style>
