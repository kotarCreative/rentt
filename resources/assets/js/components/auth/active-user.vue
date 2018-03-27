<template>
    <div class="hidden"></div>
</template>

<script>
    export default {
        name: 'active-user',

        props: {
            user: {
                required: true
            }
        },

        created() {
            this.$store.commit('users/setActive', this.user);
        }
    }
</script>