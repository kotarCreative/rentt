<template>
    <vue-modal name="login" transition-name="zoom-in">
            <h2 slot="header">{{ headerHtml }}</h2>
            <login-form v-if="show == 'login'" @createAccount="toggleView('account')" @forgotPassword="toggleView('forgot')"></login-form>
            <account-creation-form v-if="show == 'account'" @login="toggleView('login')"></account-creation-form>
            <forgot-password-form v-if="show == 'forgot'" @login="toggleView('login')"></forgot-password-form>
        </vue-modal>
</template>

<script>
    import accountCreationForm from './account-creation-form';
    import forgotPasswordForm from './forgot-password-form';
    import LoginForm from './login-form';

    export default {
        name: 'login-modal',

        components: {
            accountCreationForm,
            forgotPasswordForm,
            LoginForm
        },

        data: () => ({
            show: 'login'
        }),

        computed: {
            headerHtml() {
                switch (this.show) {
                    case 'login':
                        return 'Login';
                    case 'account':
                        return 'Create Account';
                    case 'forgot':
                        return 'Forgot Password';
                }
            }
        },

        methods: {
            toggleView(view) {
                this.show = view;
            }
        }
    }
</script>
