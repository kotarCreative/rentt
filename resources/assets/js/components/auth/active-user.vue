<template>
    <div class="hidden"></div>
</template>

<script>
    export default {
        name: 'active-user',

        props: {
            role: {
                required: true,
                validator(val) {
                    return val === 'tenant' || val === 'landlord';
                }
            },

            user: {
                required: true
            }
        },

        created() {
            this.$store.commit('users/setActive', this.user);
            this.$store.commit('users/updateActive', { role: this.role });
        }
    }
</script>