<template>
    <div class="rental-history-wrapper">
        <div class="rental-history-header">
            <div class="rental-period">
                {{ new Date(history.started_on).format('m Y') }} &#45; {{ new Date(history.ended_on).format('m Y') }}
            </div>
            <div class="verification-notice">
                <div v-if="history.denied_at" class="denied">Denied<info-icon /></div>
                <div v-else-if="!history.verified" class="not-verified">Not Verified<info-icon /></div>
                <div v-else class="verified">Verified<info-icon /></div>
            </div>
        </div>
        <div class="rental-location">
            {{ history.location }}
        </div>
        <div class="landlord-details">
            <b>Landlord: </b> {{ history.landlord_first_name }} {{ history.landlord_last_name }}
        </div>
        <!--<div class="landlord-details" v-else="!verified">
            <b>Landlord: </b> <a class="link" :href="'/profile/' + history.landlord_id">{{ history.landlord_first_name }} {{ history.landlord_last_name }}</a>
        </div>-->
        <button class="btn primary" @click="contact">
            Contact
        </button>
    </div>
</template>

<script>
    import InfoIcon from '../../../layouts/info-icon';

    export default {
        name: 'rental-history-display',

        components: {
            InfoIcon
        },

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
