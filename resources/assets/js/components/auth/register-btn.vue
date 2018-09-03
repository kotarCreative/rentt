<template>
  <button class="btn" @click="register">Become a {{ type == 'landlord' ? 'Landlord' : 'Tenant' }}</button>
</template>

<script>
    export default {
      name: 'register-btn',

      props: {
        type: {
          type: String
        }
      },

      methods: {
          register() {
            this.$root.$refs.header.$refs.loginModal.$data.show = 'account';
            this.$modals.show('login');
          }
      }
    }
</script>
