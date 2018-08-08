<template>
    <div class="reference-wrapper">
        <div class="reference-header">
            <div class="reference-user">
                {{ reference.first_name }} {{ reference.last_name }}
            </div>
            <div class="verification-notice">
                <div v-if="reference.denied_at" class="denied">Denied</div>
                <div v-else-if="!reference.verified" class="not-verified">Not Verified</div>
                <div v-else class="verified">Verified</div>
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
    export default {
        name: 'reference-display',

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
