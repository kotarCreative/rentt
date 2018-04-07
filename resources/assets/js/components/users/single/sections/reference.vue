<template>
    <div class="reference-wrapper">
        <div class="reference-user">
            {{ reference.first_name }} {{ reference.last_name }}
        </div>
        <div class="reference-relation">
            <b>Relation:</b> {{ reference.relationship.capitalizeAll() }}
        </div>
        <button class="btn primary" @click="contact">
            Contact Reference
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
