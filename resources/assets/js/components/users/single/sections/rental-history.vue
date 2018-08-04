<template>
    <div class="rental-history-wrapper">
        <div class="rental-period">
            {{ new Date(history.started_on).format('m Y') }} &#45; {{ new Date(history.ended_on).format('m Y') }}
        </div>
        <div class="rental-location">
            {{ history.location }}
        </div>
        <div class="landlord-details" v-if="!history.verified">
            <b>Landlord: </b> {{ history.landlord_first_name }} {{ history.landlord_last_name }}
        </div>
        <div class="landlord-details" v-else="!verified">
            <b>Landlord: </b> <a class="link" :href="'/profile/' + history.landlord_id">{{ history.landlord_first_name }} {{ history.landlord_last_name }}</a>
        </div>
        <button class="btn primary" @click="contact">
            Contact
        </button>
    </div>
</template>

<script>
    export default {
        name: 'rental-history-display',

        props: {
            history: {
                type: Object,
                required: true
            }
        },

        methods: {
            contact() {
                return this.$emit('contactUser', { id: this.history.id, type: 'landlord' } );
            }
        }
    }
</script>
