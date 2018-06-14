<template>
    <vue-modal name="login">
            <h2 slot="header">{{ show == 'login' ? 'Login' : 'Create Account' }}</h2>
            <login-form v-if="show == 'login'" @createAccount="toggleView('account')"></login-form>
            <account-creation-form v-if="show == 'account'" @login="toggleView('login')"></account-creation-form>
        </vue-modal>
</template>

<script>
    import accountCreationForm from './account-creation-form';
    import LoginForm from './login-form';

    export default {
        name: 'login-modal',

        components: {
            accountCreationForm,
            LoginForm
        },

        data: () => ({
            show: 'login'
        }),

        methods: {
            toggleView(view) {
                this.show = view;
            }
        }
    }
</script>
