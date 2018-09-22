<template>
  <div id="profile-details-wrapper" class="creation-section-wrapper">
    <h2>Personal Details</h2>
    <div class="form-group">
      <label for="gender">Gender</label>
      <v-select class="form-control single" name="gender" v-model="user.gender" :options="genders" placeholder="Select">
      </v-select>
    </div>
    <div class="form-group">
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
      <label for="smoker">Do you smoke?<sup v-if="hasError('is_a_smoker')" class="form-errors">*</sup></label>
      <v-select class="form-control single" name="smoker" v-model="smoker" :options="booleanOptions" :searchable="false" :clearable="false">
      </v-select>
    </div>
    <div class="form-group">
      <label for="student">Are you a student?<sup v-if="hasError('is_a_student')" class="form-errors">*</sup></label>
      <v-select class="form-control single" name="student" v-model="student" :options="booleanOptions" :searchable="false" :clearable="false">
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
      birthday: {
        month: null,
        day: null,
        year: null
      },
      booleanOptions: [{
          label: 'Yes',
          value: 1
        },
        {
          label: 'No',
          value: 0
        }
      ],
      days: [],
      employments: ['Employed', 'Unemployed', 'Student'],
      errorModel: 'users',
      genders: ['Male', 'Female', 'Other'],
      months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      years: []
    }),

    computed: {
      pets() {
        return this.$store.getters['users/active'].pets;
      },

      smoker: {
        get() {
          var status = this.booleanOptions.find(o => o.value === this.user.is_a_smoker);
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

      student: {
        get() {
          var status = this.booleanOptions.find(o => o.value === this.user.is_a_student);
          if (status) {
            return status;
          } else {
            return null;
          }
        },
        set(option) {
          this.user.is_a_student = option.value;
        }
      },

      user() {
        return this.$store.getters['users/active'];
      }
    },

    mounted() {
      this.calculateDays();
      this.calculateYears();
      this.populateBirthday();
    },

    methods: {
      addPet() {
        this.$store.commit('users/addPet');
      },

      calculateDays() {
        let dayCount = 31,
          days = [];
        const monthIdx = this.months.indexOf(this.birthday.month),
          today = new Date();
        if (monthIdx) {
          dayCount = new Date(today.getFullYear(), monthIdx + 1, 0).getDate();
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

      populateBirthday() {
        if (this.user.birthday) {
          let date = new Date(this.user.birthday);
          this.birthday.year = String(date.getFullYear());
          this.birthday.month = this.months[date.getMonth()];
          this.birthday.day = String(date.getDate());
        }
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
