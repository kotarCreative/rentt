<template>
    <div class="rental-history-wrapper">
        <div class="rental-history-header">
            <div class="rental-period">
                {{ new Date(history.started_on).format('m Y') }} &#45; {{ new Date(history.ended_on).format('m Y') }}
            </div>
            <div class="verification-notice">
                <div v-if="history.denied_at" class="denied">Denied<info-icon v-tooltip="'This person has refused your request <br> and will not be shown on your profile.'" /></div>
                <div v-else-if="!history.verified" class="not-verified">Not Verified<info-icon v-tooltip="'This person has not confirmed your request.<br> Maybe check in with them.'" /></div>
                <div v-else class="verified">Verified<info-icon v-tooltip="'This person has confirmed through email that <br> they were this tenants landlord.'" /></div>
            </div>
        </div>
        <div class="rental-location">
            {{ history.location }}
        </div>
        <div class="landlord-details">
            <b>Landlord: </b> {{ history.landlord_first_name }} {{ history.landlord_last_name }}
        </div>
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
