<template>
    <div class="reference-wrapper">
        <div class="reference-header">
            <div class="reference-user">
                {{ reference.first_name }} {{ reference.last_name }}
            </div>
            <div class="verification-notice">
                <div v-if="reference.denied_at" class="denied">Denied<info-icon /></div>
                <div v-else-if="!reference.verified" class="not-verified">Not Verified<info-icon v-tooltip="'This person has not confirmed that<br> they are willing to be a reference.<br> Maybe check in with them.'" /></div>
                <div v-else class="verified">Verified<info-icon v-tooltip="'This person has confirmed through email that <br> they are willing to be a reference.'" /></div>
            </div>
        </div>
        <div class="reference-relation">
            <b>Relation:</b> {{ reference.relationship.capitalizeAll() }}
        </div>
        <button class="btn primary" @click="contact">
            Contact
        </button>
    </div>
</template>

<script>
    import InfoIcon from '../../../layouts/info-icon';

    export default {
        name: 'reference-display',

        components: {
            InfoIcon
        },

        props: {
            reference: {
                type: Object,
                required: true
            }
        },

        methods: {
            contact() {
                this.$emit('contactUser', { id: this.reference.id, type: 'reference' });
            }
        }
    }
</script>
