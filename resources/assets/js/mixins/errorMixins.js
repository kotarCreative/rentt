export default {
    computed: {
        errors() {
            return this.$store.getters.errors;
        }
    },

    methods: {
        checkGeneralError(error) {
            if (this.errors && this.errors[this.errorModel]) {
                var keys = Object.keys(this.errors[this.errorModel].errors);
                return keys.some(k => {
                    return k.search(error + '.*') > -1;
                });
            } else {
                return false;
            }
        },

        hasError(error) {
            if (this.errors[this.errorModel] && this.errors[this.errorModel].errors) {
                return true;
            } else {
                return false;
            }
        },

        removeError(input, e) {
            this.$store.commit('removeError', { model: 'users', error: input });

            if (e.target) {
                e.target.classList.remove('has-error');
            } else {
                console.log(e);
            }
        },

        showError(error) {
            return this.errors[this.errorModel].errors[error][0];
        }
    }
}
